const Tags_Init = () => {
  class TaxonomiesField {
    constructor(el) {
      this.el = el;
      this.free_text_field = this.el;
      this.free_text_field_input = this.free_text_field.querySelector("input");
      this.current_value = this.free_text_field_input.value.split(/[\s,]+/).filter(e => e.trim().length > 0);
      this.array_hashtags_init = this.current_value;
      this.array_hashtags = this.current_value;
      this.initFakeInputs();

      this.free_text_field_input.classList.add("hide");

      this.tempInputWrapper = document.createElement('div');
      this.tempInputWrapper.classList.add("tag-list-wrapper");

      this.tempInputWrapper.appendChild(this.tempInput);
      this.el.querySelector(".ginput_container").appendChild(this.tempInputWrapper);
    }

    createFakeInput() {
      var again = true;
      let array_hashtags_cleaned_up = this.array_hashtags.map(str => str.replace(new RegExp("#", 'g'), ''));
      this.free_text_field_input.value = array_hashtags_cleaned_up.join(',');
      this.createInputTag(again);
    }

    initFakeInputs() {
      var again = false;
      this.tempInput = document.createElement('div');
      this.tempInput.classList.add("form-tag-list");
      // Create existing tags
      this.array_hashtags.forEach(hashtag => {
        const span = document.createElement('span');
        const node = document.createTextNode('#' + hashtag);
        span.classList.add("tag");
        span.appendChild(node);

        // Add delete button to each tag
        const deleteButton = document.createElement('button');
        deleteButton.classList.add("delete-tag");
        deleteButton.textContent = "x";
        deleteButton.addEventListener('click', () => this.deleteTag(span, hashtag));
        span.appendChild(deleteButton);

        this.tempInput.appendChild(span);
      });
      this.createInputTag(again);
    }

    createInputTag(again) {
      // Vérifier s'il y a déjà un input "new-tag" avant d'en créer un autre
      const existingNewTag = this.tempInput.querySelector('.new-tag');
      if (existingNewTag) {
        return;  // Si un élément "new-tag" existe déjà, on ne crée pas de nouvel input
      }

      var input, inputSpan;
      inputSpan = document.createElement('span');
      inputSpan.classList.add("new-tag");
      input = document.createElement("input");
      input.classList = "new-tag-input";
      input.type = "text";
      input.style.width = "40px";  // Fixer la largeur initiale
      inputSpan.appendChild(input);
      this.tempInput.appendChild(inputSpan);

      if (again) {
        input.focus();
      }

      this.tempInput.input = input;
      this.tempInput.inputSpan = inputSpan;
      this.tempInput.that = this;
      this.tempInput.again = again;
      this.tempInput.addEventListener('click', this.focusFakeInput, false);
      this.tempInput.addEventListener("keydown", this.checkKeyDown, false);
    }

    checkKeyDown(event) {
      var inputLength = event.currentTarget.input.value.length;

      event.currentTarget.input.style.width = ((inputLength * 10) + 40) + "px";

      if (event.key === "#") {
        // this.initHashtag();
      } else if (arrayOfFireKeys.includes(event.key)) {
        event.preventDefault();
        event.stopPropagation();
        event.currentTarget.that.closeHashtag(event.currentTarget.inputSpan, event.currentTarget.input);
        event.currentTarget.input.value = "";
      } else if (event.key === "Backspace") {
        if (event.currentTarget.input.value.length < 1) {
          event.currentTarget.that.deleteLastHashtag();
        }
      }
    }

    deleteLastHashtag() {
      this.array_hashtags.pop();
      var tags = this.tempInput.getElementsByClassName('tag');
      var newTag = this.tempInput.querySelector('.new-tag');
      var lastTagEl = tags[tags.length - 1];

      // Ajout d'une vérification pour éviter d'essayer de supprimer un élément inexistant
      if (lastTagEl) {
        lastTagEl.remove();
        this.createFakeInput();
      }
    }

    deleteTag(tagEl, hashtag) {
      // Vérification si le tag existe avant d'essayer de le supprimer
      if (tagEl && tagEl.parentNode) {
        // Supprimer le hashtag de l'array
        const index = this.array_hashtags.indexOf(hashtag);
        if (index !== -1) {
          this.array_hashtags.splice(index, 1);
        }

        // Supprimer l'élément DOM
        tagEl.parentNode.removeChild(tagEl);

        // Mettre à jour l'affichage
        this.createFakeInput();
      }
    }

    closeHashtag(inputSpan, input) {
      var realInput = input.value.replace("#", "").replace(" ", "");
      if (realInput.length > 1) {
        this.array_hashtags.push("#" + realInput);
        const node = document.createTextNode("#" + realInput);
        inputSpan.classList.add("tag");
        inputSpan.classList.remove("new-tag");
        inputSpan.appendChild(node);

        // Ajouter le bouton de suppression au nouveau tag
        const deleteButton = document.createElement('button');
        deleteButton.classList.add("delete-tag");
        deleteButton.textContent = "x";
        deleteButton.addEventListener('click', () => this.deleteTag(inputSpan, realInput));
        inputSpan.appendChild(deleteButton);

        inputSpan.focus();
        input.remove();
        this.tempInput.removeEventListener("keydown", this.checkKeyDown, false);
        this.createFakeInput();
      }
    }

    focusFakeInput(evt) {
      evt.preventDefault();
      evt.currentTarget.input.focus();
      evt.currentTarget.removeEventListener('click', this.focusFakeInput, false);
    }
  }

  const arrayOfFireKeys = [" ", "Enter", ","];

  const taxonomies_fields = document.querySelectorAll(".dynamic-tags");

  if (taxonomies_fields.length) {
    [...taxonomies_fields].map((taxonomies_field) => new TaxonomiesField(taxonomies_field));
  }

  document.addEventListener('DOMContentLoaded', function () {
    if (window.jQuery) {
      jQuery(document).on('gform_page_loaded', function (event, form_id, current_page) {
        const taxonomies_fields = document.querySelectorAll(".dynamic-tags");

        if (taxonomies_fields.length) {
          [...taxonomies_fields].map((taxonomies_field) => new TaxonomiesField(taxonomies_field));
        }
      });
    }
  });
}

export default Tags_Init;
