const Checkbox_And_Radios_Init = () => {
	class Checkbox {
		constructor(el) {
			this.el = el;
			this.checkbox_label = this.el.querySelector("label");
			this.checkbox_input = this.checkbox_label.querySelector("input");
			
			this.init();
		}
		init() {
			const svg_content = "<svg width='20' height='20' viewBox='0 0 20 20' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M18.4375 1.56177L7.1185 17.731C6.81554 18.1664 6.32177 18.4295 5.79145 18.4383C5.26114 18.4471 4.75894 18.2004 4.44175 17.7753L1.5625 13.9368' stroke='black' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/></svg>";
			const tempElement = document.createElement('div');
			tempElement.classList.add("svg_wrapper");

			tempElement.innerHTML = svg_content;

			this.checkbox_label.appendChild(tempElement);
		}
	}
	
	const checkboxes = document.querySelectorAll(".acf-checkbox-list li");
	const checkbox_outside_plugin = document.querySelectorAll(".login-remember");
	const merged_elements = [...checkboxes, ...checkbox_outside_plugin];
	
	if (merged_elements.length) {
		[...merged_elements].map((checkbox) => new Checkbox(checkbox));
	}

	var radios = document.querySelectorAll(".gchoice");
	
	if (radios.length) {
		[...radios].map((radio) => new Checkbox(radio));
	}

	document.addEventListener('DOMContentLoaded', function() {
		if (window.jQuery) {  
			jQuery(document).on('gform_page_loaded', function(event, form_id, current_page){
				const checkboxes = document.querySelectorAll(".acf-checkbox-list li");
				const checkbox_outside_plugin = document.querySelectorAll(".login-remember");
				const merged_elements = [...checkboxes, ...checkbox_outside_plugin];
				
				if (merged_elements.length) {
					[...merged_elements].map((checkbox) => new Checkbox(checkbox));
				}

				var radios = document.querySelectorAll(".gchoice");
				
				if (radios.length) {
					[...radios].map((radio) => new Checkbox(radio));
				}
			});
		}
	});
}

export default Checkbox_And_Radios_Init;
