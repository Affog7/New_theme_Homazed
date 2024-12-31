import L from "leaflet";
import "leaflet.markercluster";
import gsap from "gsap";
import Modals_Init from "./modal";
import {makeRelationBtw} from "../functional/relations";

const MapLaunch = (data) => {
	class Map {
		constructor(el) {
			this.element = el;
			this.map = data.querySelector("#map");
			this.popup = data.querySelector("#map-popup");
			this.fitBounds = this.element.getAttribute('data-fit-bounds');
			this.page = this.element.getAttribute('data-page');
			this.leaflet_map = null;
			this.marker = null;
			this.UserMarker = null;
			this.markerCluster = [];
			this.bounds = [];
			this.clickListener = null;
			this.tl = gsap.timeline({
				defaults: {
					duration: 0.4,
					ease: 'power2.inOut',
				},
			});

			this.ww = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
			this.wh = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
			this.headerH = document.querySelector(".header").clientHeight;

			this.init();

			if(this.popup) {
				this.initPopup();
			}

			if(this.page === "wall--map" || this.page === "post"){
				// this.follow_click();
				this.right_slates = document.querySelector(".right-slates");
				this.right_slates__items = this.right_slates.querySelectorAll(".card");
			}
		}

		// follow_click = () => {
		// }


		init = () => {
			// Create the map
			this.buildingsData = this.element.getAttribute('data-buildings');

			if(this.page === "single-user"){
				// La carte prend une hauteur "moyenne" en prenant une portion de la hauteur de la fenêtre
				this.map.style.height = (this.wh * 0.6) + "px"; // 60% de la hauteur de la fenêtre
			}else if(this.page === "single-post"){
				// La carte prend un peu moins de place
				
				this.map.style.height = ((this.wh / 1.8) - (this.headerH - 60)) + "px"; // 40% de la fenêtre
			}else if(this.page === "wall--map" || this.page === "single-post"){
				// Si la carte est sur une page de type "wall--map", ajuster en fonction du layout
				document.querySelector(".left-map").style.height = (this.wh * 0.7) + "px"; // 70% de la hauteur de la fenêtre
				this.map.style.height = (this.wh * 0.7) + "px"; // 70% de la hauteur de la fenêtre
			}else{
				// Si aucune page spécifique, définir une taille par défaut
				this.map.style.height = (this.wh * 0.7) + "px"; // Par défaut, 50% de la fenêtre
			}

					this.buildings = [];

			this.leaflet_map = L.map(this.map, {
				center: [ 4.5817,50.4629],
				zoom: 2,
				pixelRatio: 1,
				maxZoom: 16,
				minZoom: 1,
				zoomControl: false,
			});

			this.displayMap(this.buildingsData);
		}

		displayMap = (buildingsData) => {
			// Create a map layer
			L.tileLayer('https://api.mapbox.com/styles/v1/marcelpirnay01/clxbkdvdz026p01qx2whgeoiw/tiles/512/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFyY2VscGlybmF5MDEiLCJhIjoiY2tleWJwc2ZzMDh6ODJ4b2Nyb2V1NGt6bSJ9.AWwWSlKl8ectRbxP9fd6qg', {
				attribution: '&copy; <a  href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
				tileSize: 512,
				zoomOffset: -1,
			}).addTo(this.leaflet_map);

			L.control.zoom({
				position: 'bottomright' // Position du contrôle de zoom
			}).addTo(this.leaflet_map);

			// Parse the data from the DOM
			this.buildings = JSON.parse(buildingsData);

			// Create a cluster group
			this.markerCluster = L.markerClusterGroup({
				showCoverageOnHover: false,
				zoomToBoundsOnClick: true,
				maxClusterRadius: 1,
				spiderfyOnMaxZoom: 18,
				removeOutsideVisibleBounds: true,
				iconCreateFunction: function(cluster) {
					return L.divIcon({
						className: "marker marker--cluster",
						iconSize: null,
						iconAnchor: [20, 20],
						html: "<b>" + cluster.getChildCount() + "</b>"
					});
				}
			});

			// For all entries found in the DOM, create a marker and add it to the map
			this.buildings.forEach(building => {
				if(building.lat !== null && building.lng !== null) {
					this.addMarker(building);
				}
			});


			// Add the cluster to the map
			this.markerCluster.addTo(this.leaflet_map);

			// Listen for an attribute change
			this.mutation_observer = new MutationObserver(() => {
				this.updateMap();
			});

			this.intersection_observer = new IntersectionObserver((entries, _observer) => {
				entries.forEach(entry => {
					if(entry.isIntersecting) {
						this.leaflet_map.invalidateSize();
						if(this.fitBounds) {
							this.leaflet_map.fitBounds([this.bounds], {padding: [100, 30]});
						}
					}
				});
			});

			let element = document.querySelector("#map-data");
			this.intersection_observer.observe(this.map);
			this.mutation_observer.observe(element, {
				attributes: true
			});

			
		}

		addMarker = (building) => {
			// Create custom marker
			let markerColor;
			switch (building.post_type_slug) {
				case "real-estate":
					markerColor = '#B50EA7 0%, #6F12B6 100%';
					break;
				case 'users':
					markerColor = '#FFD603 0%, #a2810c 100%';
					break;
				default:
					markerColor = '#6F12B6';
			}

			const markerHtmlStyles = `background: linear-gradient(45deg, ${markerColor});`

			let customMarkerIcon = L.divIcon({
				className: "marker",
				iconAnchor: [0, 15],
				labelAnchor: [-6, 0],
				popupAnchor: [0, -36],
				html: `<span class="marker-wrap" style="${markerHtmlStyles}" />`
			});

			// Prepare the data
			let markerData = {
				id: building.id,
 // todo_augustin map
				// title: building.title,
				// permalink: building.permalink,
				// post_type_slug: building.post_type_slug,
				// price: building.price,
				// bathrooms: building.bathrooms,
				// bedrooms: building.bedrooms,
				// home_size: building.home_size,
				// outdoor_size: building.outdoor_size,
				// location: building.location,
				// permalink: building.permalink,
				// img: building.img,
				// card_gallery: building.card_gallery,
			};


			// Set a new marker
			this.marker = new L.marker([building.lat, building.lng], {
				icon: customMarkerIcon
			});

			// Assign the data set to the marker
			this.marker.markerData = markerData;

			// If there's more than 1 building, create clusters, or else, just add the marker
			if(this.buildings.length < 2) {
				this.marker.addTo(this.leaflet_map);
			} else {
				// Add the markers to the layer
				this.markerCluster.addLayer(this.marker);

				// Add the layer to the map
				this.leaflet_map.addLayer(this.markerCluster);
			}
			// Create an array with all markers' data
			let clusterBounds = [];
			clusterBounds.push(building.lat, building.lng);
			this.bounds.push(clusterBounds);

			if(this.fitBounds) {
				this.leaflet_map.fitBounds([this.bounds], {padding: [100, 30]});
			}

			// On the click, call the next function
			this.marker.on("click", this.markerClick);
		}

		markerClick = (event) => {
			// On the click, move the map to the marker clicked
			this.leaflet_map.flyTo([event.latlng.lat, event.latlng.lng]);

			// Get all markers on the map
			let allMarkers = data.querySelectorAll(".marker");

			// For each marker, remove the class
			allMarkers.forEach(marker => {
				marker.classList.remove("marker--selected");
			});

			// On the marker clicked, add the class
			event.target._icon.classList.add("marker--selected");

			if(this.page === "wall--map" || this.page === "post"){
				var slates = this.right_slates.querySelectorAll(".card");
				var related_slate = document.querySelector("#slate-" + event.target.markerData.id);
				const y = related_slate.getBoundingClientRect().top + window.scrollY;
				slates.forEach(slate => {
					if(slate.classList.contains("highlight")){
						slate.classList.remove("highlight");
					}
				});
				related_slate.classList.add("highlight");
				window.scroll({
					top: y - 200,
					behavior: 'smooth'
				});
			}

			// If a hidden popup exists, show it
			if(this.popup) {
				this.changePopupContent(event)
				this.displayPopup();
			}
		}

		initPopup = () => {
			// Initially hide the popup
			this.tl.set(this.popup, {
				autoAlpha: 0,
				opacity: 0,
				y: 100
			});
		}

		changePopupContent = (event) => {
			this.closePopup(null);

			// TODO : Retirer timeout si la carte est off
			setTimeout(async () => {
          // TODO todo_augustin : gerer l'appel à l'api  avec post_id = event.target.markerData.id

          const response = await fetch(`/wp-json/custom/v1/post-details?post_id=${event.target.markerData.id}`);
          if (!response.ok) {
            throw new Error("Erreur lors de la récupération des détails du post");
          }
          // Get all the fields
          let link = this.popup.querySelector(".map-slate--link");
          let title = this.popup.querySelector(".title");
          // let price = this.popup.querySelector(".post-details__price .value");
          let address = this.popup.querySelector(".post-location");
          let bedroom = this.popup.querySelector(".post-details__bedroom .value");
          let bathroom = this.popup.querySelector(".post-details__bathroom .value");
          let house = this.popup.querySelector(".post-details__house .value");
          let land = this.popup.querySelector(".post-details__land .value");
          let image = this.popup.querySelector("img");
          // Change the values of the fields
          // linkTag.href = event.target.markerData.permalink;

          // json todo_augustin api map
          const postData = await response.json();

          this.popup.classList.remove("users");
          this.popup.classList.remove("real-estate");
          this.popup.classList.add(postData.post_type_slug);

          // todo_augustin map swipper

          //  console.log(postData);

          let images = postData.card_gallery_images;
          const imageContainer = this.popup.querySelector('.map-slate__image');

          // ---------
          const shareBu = this.popup.querySelector('.shareButon');
          const favoriteButon = this.popup.querySelector('.favoriteButon');
          shareBu.innerHTML = postData.templates.bouton_share_template;

          favoriteButon.innerHTML = postData.templates.like_favorite_template;

          Modals_Init(shareBu);

          var relationBtns = this.popup.querySelectorAll(".relation_btn");
          if (relationBtns) {
            relationBtns.forEach(relationBtn => {
              relationBtn.addEventListener("click", (e) => {

                e.preventDefault();
                e.stopPropagation();
                // makeRelationBtw(this.current_user_id.getAttribute("data-u-id"), this.el.getAttribute("data-h-id"), this.el.getAttribute("data-post-type"), e.currentTarget);

                makeRelationBtw(postData.user_id, postData.id, postData.post_type_slug, e.currentTarget);
              });
            });
          }
          imageContainer.innerHTML = postData.templates.images_temp;


            const sliderWrapper = document.querySelector(".slider-wrapper_a");
            const slides = document.querySelectorAll(".slider-slide_a");
            const prevButton = document.querySelector(".slider-control_a.prev");
            const nextButton = document.querySelector(".slider-control_a.next");

            let currentIndex = 0;

            function updateSlider() {

            // Déplacer le wrapper vers l'image actuelle
            sliderWrapper.style.transform = `translateX(-${currentIndex * 100}%)`;


          }

            function showNextSlide() {
            currentIndex = (currentIndex + 1) % slides.length;
            updateSlider();
          }

            function showPrevSlide() {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            updateSlider();
          }

          if(nextButton && prevButton) {
            // Ajouter des événements aux boutons
            nextButton.addEventListener("click", (e) => {
              e.preventDefault();
              e.stopPropagation();
              showNextSlide()
            });
            prevButton.addEventListener("click", (e) => {
              e.preventDefault();
              e.stopPropagation();
              showPrevSlide()
            });
          }





            // Initialiser le slider
            updateSlider();



          // todo_augustin remplissage map info
          link.href = postData.post_permalink;//event.target.markerData.permalink;
          //image.src = ;//event.target.markerData.img;
          title.innerHTML = "<span style='color: #0b7439;text-transform: uppercase;'>"+postData.home_category+"</span>  "+postData.home_type ;//event.target.markerData.title;
          // price.innerHTML = ;//event.target.markerData.price;
          address.innerHTML = postData.price;//event.target.markerData.price;
		  
		  this.popup.querySelector(".post-details__bedroom").style.display = (postData.bedrooms ==  0) ? 'none' : 'block';
		  bedroom.innerHTML = postData.bedrooms;//event.target.markerData.bedrooms;
         
		  this.popup.querySelector(".post-details__bathroom").style.display = (postData.bathrooms ==  0) ? 'none' : 'block';
		  
		  bathroom.innerHTML = postData.bathrooms;//event.target.markerData.bathrooms;
         
		  house.innerHTML = postData.home_size;//event.target.markerData.home_size;

		  this.popup.querySelector(".post-details__land").style.display = (postData.outdoor_size ==  0) ? 'none' : 'block';
		  land.innerHTML = postData.outdoor_size;//event.target.markerData.outdoor_size;
        
		}
        ,
        400
      )
      ;

      this.displayPopup();
    }

    displayPopup = () => {

      // Display the popup
      this.tl.to(this.popup, {
        autoAlpha: 1,
        opacity: 1,
        y: 0
      });
      // data.querySelector("#card-icon").addEventListener("click", this.closePopup);
    }

    closePopup = (event) => {
      if (event) {
        event.preventDefault();
        event.stopPropagation();
      }

      // Hide the popup
      this.tl.to(this.popup, {
        autoAlpha: 0,
        opacity: 0,
        y: 60
      });
    }

    updateMap() {
      this.leaflet_map.off();
      this.leaflet_map.remove();
      this.init();
    }
  }

  // Get the DOM element
  const maps = data.querySelectorAll("#map-data");

  // Check if the DOM element exists
  if (maps.length) {
    // If yes, call a new instance of the map
    [...maps].map((map) => new Map(map));
  }
}

export default MapLaunch;
