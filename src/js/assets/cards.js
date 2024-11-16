import { makeRelationBtw } from '../functional/relations';

const Cards_Init = () => {
	class Card {
		constructor(el) {
			this.el = el;
			this.current_user_id = document.querySelector(".current_user_id");
			this.relationBtns = this.el.querySelectorAll(".relation_btn__posts");
			this.relationUsersBtns = this.el.querySelectorAll(".relation_btn.relation_btn--contact-list");
			this.a_in_el = this.el.querySelectorAll("a");
			this.card__img__grid = this.el.querySelector(".card__img__grid");
            this.handleEvents();
		}

        handleEvents() {
			if(this.relationUsersBtns){
				this.relationUsersBtns.forEach(relationUserBtn => {
					relationUserBtn.addEventListener("click", (e) => {
						e.preventDefault();
						e.stopPropagation();
						console.log("do relation user");
						console.log(this.current_user_id.getAttribute("data-u-id"));
						console.log(e.currentTarget.getAttribute("data-relation-him"));
						console.log(e.currentTarget.getAttribute("data-relation-type"));
						makeRelationBtw(this.current_user_id.getAttribute("data-u-id"), e.currentTarget.getAttribute("data-relation-him"), e.currentTarget.getAttribute("data-relation-type"), e.currentTarget);
					});
				});
			}
			this.relationBtns.forEach(relationBtn => {
				relationBtn.addEventListener("click", (e) => {
					e.preventDefault();
					e.stopPropagation();
					// console.log(e.currentTarget.getAttribute("data-relation-type"));
					makeRelationBtw(this.current_user_id.getAttribute("data-u-id"), this.el.getAttribute("data-h-id"), this.el.getAttribute("data-post-type"), e.currentTarget);
				});
			});
			this.el.addEventListener("mouseover", (e) => {
				this.el.classList.add("mouseover");
				
			});
			this.a_in_el.forEach(link => {
				link.addEventListener("mouseover", (e) => {
					this.el.classList.add("mouseover--link");
				});
				link.addEventListener("mouseleave", (e) => {
					this.el.classList.remove("mouseover--link");
				});
			});
			if(this.card__img__grid){
				this.card__img__grid.addEventListener("mouseover", (e) => {
					this.el.classList.add("mouseover--img-link");
					
				});
				this.card__img__grid.addEventListener("mouseleave", (e) => {
					this.el.classList.remove("mouseover--img-link");
					
				});
			}
			this.el.addEventListener("mouseleave", (e) => {
				this.el.classList.remove("mouseover");
			});
        }
	}

	const cards = document.querySelectorAll(".card");

	if (cards.length) {
		[...cards].map((card) => new Card(card));
	}
}

export default Cards_Init;
