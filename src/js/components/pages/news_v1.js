import Modals_Init from "../modal";
import Slider_map_search_init from "../Slider_map_search_Init";

class NewsV1 {
  constructor(el) {
    this.el = el;
    this.resultsContainer = this.el.parentElement.querySelector("#results_news_selectors");
    this.resultsSelected = this.el.parentElement.querySelector("#results_selected");
    this.hiddenInput = this.el.parentElement.parentElement.querySelector(".link_w_post_hidden_173 input");
    this.selectedPostIds = new Set(this.hiddenInput.value ? this.hiddenInput.value.split(",") : []);

    this.loadSelectedPosts();
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
      .then(response => response.ok ? response.json() : Promise.reject("Aucun post trouvé."))
      .then(data => {
        this.displayResults(data);
        Slider_map_search_init();
      })
      .catch(error => {
        this.resultsContainer.innerHTML = `<p>${error}</p>`;
      });
  }

  displayResults(posts) {
    this.resultsContainer.innerHTML = "";
    posts.forEach(post => {
      const postElement = document.createElement("div");
      postElement.classList.add("post-template_news");
      postElement.innerHTML = `
                <div class="post-content_news">
                    <h2>${post.title}</h2>
                    <div>${post.content}</div>
                    <p><strong>Type de post:</strong> ${post.type}</p>
                </div>
                <label class="custom-checkbox">
                    <input type="checkbox" class="premium_renewal" data-id="${post.id}" name="post_Is_Automatic_Renewal" ${this.selectedPostIds.has(post.id.toString()) ? "checked" : ""}>
                    <span class="checkmark"></span>
                    <b>Sélectionner ce post</b>
                </label>
            `;
      this.resultsContainer.appendChild(postElement);

      const checkbox = postElement.querySelector(".premium_renewal");
      checkbox.addEventListener("change", () => {
        if (checkbox.checked) {
          this.selectedPostIds.add(post.id.toString());
          this.addPostToSelected(post);
        } else {
          this.selectedPostIds.delete(post.id.toString());
          this.removePostFromSelected(post.id);
        }
        this.updateHiddenField();
      });
    });

    Modals_Init(this.resultsContainer);
  }

  addPostToSelected(post) {
    if (!this.resultsSelected || this.resultsSelected.querySelector(`[data-id="${post.id}"]`)) return;
    const selectedPostElement = document.createElement("div");
    selectedPostElement.classList.add("selected-post");
    selectedPostElement.setAttribute("data-id", post.id);
    selectedPostElement.innerHTML = `<h3>${post.title}</h3><div>${post.content}</div>`;
    this.resultsSelected.appendChild(selectedPostElement);
  }

  removePostFromSelected(postId) {
    const selectedPostElement = this.resultsSelected.querySelector(`[data-id="${postId}"]`);
    if (selectedPostElement) {
      selectedPostElement.remove();
    }
  }

  updateHiddenField() {
    this.hiddenInput.value = Array.from(this.selectedPostIds).join(",");
  }

  restoreHiddenField() {
    this.hiddenInput.value = Array.from(this.selectedPostIds).join(",");
  }

  loadSelectedPosts() {
    const storedIds = this.hiddenInput.value.split(",").filter(id => id.trim() !== "");
    this.selectedPostIds = new Set(storedIds);
    storedIds.forEach(id => {
      fetch(`/wp-json/custom/v1/posts/${id}`)
        .then(response => response.json())
        .then(post => this.addPostToSelected(post))
        .catch(error => console.error(`Erreur lors du chargement du post ${id}:`, error));
    });
  }
}

export default NewsV1;
