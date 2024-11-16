import gsap from 'gsap';

const DropDownExp = (data) => {
	class Dropdown {
		constructor(el) {
			this.el = el;
			this.dropdown = this.el.querySelector('.dropdown--wrapper');
			this.dropdown_menu = this.el.querySelector('.dropdown-menu');
			this.dropdown_menu_item = this.el.querySelectorAll('.dropdown-menu__item');
			this.dropdown_menu_item_length = this.el.querySelectorAll('.dropdown-menu__item').length;
			this.dropdown_toggle = this.el.querySelector('.dropdown-toggle');

			el.style.width = this.dropdown_toggle.getBoundingClientRect().width + "px";
			el.style.height = this.dropdown_toggle.getBoundingClientRect().height + "px";

			this.init();
		}
		init() {
			const tl = gsap.timeline({
				paused: true,
				defaults: {
				  duration: 0.3
				},
			});
			var toggle = true;
			var dropdown = this.dropdown;
			var dropdown_menu = this.dropdown_menu;
			var dropdown_toggle = this.dropdown_toggle;
			dropdown_toggle.style.width = this.dropdown_toggle.getBoundingClientRect().width + "px";

			tl.from(this.dropdown_menu, {height: 0, opacity: 0, autoAlpha: 0}, .025);
			tl.from(this.dropdown_menu_item, {y: -20, opacity: 0, stagger: 0.05}, .015);  

			var height = (dropdown_toggle.getBoundingClientRect().height * (this.dropdown_menu_item_length + 1));
			
			this.dropdown_toggle.addEventListener('click', function(e) {
				e.preventDefault(); e.stopPropagation();
				var clickedEl = e.currentTarget;
				var ariaExpanded = clickedEl.getAttribute('aria-expanded') === "false" ? "true" : "false";
				clickedEl.setAttribute('aria-expanded', ariaExpanded);
				clickedEl.setAttribute('aria-pressed', ariaExpanded);
				dropdown_menu.setAttribute('aria-hidden', ariaExpanded);
				dropdown.classList.toggle("open");

				if(clickedEl.getAttribute('data-cross') === "true"){
					if(clickedEl.getAttribute('aria-expanded') === "true"){
						clickedEl.innerHTML = "x"; // needs to be icon
					}else{
						clickedEl.innerHTML = clickedEl.getAttribute('data-label');
					}
				}
				tl.to(dropdown , {height: height}, 0);
				if (toggle) { tl.play(); } else { tl.reverse(); }
				toggle = !toggle;
			});
		}
	}
	
	const dropdown_menus = document.querySelectorAll(".dropdown");
	
	if (dropdown_menus.length) {
	  [...dropdown_menus].map((dropdown_menu) => new Dropdown(dropdown_menu));
	}
}

export default DropDownExp;


