class company_v1 {
  constructor(el) {
    this.el = el;
    this.input = this.el.querySelector("input");
    this.optionsContainer = this.el.querySelector(".options-container-company");
    this.tagsContainer = this.el.querySelector(".tags-container-company");
    this.addButton = this.el.querySelector(".add-button-company");
    this.options = this.el.querySelectorAll(".options-container-company div");
    this.hiddenTagsInput = document.querySelector(".company-i-work-for-input-175  input");

    // Charger les tags si existants (par exemple, à partir du champ caché)
    this.loadTags();

    // Attacher les écouteurs d'événements
    this.input.addEventListener("focus", () => this.openDropdown());
    this.input.addEventListener("input", (e) => this.filterOptions(e));
    this.addButton.addEventListener("click", () => this.addCustomTag());
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

    // Vérifier s'il y a déjà un tag et ne pas permettre l'ajout de plus d'un tag
    if (existingTags.length === 0) {
      const tag = document.createElement("div");
      tag.className = "tag";
      tag.innerHTML = `${tagText} <span class="remove-tag">x</span>`;
      this.tagsContainer.appendChild(tag);

      // Attacher un événement pour supprimer le tag et réactiver l'entrée
      tag.querySelector(".remove-tag").addEventListener("click", () => {
        tag.remove();
        this.updateHiddenTags();
        this.input.disabled = false; // Réactiver l'entrée
      });

      this.input.value = '';
      this.input.disabled = true; // Désactiver l'entrée après l'ajout d'un tag
      this.closeDropdown();
      this.updateHiddenTags();
    }
  }

  addCustomTag() {
    const customTagText = this.input.value.trim();
    if (customTagText) {
      this.addTag(customTagText);
    }
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

    this.hiddenTagsInput.value = tags.join(",");
  }

  loadTags() {
    const savedTags = this.hiddenTagsInput.value.split(",").filter(tag => tag.trim() !== "");
    savedTags.forEach(tagText => {
      this.addTag(tagText);
    });
  }
}

export default company_v1;



