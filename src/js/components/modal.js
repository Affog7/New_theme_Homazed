import MicroModal from 'micromodal';

const Modals_Init = (data) => {
	class Modal {
		constructor(el) {
			this.el = el;
			this.id = this.el.getAttribute("data-open-modal");
            this.targetEL = document.querySelector("#" + this.id);
            this.el.addEventListener("click", (e) => {
                e.preventDefault();
		        e.stopPropagation();
                MicroModal.show(this.id, {
                    openTrigger: 'data-open-modal',
                    closeTrigger: 'data-close-modal',
                    openClass: 'is-open',
                    disableScroll: false,
                    disableFocus: false,
                    awaitOpenAnimation: false,
                    awaitCloseAnimation: false,
                    debugMode: false,
                }); 
            });
		}
		
	}
	
	const ModalBtns = document.querySelectorAll('[data-open-modal]');

	if (ModalBtns.length) {
	  [...ModalBtns].map((ModalBtn) => new Modal(ModalBtn));
	}
}

export default Modals_Init;


