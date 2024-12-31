import { makeRelationBtw } from '../functional/relations';

class Post {
	namespace = 'post';
  constructor() {

  }


	beforeEnter = data => {

		var current_user_id = data.next.container.querySelector(".current_user_id");
		var relationBtns = data.next.container.querySelectorAll(".relation_btn");
		if(relationBtns) {
			relationBtns.forEach(relationBtn => {
				relationBtn.addEventListener("click", (e) => {
					e.preventDefault();
					e.stopPropagation();
					// console.log(e.currentTarget.getAttribute("data-relation-type"));
					makeRelationBtw(current_user_id.getAttribute("data-u-id"), e.currentTarget.getAttribute("data-relation-him"), "real-estate", e.currentTarget);
				});
			});
		}

// input_87,input_123,input_124,input_105.1,input_106.1
 // todo_augustin add contact

		var relationBtns_ = data.next.container.querySelectorAll(".add-contact-btn_");
		if(relationBtns_){
			relationBtns_.forEach(relationBtn => {
				relationBtn.addEventListener("click", (e) => {
					e.preventDefault();
					e.stopPropagation();
          makeRelationBtw(current_user_id.getAttribute("data-u-id"), e.currentTarget.getAttribute("data-relation-him"), "request-contact-list", e.currentTarget);
					//makeRelationBtw(current_user_id.getAttribute("data-u-id"), e.currentTarget.getAttribute("data-relation-him"), "real-estate", e.currentTarget);
				});
			});
	}

};





// todo_augustin: edit
afterEnter = data => {
    var edit_post_main = data.next.container.querySelector(".edit_post_main");
    var status_notif_ = data.next.container.querySelector("#status_notif_");
    if (edit_post_main) {
       

        // Toggle visibility of edit areas when clicking edit_post_main
        edit_post_main.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            edit_post_main.classList.toggle('active');
            edit_post_btns.forEach(edit_post_btn => {
                edit_post_btn.classList.toggle('hide');
            });
        });
    }

    var edit_post_btns = data.next.container.querySelectorAll(".edit-area");
    if(edit_post_btns) {
              // Toggle the dropdown visibility
            window.toggleDropdown = function () {
              data.next.container.querySelector("#status-options").classList.toggle("show");
          }

          // Set the status text and close dropdown
          window.setStatus = function (status,post_id) {
            var status_labels = {
              'publish': 'Active',
              'private': 'Inactive',
              'erase': 'Erase'
          };
          
              data.next.container.querySelector("#post-status").textContent = status_labels[status] + " ▼";
              data.next.container.querySelector("#status-options").classList.remove("show");

            var datad = {
              action: 'update_post_status', // Nom de l'action qui sera utilisée dans le PHP
              post_id: post_id,
              status: status,
            };

            const adminAjaxUrl = document.querySelector('.main').getAttribute('data-admin-ajax');
            jQuery.post(adminAjaxUrl, datad, function(response) {
              status_notif_.innerHTML = response.data.message;

              if(status === 'erase') window.location.href  = '/';

              console.log(response); // Réponse du serveur (en cas de succès ou d'erreur)
            });
          }

          // Close the dropdown if the user clicks outside of it
          window.onclick = function(event) {
              if (!event.target.matches('#post-status')) {
                  var dropdowns = data.next.container.querySelector(".dropdown-content");
                  for (var i = 0; i < dropdowns.length; i++) {
                      var openDropdown = dropdowns[i];
                      if (openDropdown.classList.contains('show')) {
                          openDropdown.classList.remove('show');
                      }
                  }
              }
          };
    }
   

  // todo_augustin: read_more functionality
  var readMoreBtns = data.next.container.querySelectorAll(".read-more-btn_");
  var expandableContents = data.next.container.querySelectorAll(".expandablecontent");

  readMoreBtns.forEach((readMoreBtn, index) => {
    var expandableContent = expandableContents[index];

    if (expandableContent) {
      var fullText = expandableContent.getAttribute("data-full-text");
      var postContent = data.next.container.querySelectorAll(".post-content_")[index];

      readMoreBtn.addEventListener('click', (e) => {
        e.preventDefault();  // Prevent default action if the button is within a form or link

        if (postContent) {
          postContent.innerHTML = fullText.replace(/\n/g, "<br>");
        }

        // Hide the Read More button after clicking
        readMoreBtn.style.display = "none";
      });
    }
  });


  // todo_augustin: Popup functionality for editing post
    const editButton = data.next.container.querySelector('.edit_post_main');
    const popup = data.next.container.querySelector('#editPostPopup');
    const closeButton = popup.querySelector('.close-btn-circle');
    let currentStep = 0;
  const popupContent = popup.querySelector('.popup-content'); // Cible le contenu du popup

  // Cible le contenu du popup

    // Show popup on edit button click
    if (editButton) {
        editButton.addEventListener("click", function(event) {
            event.preventDefault();
            popup.style.display = "flex"; // Center using flex display
        });
    }
// Empêcher la fermeture si on clique dans le contenu du popup
  if (popup) {
    popup.addEventListener("click", function(event) {

    });
  }
    // Close popup on close button click
    if (closeButton) {
        closeButton.addEventListener("click", function() {
            popup.style.display = "none";
        });
    }

    // Close popup when clicking outside of it
    window.addEventListener("click", function(event) {
        if (event.target === popup) {
            popup.style.display = "none";
        }
    });

  // Navigate steps with "Previous" and "Next" buttons
  window.navigateSteps = function(step) {
    const steps = data.next.container.querySelectorAll(".form-step");
    steps[currentStep].style.display = "none"; // Hide current step

    currentStep += step;

    // Ensure currentStep remains in valid range
    if (currentStep < 0) {
      currentStep = 0; // Don't go below step 0
    } else if (currentStep >= steps.length) {
      currentStep = 0; // Reset to step 0 if maximum step is reached
    }

    steps[currentStep].style.display = "block"; // Show new step
    data.next.container.querySelector("#step-count").textContent = `${currentStep } / ${steps.length- 1}`; // Adjusted to show 1-based index
  };

// Go to a specific step directly from summary
  window.goToStep = function(stepNumber) {
    const steps = data.next.container.querySelectorAll(".form-step");
    steps[currentStep].style.display = "none"; // Hide current step
    currentStep = stepNumber;
    steps[currentStep].style.display = "block"; // Show selected step
    data.next.container.querySelector("#step-count").textContent = `${currentStep } / ${steps.length- 1}`; // Adjusted to show 1-based index
  };

  // makeRelationBtw(current_user_id.getAttribute("data-u-id"), e.currentTarget.getAttribute("data-relation-him"), "request-contact-list", e.currentTarget);




};


}

export default new Post();
