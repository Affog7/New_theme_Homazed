class company_v1 {
  constructor(el) {
    this.el = el;
    this.input = this.el.querySelector("input");
    this.optionsContainer = this.el.querySelector(".options-container-company");
    this.tagsContainer = this.el.querySelector(".tags-container-company");
    this.options = this.el.querySelectorAll(".options-container-company div");

    this.hiddenTagsInput = document.querySelector(".company-i-work-for-input-175 input");

    // Charger les tags si existants
    this.loadTags();

    // Attacher les écouteurs d'événements
    this.input.addEventListener("focus", () => this.openDropdown());
    this.input.addEventListener("input", (e) => this.filterOptions(e));
    document.addEventListener("click", (e) => this.handleOutsideClick(e));

    this.options.forEach((option) => {
      option.addEventListener("click", () => this.addTag(option.textContent));
    });
  }

  openDropdown() {
    this.optionsContainer.classList.remove("hidden-company");
  }

  closeDropdown() {
    this.optionsContainer.classList.add("hidden-company");
  }

  filterOptions(event) {
    const filterText = event.target.value.toLowerCase();
    this.options.forEach((option) => {
      if (option.textContent.toLowerCase().includes(filterText)) {
        option.style.display = "block";
      } else {
        option.style.display = "none";
      }
    });
  }

  addTag(tagText) {
    const existingTags = this.tagsContainer.querySelectorAll(".tag");
    const tagExists = Array.from(existingTags).some(tag => tag.textContent.trim() === tagText);

    if (!tagExists) {
      const tag = document.createElement("div");
      tag.className = "tag";
      tag.innerHTML = `${tagText} <span class="remove-tag">x</span>`;
      this.tagsContainer.appendChild(tag);

      // Attacher un événement pour supprimer le tag et mettre à jour les tags cachés
      tag.querySelector(".remove-tag").addEventListener("click", () => {
        tag.remove();
        this.updateHiddenTags();
      });

      this.updateHiddenTags(); // Mettre à jour les tags dans le champ caché
    }
    this.closeDropdown();
  }

  handleOutsideClick(e) {
    if (!this.el.contains(e.target)) {
      this.closeDropdown();
    }
  }

  updateHiddenTags() {
    const tags = [];
    this.tagsContainer.querySelectorAll(".tag").forEach(tag => {
      tags.push(tag.textContent.trim().replace("x", "").trim());
    });

    // Mettre à jour la valeur du champ caché avec les tags
    this.hiddenTagsInput.value = tags.join(",");
  }

  loadTags() {
    // Charger les tags depuis le champ caché si présents
    const savedTags = this.hiddenTagsInput.value.split(",").filter(tag => tag.trim() !== "");
    savedTags.forEach(tagText => {
      const tag = document.createElement("div");
      tag.className = "tag";
      tag.innerHTML = `${tagText} <span class="remove-tag">x</span>`;
      this.tagsContainer.appendChild(tag);

      // Attacher un événement pour supprimer le tag et mettre à jour les tags cachés
      tag.querySelector(".remove-tag").addEventListener("click", () => {
        tag.remove();
        this.updateHiddenTags();
      });
    });
  }
}

export default company_v1;



