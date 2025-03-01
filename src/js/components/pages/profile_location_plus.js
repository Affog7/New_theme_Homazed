class AddressManager {
  constructor(el) {
    this.el = el;
    this.input = this.el.querySelector("input");
    this.suggestionsContainer = this.el.querySelector(".suggestions-container");
    this.listContainer = this.el.querySelector(".address-list");
    this.hiddenInput = this.el.parentElement.parentElement.querySelector(".hidden-address-plus-171 input");
    this.mapss = this.el.parentElement.parentElement.querySelector("#mapss");

    this.hiddenAddressesInput = document.querySelector(".hidden-addresses-input");
    // Initialiser la carte
    this.map = null;
    this.markers = [];
    this.initMap();

    // Charger les adresses si existantes
    this.loadAddresses();

    // Attacher les événements
    this.input.addEventListener("focus", () => this.openDropdown());
    this.input.addEventListener("input", (e) => this.fetchSuggestions(e));
    document.addEventListener("click", (e) => this.handleOutsideClick(e));
  }

  // Initialiser la carte Leaflet
// Initialiser la carte Leaflet
  initMap() {
    if (!this.mapss) {
      console.error("Élément #mapss non trouvé !");
      return;
    }

    this.map = L.map(this.mapss.id).setView([48.8566, 2.3522], 13); // Centrer sur Paris par défaut

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(this.map);
  }


  // Mettre à jour les marqueurs sur la carte
  updateMap() {
    // Supprimer les anciens marqueurs
    this.markers.forEach(marker => this.map.removeLayer(marker));
    this.markers = [];

    // Ajouter de nouveaux marqueurs pour chaque adresse
    this.listContainer.querySelectorAll(".address-item").forEach(item => {
      const address = item.dataset.address;
      fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
        .then(response => response.json())
        .then(data => {
          if (data.length > 0) {
            const lat = parseFloat(data[0].lat);
            const lon = parseFloat(data[0].lon);
            const marker = L.marker([lat, lon]).addTo(this.map);
            marker.bindPopup(address).openPopup();
            this.markers.push(marker);
          }
        })
        .catch(error => console.error("Erreur de géocodage:", error));
    });
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
        this.updateMap(); // Mettre à jour la carte après suppression

      });

      this.listContainer.appendChild(listItem);
      this.updateHiddenAddresses();
      this.updateMap(); // Mettre à jour la carte après suppression

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
    savedAddresses.forEach(addr => {
      const listItem = document.createElement("div");
      listItem.className = "address-item";
      listItem.dataset.address = addr;
      listItem.innerHTML = `
<div class="address-box-profile">
    <button class="close-btn-profile">✕</button>
    <input type="text" class="address-input-profile" value="${addr}" readonly>
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
        this.updateMap(); // Mettre à jour la carte après suppression

      });

      this.listContainer.appendChild(listItem);
    });
    this.updateMap(); // Mettre à jour la carte après suppression

  }
}

export default AddressManager;
