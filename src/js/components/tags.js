const Tags_Init = () => {
  class TaxonomiesField {
    constructor(el) {
      this.el = el;
      this.free_text_field = this.el;
      this.free_text_field_input = this.free_text_field.querySelector("input");
      this.array_hashtags = this.free_text_field_input.value
        .split(/[\s,]+/)
        .filter(e => e.trim().length > 0); // Initialisation des hashtags
      
      this.initFakeInputs();

      this.free_text_field_input.classList.add("hide");

      this.tempInputWrapper = document.createElement('div');
      this.tempInputWrapper.classList.add("tag-list-wrapper");

      this.tempInputWrapper.appendChild(this.tempInput);
      this.el.querySelector(".ginput_container").appendChild(this.tempInputWrapper);
    }

    initFakeInputs() {
      this.tempInput = document.createElement('div');
      this.tempInput.classList.add("form-tag-list");

      // Crée des tags existants s'ils existent
      this.array_hashtags.forEach(hashtag => {
        this.createTagElement(hashtag);
      });

      // Crée un champ de saisie pour les nouveaux tags
      this.createInputTag();
    }

    createTagElement(hashtag) {
      const span = document.createElement('span');
      const node = document.createTextNode(`#${hashtag}`);
      span.classList.add("tag");
      span.appendChild(node);

      // Ajouter un bouton de suppression
      const deleteButton = document.createElement('button');
      deleteButton.classList.add("delete-tag");
      deleteButton.textContent = "x";
      deleteButton.addEventListener('click', () => this.deleteTag(span, hashtag));
      span.appendChild(deleteButton);

      this.tempInput.appendChild(span);
    }

    createInputTag() {
      // Vérifie si un champ de saisie existe déjà
      if (this.tempInput.querySelector(".new-tag-input")) return;

      const inputSpan = document.createElement('span');
      inputSpan.classList.add("new-tag");

      const input = document.createElement("input");
      input.type = "text";
      input.classList.add("new-tag-input");
      input.style.width = "40px";
      input.addEventListener("input", this.adjustInputWidth.bind(this, input));
      input.addEventListener("keydown", this.handleKeyDown.bind(this, input));
      
      inputSpan.appendChild(input);
      this.tempInput.appendChild(inputSpan);

      input.focus();
    }

    adjustInputWidth(input) {
      input.style.width = `${Math.max(40, input.value.length * 10)}px`;
    }

    handleKeyDown(input, event) {
      if (["Enter", ","].includes(event.key)) {
        event.preventDefault();
        const value = input.value.trim();
        if (value) {
          this.array_hashtags.push(value);
          this.createTagElement(value);
          input.value = "";
          this.updateHiddenInput();
        }
      } else if (event.key === "Backspace" && input.value.length === 0) {
        this.deleteLastTag();
      }
    }

    deleteTag(tagEl, hashtag) {
      const index = this.array_hashtags.indexOf(hashtag);
      if (index > -1) {
        this.array_hashtags.splice(index, 1);
        tagEl.remove();
        this.updateHiddenInput();
      }
    }

    deleteLastTag() {
      const lastTag = this.tempInput.querySelector(".tag:last-child");
      if (lastTag) {
        const hashtag = lastTag.textContent.slice(1, -1); // Retirer "#" et "x"
        this.deleteTag(lastTag, hashtag);
      }
    }

    updateHiddenInput() {
      this.free_text_field_input.value = this.array_hashtags.join(",");
    }
  }

  const taxonomiesFields = document.querySelectorAll(".dynamic-tags");
  if (taxonomiesFields.length) {
    [...taxonomiesFields].forEach(field => new TaxonomiesField(field));
  }

  document.addEventListener("DOMContentLoaded", () => {
    if (window.jQuery) {
      jQuery(document).on("gform_page_loaded", () => {
        const taxonomiesFields = document.querySelectorAll(".dynamic-tags");
        if (taxonomiesFields.length) {
          [...taxonomiesFields].forEach(field => new TaxonomiesField(field));
        }
      });
    }
  });
};

export default Tags_Init;
