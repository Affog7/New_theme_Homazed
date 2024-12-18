
const makeRelationBtw = (me, him, post_type_clicked_on, relationBtn) => {
	console.log(post_type_clicked_on);
	const request = new XMLHttpRequest();
	const adminAjaxUrl = document.querySelector('.main').getAttribute('data-admin-ajax');
	request.open('POST', adminAjaxUrl, true);
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
	request.onload = function() {
		console.log(this.response);
		console.log(this.status);
		if(this.status >= 200 && this.status < 400) {
			//console.log(relation_type);
			const relation_type = relationBtn.getAttribute("data-relation-type");
			if(relation_type === "request-contact-list"){
				relationBtn.querySelector(".btn__label").innerHTML = "";
				if(this.response === "Contact request send") {
					relationBtn.classList.add("relation_btn--contact-requested");
					relationBtn.querySelector(".btn__label").innerHTML = decodeURIComponent(relationBtn.getAttribute("data-request-contact-requested"));
					if(relationBtn.querySelector(".o-svg-icon"))relationBtn.querySelector(".o-svg-icon").innerHTML = "<svg width=\'24\' height=\'25\' viewBox=\'0 0 24 25\' fill=\'none\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M0.75 17.4852C0.751544 15.2186 1.89011 13.1039 3.78149 11.8548C5.67287 10.6057 8.06476 10.3888 10.15 11.2772\' stroke=\'black\' stroke-width=\'1.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\'></path><path fill-rule=\'evenodd\' clip-rule=\'evenodd\' d=\'M7.5 9.23535C9.77817 9.23535 11.625 7.38853 11.625 5.11035C11.625 2.83218 9.77817 0.985352 7.5 0.985352C5.22183 0.985352 3.375 2.83218 3.375 5.11035C3.375 7.38853 5.22183 9.23535 7.5 9.23535Z\' stroke=\'black\' stroke-width=\'1.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\'></path><path d=\'M15 18.9854H11.25V22.7354\' stroke=\'black\' stroke-width=\'1.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\'></path><path d=\'M22.6668 19.7184C21.8501 22.1049 19.532 23.6452 17.0155 23.4734C14.4989 23.3017 12.4116 21.4607 11.9268 18.9854\' stroke=\'black\' stroke-width=\'1.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\'></path><path d=\'M19.5 15.9854H23.25V12.2354\' stroke=\'black\' stroke-width=\'1.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\'></path><path d=\'M11.832 15.2523C12.6487 12.8657 14.9668 11.3254 17.4833 11.4972C19.9999 11.6689 22.0872 13.5099 22.572 15.9853\' stroke=\'black\' stroke-width=\'1.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\'></path></svg>";
				}else{
					relationBtn.classList.remove("relation_btn--contact-requested");
					relationBtn.querySelector(".btn__label").innerHTML = decodeURIComponent(relationBtn.getAttribute("data-request-contact-default"));
					relationBtn.querySelector(".o-svg-icon").innerHTML = "<svg width=\'24\' height=\'25\' viewBox=\'0 0 24 25\' fill=\'none\' xmlns=\'http://www.w3.org/2000/svg\'><path fill-rule=\'evenodd\' clip-rule=\'evenodd\' d=\'M17.25 23.4854C20.5637 23.4854 23.25 20.7991 23.25 17.4854C23.25 14.1716 20.5637 11.4854 17.25 11.4854C13.9363 11.4854 11.25 14.1716 11.25 17.4854C11.25 20.7991 13.9363 23.4854 17.25 23.4854Z\' stroke=\'black\' stroke-width=\'1.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\'/><path d=\'M17.25 14.4854V20.4854\' stroke=\'black\' stroke-width=\'1.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\'/><path d=\'M14.25 17.4854H20.25\' stroke=\'black\' stroke-width=\'1.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\'/><path d=\'M0.75 17.4852C0.751544 15.2186 1.89011 13.1039 3.78149 11.8548C5.67287 10.6057 8.06476 10.3888 10.15 11.2772\' stroke=\'black\' stroke-width=\'1.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\'/><path fill-rule=\'evenodd\' clip-rule=\'evenodd\' d=\'M7.5 9.23535C9.77817 9.23535 11.625 7.38853 11.625 5.11035C11.625 2.83218 9.77817 0.985352 7.5 0.985352C5.22183 0.985352 3.375 2.83218 3.375 5.11035C3.375 7.38853 5.22183 9.23535 7.5 9.23535Z\' stroke=\'black\' stroke-width=\'1.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\'/></svg>";
				}
			}else if(relation_type === "accept-contact-list" ){
				if(this.response === "Contact accepted") {
					const tooltip = document.querySelector("#tooltip-notification");
					const tooltip_pill_notifications = document.querySelector(".tooltip-pill.notifications")
					const notification_counter = tooltip_pill_notifications.querySelector(".notification_counter");
					const count_notifications = tooltip.querySelectorAll(".notifications--section").length;
					const current_notification = tooltip.querySelector("#notification-" + him);
					console.log(current_notification);
					console.log(count_notifications);

					current_notification.style.display = "none";
					// get parent box of notification
					if((count_notifications - 1) <= 0){
						tooltip.removeAttribute('data-show');
						tooltip_pill_notifications.style.display = "none";
					}
					notification_counter.innerHTML = "";
					notification_counter.innerHTML = count_notifications - 1;
				}
			}else if(relation_type === "refuse-contact-list" ){
				if(this.response === "Contact removed") {
					relationBtn.classList.remove("relation_btn--contact-relation-done");
				}
			}else if(relation_type === "favorite" || relation_type === "like" ) {

        var likeCount = relationBtn.parentElement.querySelector('.count-like_');
        // Empêcher le comportement par défaut du lien


        // Récupérer la valeur actuelle du compteur
        var currentCount = parseInt(likeCount.textContent) ? parseInt(likeCount.textContent) :  0;  // Convertir la valeur en nombre



				if(this.response === "Relation added") {
					relationBtn.classList.add("relation_btn--checked");
          likeCount.textContent = currentCount + 1;
				}else{
					relationBtn.classList.remove("relation_btn--checked");
          likeCount.textContent = currentCount - 1;
				}
			}else if(relation_type === "recommend" ){
				if(this.response === "Relation added") {
					relationBtn.classList.add("relation_btn--checked");
				}else{
					relationBtn.classList.remove("relation_btn--checked");
				}
			}else{
				console.log("not recognized");
			}

		}else{
			// error
		}
	};


	let field_me;
	let me_uid = 'user_' + me;
	let him_uid;
	if(post_type_clicked_on === "real-estate") {
		if(relationBtn.getAttribute("data-relation-type") === "favorite"){
			field_me = "i_favorite_posts_relationships";
		}else{
			field_me = "i_like_posts_relationships";
		}
		him_uid = him;
		request.send('action=makeRelationBtw&me_uid=' + me_uid + '&him=' + him + '&field_me=' + field_me );
	}
	else if(post_type_clicked_on === "users") {
		if(relationBtn.getAttribute("data-relation-type") === "favorite"){
			field_me = "i_favorite_users_relationships";
		}else{
			field_me = "i_like_users_relationships";
		}
		him_uid = 'user_' + him;
		request.send('action=makeRelationBtw&me_uid=' + me_uid + '&him=' + him + '&field_me=' + field_me );
	}
	else if(post_type_clicked_on === "request-contact-list") {
		field_me = "i_request_contactlist_users_relationships";
		him_uid = 'user_' + him;
		request.send('action=requestContact&me_uid=' + me_uid + '&him=' + him + '&field_me=' + field_me );
	}
  else if(post_type_clicked_on === "remove-request-contact-list") {
		alert("TODO: remove-request-contact-list");
	}
	else if(post_type_clicked_on === "accept-contact-list") {
		field_me = "i_accept_contactlist_users_relationships";
		him_uid = 'user_' + him;
		request.send('action=acceptContact&me_uid=' + me_uid + '&me=' + me + '&him=' + him );
	}
	else if(post_type_clicked_on === "refuse-contact-list") {
		if (window.confirm("Are you sure you want to delete this user from your contact list ?")) {
			field_me = "i_accept_contactlist_users_relationships";
			him_uid = 'user_' + him;
			request.send('action=refuseContact&me_uid=' + me_uid + '&me=' + me + '&him=' + him );
		}
	}
	else if(post_type_clicked_on === "recommend") {
		console.log("recommend");
		field_me = "i_recommend_users_relationships";
		him_uid = 'user_' + him;
		request.send('action=makeRelationBtw&me_uid=' + me_uid + '&him=' + him + '&field_me=' + field_me );
	}

	console.log(me_uid + " :added " + him_uid + " on: " + field_me);

	request.onerror = function() {  };
}

export {makeRelationBtw};
