import gsap from 'gsap';

const Card_popup_link_Init = (data) => {
	class CardPopup {
		constructor(el) {
			this.el = el;
			this.data_id = this.el.getAttribute("data-card-popup-id");
			this.data_id_splitted = this.data_id.split("-");
			this.post_id = this.data_id_splitted[this.data_id_splitted.length - 1];
			this.slate_id = "slate-" + this.post_id;
			this.ctx_slate = document.getElementById(this.slate_id);
			this.cards_popups = document.querySelectorAll(".card-popup");
			this.cards = document.querySelectorAll(".card");
			this.card_popup_target = document.getElementById(this.data_id);
			this.card_popup_targets = document.querySelectorAll(".card-popup");
			this.card_popup_target_close = this.card_popup_target.querySelector(".card-popup-close");

			this.tl = gsap.timeline({
				defaults: {
				  duration: 0.2,
				  ease: 'power2.inOut',
				},
			});


			this.el.addEventListener("click", (event) => {
				event.preventDefault();
				event.stopPropagation();
				this.toggle();
			});
			this.card_popup_target_close.addEventListener("click", (e) => {
				e.preventDefault();
				e.stopPropagation();
				this.close();
			});
			window.addEventListener("scroll", () => {
				this.close();
			});

			this.tl.set(this.card_popup_target, {autoAlpha: 0, opacity: 0, y: 50});
			
		}
		toggle() {
			if(this.card_popup_target.classList.contains("card-popup--hidden")){
				this.cards_popups.forEach(cards_popup => {
					cards_popup.classList.add("card-popup--hidden");
					this.tl.to(cards_popup, {autoAlpha: 0, opacity: 0, y: 50, duration: .1}, 0);
				});
				this.card_popup_target.classList.remove("card-popup--hidden");
				this.ctx_slate.classList.add("active");
  				this.tl.to(this.card_popup_target, {autoAlpha: 1, opacity: 1, y: 0, duration: .1}, 0);
			}else{
				this.close(this.card_popup_target);
			}
			return this.tl;
		}
		close() {
			this.card_popup_target.classList.add("card-popup--hidden");
			this.cards.forEach(card => {
				card.classList.remove("active");
			});
			this.ctx_slate.classList.remove("active");
			this.tl.to(this.card_popup_target, {autoAlpha: 0, opacity: 0, y: 50, duration: .1}, 0);
			return this.tl;
		}
	}
	
	const card_popups_fires = data.container.querySelectorAll(".card-popup-fire");
	
	if (card_popups_fires.length) {
		[...card_popups_fires].map((card_popups_fire) => new CardPopup(card_popups_fire));
	}
}

export default Card_popup_link_Init;
