document.addEventListener("DOMContentLoaded", function () {
  const tagLists = document.querySelectorAll(".tag-list");
  const tagListContainers = document.querySelectorAll(".tag-list-container");
  const leftChevrons = document.querySelectorAll(".left-chevron");
  const rightChevrons = document.querySelectorAll(".right-chevron");

  const scrollAmount = 100; // Adjust this value for scroll speed

  tagLists.forEach((tagList, index) => {
    let scrollPosition = 0;

    // Function to update chevron visibility based on content overflow
    const updateChevrons = () => {
      const maxScroll = tagList.scrollWidth - tagListContainers[index].clientWidth;

      // Show or hide left chevron
      if (scrollPosition > 0) {
        leftChevrons[index].style.display = "block";
      } else {
        leftChevrons[index].style.display = "none";
      }

      // Show or hide right chevron
      if (scrollPosition < maxScroll) {
        rightChevrons[index].style.display = "block";
      } else {
        rightChevrons[index].style.display = "none";
      }
    };

    // Initial chevron visibility check
    if (tagList.scrollWidth <= tagListContainers[index].clientWidth) {
      leftChevrons[index].style.display = "none";
      rightChevrons[index].style.display = "none";
    } else {
      updateChevrons();
    }

    // Add event listener to the corresponding left chevron for this tagList
    leftChevrons[index].addEventListener("click", (event) => {
      event.stopPropagation(); // Prevent click from bubbling up
      scrollPosition -= scrollAmount;
      if (scrollPosition < 0) scrollPosition = 0;
      tagList.style.transform = `translateX(-${scrollPosition}px)`;
      updateChevrons();
    });

    // Add event listener to the corresponding right chevron for this tagList
    rightChevrons[index].addEventListener("click", (event) => {
      event.stopPropagation(); // Prevent click from bubbling up
      const maxScroll = tagList.scrollWidth - tagListContainers[index].clientWidth;
      scrollPosition += scrollAmount;
      if (scrollPosition > maxScroll) scrollPosition = maxScroll;
      tagList.style.transform = `translateX(-${scrollPosition}px)`;
      updateChevrons();
    });

    // Re-check chevron visibility on window resize
    window.addEventListener("resize", updateChevrons);
  });
  });






// gestion des post_hide et autre
document.addEventListener("DOMContentLoaded", function () {
  // Hide Post Button
  document.querySelectorAll(".hide-post-button").forEach(button => {
    button.addEventListener("click", function () {
      const postId = this.getAttribute("data-post-id");
      fetchHidePost(postId, this);
    });
  });


  // Report Post Button
  document.querySelectorAll(".report-post-button").forEach(button => {
    button.addEventListener("click", function () {
      const postId = this.getAttribute("data-post-id");
      fetchReportPost(postId);
    });
  });

  // Function to handle Hide Post request
  function fetchHidePost(postId, button) {
    fetch(`/wp-json/custom-api/v1/hide_post/${postId}`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-WP-Nonce": customApi.nonce // Security nonce
      }
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          button.closest(".post-container").style.display = "none"; // Hide post visually
        } else {
          alert("Error hiding post");
        }
      })
      .catch(error => console.error("Error:", error));
  }

  // Function to handle Report Post request
  function fetchReportPost(postId) {
    fetch(`/wp-json/custom-api/v1/report_post/${postId}`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-WP-Nonce": customApi.nonce // Security nonce
      }
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert("The post has been reported successfully.");
        } else {
          alert("Error reporting post");
        }
      })
      .catch(error => console.error("Error:", error));
  }
});



// choix unique premium MONTH CREATION POST TODO_AUGUSTIN

document.addEventListener('DOMContentLoaded', function () {
  // Récupérer toutes les cases à cocher avec un nom spécifique
  const checkboxes = document.querySelectorAll('input[name^="input_106"]');

  // Ajouter un gestionnaire d'événements pour chaque case à cocher
  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function () {
      if (this.checked) {
        // Décochez toutes les autres cases ayant le même nom de base
        checkboxes.forEach(cb => {
          if (cb !== this) {
            cb.checked = false;
          }
        });
      }
    });
  });
});


