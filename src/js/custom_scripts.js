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
