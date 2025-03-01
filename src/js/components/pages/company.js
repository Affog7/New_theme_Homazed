import company_v1 from "./company_v1";

const Company_Init = (data) => {


  // Initialize all dropdowns within the container


  document.addEventListener('DOMContentLoaded', function () {
    if (window.jQuery) {

      // activity
      jQuery(document).on('gform_page_loaded', function (event, form_id, current_page) {
        const dropdowns = document.querySelectorAll(".dropdown-group-company");
        if (dropdowns.length) {
          [...dropdowns].map((dropdown) => new company_v1(dropdown));
        }
      });

      //edit job
      const dropdownsJ = document.querySelectorAll(".dropdown-group-company");
      if (dropdownsJ.length) {
        [...dropdownsJ].map((dropdownJ) => new company_v1(dropdownJ));
      }


    }
  });

};

export default Company_Init;


