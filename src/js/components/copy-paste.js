const CopyBtn_Init = (data) => {
	class CopyBtn {
		constructor(btn) {
		this.btn = btn;
		this.copy_trad_action = this.btn.querySelector('.u-sr-accessible').innerHTML;
		this.copied_trad = this.btn.getAttribute('data-action-trad');
		this.copied_value = this.btn.previousElementSibling.innerHTML;
		this.target__el = document.querySelector(this.btn.getAttribute('data-copy-content'));
		this.target__el__content = this.target__el.innerHTML;
		this.tooltipContent = this.btn.nextElementSibling.querySelector("span");
		this.tooltipContent.innerHTML = this.copy_trad_action;

		this.btn.addEventListener('click', (e) => {
			this.copyToClipboard(e);
		});
		this.btn.addEventListener('mouseleave', (e) => {
			this.resetTooltipContent();
		});
	
		}
		copyToClipboard(e){
			e.preventDefault();
			e.stopPropagation();
			console.log(this.tooltipContent.innerHTML);
			navigator.clipboard.writeText(this.copied_value);
			this.tooltipContent.innerHTML = this.copied_value + " "  + this.copied_trad;
		}
		resetTooltipContent(){
			this.tooltipContent.innerHTML = this.copy_trad_action;
		}
	}
	
	const copyBtns = document.querySelectorAll("[data-action='copy']");

	if (copyBtns.length) {
		[...copyBtns].map((copyBtnsWithClick) => new CopyBtn(copyBtnsWithClick));
	}
}

export default CopyBtn_Init;