import Modals_Init from "../modal";
import Slider_map_search_init from "../Slider_map_search_Init";

class NewsV1 {
  constructor(el) {
    this.el = el;
    this.resultsContainer = this.el.parentElement.querySelector("#results_news_selectors");
    this.resultsSelected = this.el.parentElement.querySelector("#results_selected");
    this.hiddenInput = this.el.parentElement.parentElement.querySelector(".link_w_post_hidden_173 input");

    // Stocke uniquement un seul ID sélectionné (au lieu de Set pour plusieurs)
    this.selectedPostId = this.hiddenInput.value ? this.hiddenInput.value.trim() : null;

    this.loadSelectedPost();
    this.attachEventListeners();
  }

  attachEventListeners() {
    let searchTimeout;
    this.el.addEventListener("input", (event) => {
      clearTimeout(searchTimeout);
      const query = event.target.value;

      if (query.length >= 3) {
        searchTimeout = setTimeout(() => {
          this.fetchTemplates(query);
        }, 300);
      } else {
        this.resultsContainer.innerHTML = "";
      }
    });

    document.addEventListener("visibilitychange", () => {
      if (document.visibilityState === "visible") {
        this.restoreHiddenField();
      }
    });
  }

  fetchTemplates(query) {
    const apiUrl = `/wp-json/custom/v1/posts?search=${encodeURIComponent(query)}`;

    fetch(apiUrl)
      .then(response => response.ok ? response.json() : Promise.reject("No post found."))
      .then(data => {
        this.displayResults(data);
        Slider_map_search_init();
      })
      .catch(error => {
        this.resultsContainer.innerHTML = `<p>${error}</p>`;
      });
  }

  displayResults(posts) {
    this.resultsContainer.innerHTML = "<br> <h4>Latest Posts</h4> <hr>";

    posts.forEach(post => {
      const postElement = document.createElement("div");
      postElement.classList.add("post-template_news");
      postElement.innerHTML = `
        <div class="post-content_news">
            <div>${post.content}</div>
        </div>
        <label class="custom-checkbox">
            <input type="checkbox" class="premium_renewal" data-id="${post.id}" name="" ${this.selectedPostId === post.id.toString() ? "checked" : ""}>
            <span class="checkmark"></span>
            <b>Select</b>
        </label>
      `;

      this.resultsContainer.appendChild(postElement);

      const checkbox = postElement.querySelector(".premium_renewal");
      checkbox.addEventListener("change", () => {

        if (checkbox.checked) {
          this.selectPost(post);
        } else {
          this.deselectPost();
        }

      });
    });

    Modals_Init(this.resultsContainer);
  }

  selectPost(post) {
    // Désélectionner l'ancien post si un est déjà sélectionné
    if (this.selectedPostId) {
      this.deselectPost();
    }

    this.selectedPostId = post.id.toString();
    this.updateHiddenField();
    this.addPostToSelected(post);
  }

  deselectPost() {
    if (!this.selectedPostId) return;

    // Désélectionner l'ancien post
    const oldCheckbox = this.resultsContainer.querySelector(`.premium_renewal[data-id="${this.selectedPostId}"]`);
    if (oldCheckbox) {
      oldCheckbox.checked = false;
    }

    this.removePostFromSelected(this.selectedPostId);
    this.selectedPostId = null;
    this.updateHiddenField();
  }

  addPostToSelected(post) {
    this.displayResults([post])
    if (!this.resultsSelected) return;

    this.resultsSelected.innerHTML = `
<br>
<h4>Post Linked</h4>
      <div class="selected-post" data-id="${post.id}">
        <div>${post.content}</div>
      </div>  `;
  }

  removePostFromSelected(postId) {
    const selectedPostElement = this.resultsSelected.querySelector(`.selected-post[data-id="${postId}"]`);
    if (selectedPostElement) {
      selectedPostElement.remove();
    }
  }

  updateHiddenField() {
    this.hiddenInput.value = this.selectedPostId || "";
  }

  restoreHiddenField() {
    this.hiddenInput.value = this.selectedPostId || "";
  }

  loadSelectedPost() {
    if (!this.selectedPostId) return;

    fetch(`/wp-json/custom/v1/posts?id_post=${encodeURIComponent(this.selectedPostId)}`)
      .then(response => {
        if (!response.ok) {
          throw new Error(`Erreur HTTP: ${response.status}`);
        }
        return response.json();
      })
      .then(post => this.addPostToSelected(post[0]))
      .catch(error => console.error(`Error ${this.selectedPostId}:`, error));
  }

}

export default NewsV1;
