class AddressManager {
  constructor(el) {
    this.el = el;
    this.input = this.el.querySelector("input");
    this.suggestionsContainer = this.el.querySelector(".suggestions-container");
    this.listContainer = this.el.querySelector(".address-list");
    this.hiddenInput = this.el.parentElement.parentElement.querySelector(".hidden-address-plus-171 input");
    this.inputDistance = this.el.parentElement.parentElement.querySelector(".cercle_valeur_r_182 input");
    this.mapss = this.el.parentElement.parentElement.querySelector("#mapss");
    this.unitSelect = this.el.parentElement.parentElement.querySelector(".cercle_unit_r_183 select");

    this.hiddenAddressesInput = document.querySelector(".hidden-addresses-input");

    this.map = null;
    this.markers = [];
    this.circle = null;

    this.initMap();
    this.loadAddresses();

    this.input.addEventListener("focus", () => this.openDropdown());
    this.input.addEventListener("input", (e) => this.fetchSuggestions(e));
    document.addEventListener("click", (e) => this.handleOutsideClick(e));
  }

  initMap() {
    if (!this.mapss) {
      console.error("Élément #mapss non trouvé !");
      return;
    }

    this.map = L.map(this.mapss.id).setView([48.8566, 2.3522], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(this.map);

    if (this.inputDistance) {
      this.inputDistance.addEventListener("input", () => this.updateCircleWithDistance());
      this.unitSelect.addEventListener("change", () => this.updateCircleWithDistance());
    }
  }


  // Met à jour le cercle en fonction de la distance sélectionnée
  updateCircleWithDistance() {
    if (!this.circle || this.markers.length === 0) return;

    let distance = parseFloat(this.inputDistance.value);
    let unit = this.unitSelect.value;

    if (isNaN(distance) || distance <= 0) {
      distance = 1; // Valeur par défaut (1 km ou mile)
    }

    // Convertir en mètres (1 mile = 1609.34m, 1 km = 1000m)
    const radiusMeters = unit === "miles" ? distance * 1609.34 : distance * 1000;

    // Mettre à jour le cercle existant avec le nouveau rayon
    this.circle.setRadius(radiusMeters);
  }


  updateMap() {
    this.markers.forEach(marker => this.map.removeLayer(marker));
    this.markers = [];

    let latitudes = [];
    let longitudes = [];

    this.listContainer.querySelectorAll(".address-item").forEach(item => {
      const address = item.dataset.address;
      fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
        .then(response => response.json())
        .then(data => {
          if (data.length > 0) {
            const lat = parseFloat(data[0].lat);
            const lon = parseFloat(data[0].lon);

            const marker = L.marker([lat, lon]).addTo(this.map);
            marker.bindPopup(address);
            this.markers.push(marker);

            latitudes.push(lat);
            longitudes.push(lon);

            if (this.markers.length === this.listContainer.querySelectorAll(".address-item").length) {
              this.updateCircle();
            }
          }
        })
        .catch(error => console.error("Erreur de géocodage:", error));
    });
  }

// Fonction pour dessiner un cercle englobant tous les marqueurs
  updateCircle() {
    if (this.markers.length === 0) return;

    let latitudes = this.markers.map(marker => marker.getLatLng().lat);
    let longitudes = this.markers.map(marker => marker.getLatLng().lng);

    const minLat = Math.min(...latitudes);
    const maxLat = Math.max(...latitudes);
    const minLon = Math.min(...longitudes);
    const maxLon = Math.max(...longitudes);

    // Calcul du centre géographique
    const centerLat = (minLat + maxLat) / 2;
    const centerLon = (minLon + maxLon) / 2;

    // Calcul du rayon maximal en fonction des distances des marqueurs au centre
    const maxDistance = this.getMaxDistance(centerLat, centerLon, latitudes, longitudes);

    // Supprimer l'ancien cercle s'il existe
    if (this.circle) {
      this.map.removeLayer(this.circle);
    }

    // Ajouter un nouveau cercle autour des marqueurs
    this.circle = L.circle([centerLat, centerLon], {
      radius: maxDistance,
      color: "red",
      fillColor: "#f03",
      fillOpacity: 0.2
    }).addTo(this.map);

    // Adapter la vue de la carte pour englober tous les marqueurs et le cercle
    this.map.fitBounds([
      [minLat, minLon],
      [maxLat, maxLon]
    ]);
  }

  getMaxDistance(centerLat, centerLon, latitudes, longitudes) {
    let maxDistance = 0;
    for (let i = 0; i < latitudes.length; i++) {
      const distance = this.getDistanceFromLatLonInMeters(centerLat, centerLon, latitudes[i], longitudes[i]);
      if (distance > maxDistance) {
        maxDistance = distance;
      }
    }
    return maxDistance + 500;
  }

  getDistanceFromLatLonInMeters(lat1, lon1, lat2, lon2) {
    const R = 6371000;
    const dLat = this.deg2rad(lat2 - lat1);
    const dLon = this.deg2rad(lon2 - lon1);
    const a =
      Math.sin(dLat / 2) * Math.sin(dLat / 2) +
      Math.cos(this.deg2rad(lat1)) * Math.cos(this.deg2rad(lat2)) *
      Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
  }

  deg2rad(deg) {
    return deg * (Math.PI / 180);
  }

  openDropdown() {
    this.suggestionsContainer.classList.remove("hidden");
  }

  closeDropdown() {
    this.suggestionsContainer.classList.add("hidden");
  }

  fetchSuggestions(event) {
    const query = event.target.value.trim();
    if (query.length < 3) return;

    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`)
      .then(response => response.json())
      .then(data => this.showSuggestions(data))
      .catch(error => console.error("Erreur de requête:", error));
  }

  showSuggestions(data) {
    this.suggestionsContainer.innerHTML = "";
    data.forEach(place => {
      const suggestion = document.createElement("div");
      suggestion.classList.add("suggestion-item");
      suggestion.textContent = place.display_name;
      suggestion.addEventListener("click", () => this.addAddress(place));
      this.suggestionsContainer.appendChild(suggestion);
    });
  }

  addAddress(place) {
    const existingItems = this.listContainer.querySelectorAll(".address-item");
    const alreadyExists = Array.from(existingItems).some(item => item.dataset.address === place.display_name);

    if (!alreadyExists) {
      const listItem = document.createElement("div");
      listItem.className = "address-item";
      listItem.dataset.address = place.display_name;
      listItem.innerHTML = `
        <div class="address-box-profile">
            <button class="close-btn-profile">✕</button>
            <input type="text" class="address-input-profile" value="${place.display_name}" readonly>
            <p class="link-text-profile">Link this location with the right Profile Page</p>
            <div class="link-container-profile">
                <a href="https://www.homazed.com/" class="main-link-profile">www.homazed.com/</a>
                <span class="sub-link-profile"><input type="text" placeholder="officiel/charly-periu" /> </span>
            </div>
        </div>

      `;

      listItem.querySelector(".close-btn-profile").addEventListener("click", () => {
        listItem.remove();
        this.updateHiddenAddresses();
        this.updateMap();
      });

      this.listContainer.appendChild(listItem);
      this.updateHiddenAddresses();
      this.updateMap();
    }
    this.closeDropdown();
  }

  handleOutsideClick(e) {
    if (!this.el.contains(e.target)) {
      this.closeDropdown();
    }
  }

  updateHiddenAddresses() {
    const addresses = [];
    this.listContainer.querySelectorAll(".address-item").forEach(item => {
      addresses.push(item.dataset.address);
    });
    this.hiddenInput.value = addresses.join("|");
  }

  loadAddresses() {
    const savedAddresses = this.hiddenInput.value.split("|").filter(addr => addr.trim() !== "");
    savedAddresses.forEach(addr => this.addAddress({ display_name: addr }));
  }
}

export default AddressManager;
