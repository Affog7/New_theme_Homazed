import News_V1 from "./news_v1";
import Slider_map_search_init from "../Slider_map_search_Init";

const News_Init = () => {


    document.addEventListener('DOMContentLoaded', function () {
        if (window.jQuery) {

            //
          jQuery(document).on('gform_page_loaded', function (event, form_id, current_page) {
            const s_inps = document.querySelectorAll(".searchInputNews_v1");
            if (s_inps.length) {
                [...s_inps].map((s_inp) => new News_V1(s_inp));
              }
          });

          // for edit
          const s_inps = document.querySelectorAll(".searchInputNews_v1");
          if (s_inps.length) {
            [...s_inps].map((s_inp) => new News_V1(s_inp));
          }

          // URL api preview

            $('.copy_paste_news_176  input').on('change', function () {
              let postLink = $(this).val(); // Récupère la valeur du champ input
              let inputField = $(this); // Stocke l’élément input

              // Vérifie si l'aperçu existe déjà, sinon, le crée juste après l'input
              if (inputField.next('#link-preview-container').length === 0) {
                $('<div id="link-preview-container" style="margin-top:10px;"></div>').insertAfter(inputField);
              }

              if (postLink.length > 0) {
                $.ajax({
                  url: '/wp-json/custom/v1/link-preview_news/', // L’URL de l’API
                  method: 'POST',
                  contentType: 'application/json',
                  data: JSON.stringify({ url: postLink }),
                  success: function (response) {
                    if (response.preview) {
                      inputField.next('#link-preview-container').html(response.preview);
                    } else {
                      inputField.next('#link-preview-container').html('<p style="color:red;">Aucun aperçu disponible.</p>');
                    }
                  },
                  error: function () {
                    inputField.next('#link-preview-container').html('<p style="color:red;">Erreur lors du chargement de l’aperçu.</p>');
                  }
                });
              } else {
                inputField.next('#link-preview-container').html('');
              }
            });
      // end




        }
      });


  };

  export default News_Init;
