// TODO: leaflet-control-geocoder-alternatives -> li onclick:
// toggleClass .leaflet-control-geocoder-alternatives-minimized

const Maps_Init = () => {
	class Map {
		constructor(el) {
			this.el = el;
            this.leaflet_control_geocoder = this.el.querySelector(".leaflet-control-geocoder");

            // console.log(map);
            // console.log(this.el);
            // console.log(this.leaflet_control_geocoder);
           

            // const observer = new MutationObserver(() => {
            //     console.log("map has changed");
            //     this.proposition_list = this.el.querySelector(".leaflet-control-geocoder-alternatives");
            //     this.proposition_list_items = this.proposition_list.querySelectorAll("li");
            //     console.log(this.proposition_list_items);


                
            //     this.proposition_list_items.forEach(element => {
            //         console.log(element);
            //         element.addEventListener("click", function (e) {
            //             console.log(e.target);
            //             console.log("You clicked");
            //         });
            //     });
            // });
              
            // observer.observe(this.el, {
            //     subtree: true,
            //     childList: true,
            // });

			// this.init();


		}
		// init() {
		// 	console.log("map");
		// }
	}
	
	const maps = document.querySelectorAll(".af-field-type-open-street-map");

	
	if (maps.length) {
		[...maps].map((map) => new Map(map));
	}
}

export default Maps_Init;
