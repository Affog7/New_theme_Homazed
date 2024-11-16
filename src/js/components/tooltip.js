// import { createPopper } from '@popperjs/core';
// import { createPopper } from '@popperjs/core/lib/popper-lite';
import {computePosition} from '@floating-ui/dom';
import {arrow, hide, offset, flip, shift} from '@floating-ui/dom';
import {autoPlacement} from '@floating-ui/dom';

// Global settings
const tooltipMargin = '16';

const Tootlip_Init = (data) => {
	class Tooltip {
		constructor(el) {
			this.el = el;
			this.popperInstance = null;
            this.targetId = this.el.getAttribute('data-tooltip');
            this.targetEl = document.getElementById(this.targetId);
            this.arrowEl = this.targetEl.querySelector(".arrow");
			this.placement = this.el.getAttribute('data-tooltip-placement') || 'top';
			this.events = this.el.getAttribute('data-tooltip-events') || 'hover';


			const showEvents = (this.events === 'click') ? ['click'] :  ['mouseenter'] ;
			const hideEvents = (this.events === 'click') ? ['click'] :  ['mouseleave'] ;

			// this.hide();

			this.el.addEventListener('click', (e) => {
				e.preventDefault(); e.stopPropagation();
				if(this.targetEl.hasAttribute('data-show')){
					this.hide(this.el, this.targetEl);
				}else{
					this.show(this.el, this.targetEl);
				}
			});
			

			window.addEventListener("click", (e) => {
				if (!e.target.closest('#tooltip-notification') && !e.target.closest('.tooltip-pill.notifications') && this.targetEl.hasAttribute('data-show')) {
					this.hide(this.el, this.targetEl);
				  }
			});


			
		}
		show(triggerEl, targetEl) {
			this.targetEl.setAttribute('data-show', '');

			computePosition(triggerEl, targetEl, {
				placement: this.placement,
				middleware: [offset(4)],
			  }).then(({x, y}) => {
				Object.assign(targetEl.style, {
				  left: `${x}px`,
				  top: `${y}px`,
				});
			});
		}
		hide(triggerEl, targetEl) {
			this.targetEl.removeAttribute('data-show');
		}
	}

	const tooltips = document.querySelectorAll('[data-tooltip]');
	
	if (tooltips.length) {
	  [...tooltips].map((tooltip) => new Tooltip(tooltip));
	}
}

export default Tootlip_Init;
