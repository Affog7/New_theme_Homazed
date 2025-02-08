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

        }
      });


  };

  export default News_Init;
