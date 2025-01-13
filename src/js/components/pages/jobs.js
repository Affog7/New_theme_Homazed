import JobActivity from './jobs_activity';
import JobTitle from './jobs_title';
const Jobs_Init = (data) => {

  
    // Initialize all dropdowns within the container


    document.addEventListener('DOMContentLoaded', function () {
        if (window.jQuery) {

            // activity
          jQuery(document).on('gform_page_loaded', function (event, form_id, current_page) {
            const dropdowns = document.querySelectorAll(".dropdown-group-jobs");    
            if (dropdowns.length) {
                [...dropdowns].map((dropdown) => new JobActivity(dropdown));
              }
          });

          //edit job
          const dropdownsJ = document.querySelectorAll(".dropdown-group-jobs");    
            if (dropdownsJ.length) {
                [...dropdownsJ].map((dropdownJ) => new JobActivity(dropdownJ));
              }
              
          // title
          jQuery(document).on('gform_page_loaded', function (event, form_id, current_page) {
            const dropdowns = document.querySelectorAll(".dropdown-group-jobs-title");    
            if (dropdowns.length) {
                [...dropdowns].map((ele) => new JobTitle(ele));
              }
          }); 

          // edit job
            const dropdowns = document.querySelectorAll(".dropdown-group-jobs-title");    
            if (dropdowns.length) {
                [...dropdowns].map((ele) => new JobTitle(ele));
              }
          // Jobs keys
          
        
        }
      });

  };
  
  export default Jobs_Init;
  