document.addEventListener('DOMContentLoaded', function () {
  const deleteButtons = document.querySelectorAll('.delete-image_a');

  deleteButtons.forEach(button => {
      button.addEventListener('click', function () {
          const imageId = this.getAttribute('data-id');
          const postId = this.closest('.gallery-item_a').getAttribute('data-id-post');
          const parentDiv = this.closest('.gallery-item_a');

          if (confirm('Are you sure you want to delete this image?')) {
              fetch(ajaxurl, {
                  method: 'POST',
                  headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                  body: `action=delete_gallery_image&image_id=${imageId}&post_id=${postId}`
              })
                  .then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          parentDiv.remove(); // Supprime l'élément du DOM
                          alert('Image deleted successfully.');
                      } else {
                          alert(data.data || 'An error occurred.');
                      }
                  })
                  .catch(err => console.error('Error:', err));
          }
      });
  });
});





document.addEventListener('DOMContentLoaded', function () {
  const deleteButtons = document.querySelectorAll('.delete-image_a');

  deleteButtons.forEach(button => {
      button.addEventListener('click', function () {
          const imageId = this.getAttribute('data-id');
          const postId = this.closest('.gallery-item_a').getAttribute('data-id-post');
          const parentDiv = this.closest('.gallery-item_a');

          if (confirm('Are you sure you want to delete this image?')) {
              fetch(ajaxurl, {
                  method: 'POST',
                  headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                  body: `action=delete_gallery_image&image_id=${imageId}&post_id=${postId}`
              })
                  .then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          parentDiv.remove(); // Supprime l'élément du DOM
                          alert('Image deleted successfully.');
                      } else {
                          alert(data.data || 'An error occurred.');
                      }
                  })
                  .catch(err => console.error('Error:', err));
          }
      });
  });
});



// grid instagram

// Gestion des posts
const posts = document.querySelectorAll(".post_prof");

posts.forEach((post) => {
  const thumbnail = post.querySelector(".post_prof-thumbnail");
  const gallery = post.querySelector(".post_prof-gallery");

  // Ouvrir le modal au clic sur le thumbnail
  thumbnail.addEventListener("click", () => {
    const modal = document.getElementById("postModal_prof");
    const modalContent = modal.querySelector(".modal_prof-content");
    const prevBtn = modal.querySelector(".prev");
    const nextBtn = modal.querySelector(".next");

    // Vider le contenu du modal
    modalContent.innerHTML = "";

    // Ajouter les images du post dans le modal
    const images = gallery.querySelectorAll("img");
    let currentIndex = 0;

    images.forEach((img) => {
      const imgClone = img.cloneNode(true);
      modalContent.appendChild(imgClone);
    });

    // Afficher la première image
    showImage(currentIndex);

    // Afficher le modal
    modal.style.display = "block";

    // Gestion de la navigation
    prevBtn.addEventListener("click", () => {
      currentIndex = (currentIndex - 1 + images.length) % images.length;
      showImage(currentIndex);
    });

    nextBtn.addEventListener("click", () => {
      currentIndex = (currentIndex + 1) % images.length;
      showImage(currentIndex);
    });

    function showImage(index) {
      modalContent.querySelectorAll("img").forEach((img, i) => {
        img.style.display = i === index ? "block" : "none";
      });
    }
  });
});

// Fermer le modal
const modal = document.getElementById("postModal_prof");
const closeBtn = modal.querySelector(".close");

closeBtn.addEventListener("click", () => {
  modal.style.display = "none";
});

window.addEventListener("click", (event) => {
  if (event.target === modal) {
    modal.style.display = "none";
  }
});


// recommandation

jQuery(document).ready(function ($) {
  $(".profile-recommend-btn").on("click", function (e) {
    e.preventDefault();

    let button = $(this);
    let postId = button.attr("data-postid");
    let userId = button.attr("data-userid");

    $.ajax({
      type: "POST",
      url: ajaxurl, // WordPress fournit ajaxurl automatiquement si wp_localize_script est utilisé
      data: {
        action: "toggle_profile_recommend",
        post_id: postId,
        user_id: userId,
      },
      success: function (response) {
        if (response.success) {
          button.toggleClass("active");
        } else {
          alert("Erreur : " + response.data);
        }
      },
    });
  });
});


// add contact

jQuery(document).ready(function ($) {
  $(".contact-toggle-btn").on("click", function (e) {
    e.preventDefault();

    let button = $(this);
    let userId = button.attr("data-userid");
    let contactId = button.attr("data-contactid");

    $.ajax({
      type: "POST",
      url: ajaxurl,
      data: {
        action: "toggle_contact",
        user_id: userId,
        contact_id: contactId,
      },
      success: function (response) {
        if (response.success) {
          if (response.data.status === "added") {
            button.addClass("active").text("Remove Contact");
          } else {
            button.removeClass("active").text("Add Contact");
          }
        } else {
          alert("Erreur : " + response.data);
        }
      },
    });
  });
});
