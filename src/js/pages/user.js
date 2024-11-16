import { makeRelationBtw } from '../functional/relations';

class User {
	namespace = 'user';

	beforeEnter = data => {
		// Add contact btn
		var current_user_id = data.next.container.querySelector(".current_user_id");
		var relationBtns = data.next.container.querySelectorAll('.relation_btn');
		if(relationBtns){
			relationBtns.forEach(relationBtn => {
				relationBtn.addEventListener("click", (e) => {
					e.preventDefault();
					e.stopPropagation();
					makeRelationBtw(current_user_id.getAttribute("data-u-id"), e.currentTarget.getAttribute("data-relation-him"), e.currentTarget.getAttribute("data-relation-type"), e.currentTarget);
				});
			});
		}

		// Show favorites only
		const MyfavoritesBtn = data.next.container.querySelector('[data-action="show-favorites-only"]');
		if(MyfavoritesBtn){
			MyfavoritesBtn.addEventListener("click", (e) => {
				e.preventDefault();
				e.stopPropagation();
				const listRequest = new XMLHttpRequest();
				const gridRequest = new XMLHttpRequest();
				const mapRequest = new XMLHttpRequest();
				const adminAjaxUrl = document.querySelector('.main').getAttribute('data-admin-ajax');
				listRequest.open('POST', adminAjaxUrl, true);
				gridRequest.open('POST', adminAjaxUrl, true);
				mapRequest.open('POST', adminAjaxUrl, true);
				listRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
				gridRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
				mapRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');

				listRequest.onload = function() {
					if(this.status >= 200 && this.status < 400) {
						var updatedContainerItems = document.querySelector('.tab-content.profile-content__list');
						updatedContainerItems.innerHTML = "";
						updatedContainerItems.innerHTML = this.response;
					}
				}
				gridRequest.onload = function() {
					if(this.status >= 200 && this.status < 400) {
						var updatedContainerItems = document.querySelector('.tab-content.profile-content__grid');
						updatedContainerItems.innerHTML = "";
						updatedContainerItems.innerHTML = this.response;
					}
				}
				mapRequest.onload = function() {
					if(this.status >= 200 && this.status < 400) {
						let updatedMapData = document.querySelector("#map-data");
						updatedMapData.setAttribute("data-buildings", "");
						updatedMapData.setAttribute("data-buildings", this.response);
					}
				}

				if(!e.currentTarget.classList.contains("show-favorites-checked")){
					e.currentTarget.classList.add("show-favorites-checked");
					listRequest.send('action=filterFavoritesList&me_id=' + current_user_id.getAttribute("data-u-id") + '&filter='  + "favorites");
					gridRequest.send('action=filterFavoritesGrid&me_id=' + current_user_id.getAttribute("data-u-id") + '&filter='  + "favorites");
					mapRequest.send('action=filterFavoritesMap&me_id=' + current_user_id.getAttribute("data-u-id") + '&filter='  + "favorites");
				}else{
					e.currentTarget.classList.remove("show-favorites-checked");
					listRequest.send('action=filterFavoritesList&me_id=' + current_user_id.getAttribute("data-u-id") + '&filter='  + "mine");
					gridRequest.send('action=filterFavoritesGrid&me_id=' + current_user_id.getAttribute("data-u-id") + '&filter='  + "mine");
					mapRequest.send('action=filterFavoritesMap&me_id=' + current_user_id.getAttribute("data-u-id") + '&filter='  + "mine");
				}
				listRequest.onerror = function() {};

			});
		}
	};
}

export default new User(); 