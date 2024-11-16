document.addEventListener("DOMContentLoaded", function () {
  const tagLists = document.querySelectorAll(".tag-list");
  const leftChevrons = document.querySelectorAll(".left-chevron");
  const rightChevrons = document.querySelectorAll(".right-chevron");

  const scrollAmount = 100;  // Adjust this value for scroll speed

  tagLists.forEach((tagList, index) => {
    let scrollPosition = 0;

    // Add event listener to the corresponding left chevron for this tagList
    leftChevrons[index].addEventListener("click", (event) => {
      event.stopPropagation();  // Prevent click from bubbling up
      scrollPosition -= scrollAmount;
      if (scrollPosition < 0) scrollPosition = 0;
      tagList.style.transform = `translateX(-${scrollPosition}px)`;
    });

    // Add event listener to the corresponding right chevron for this tagList
    rightChevrons[index].addEventListener("click", (event) => {
      event.stopPropagation();  // Prevent click from bubbling up
      const maxScroll = tagList.scrollWidth - tagList.parentElement.clientWidth;
      scrollPosition += scrollAmount;
      if (scrollPosition > maxScroll) scrollPosition = maxScroll;
      tagList.style.transform = `translateX(-${scrollPosition}px)`;
    });
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
