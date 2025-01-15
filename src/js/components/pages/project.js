import ProjectsCategory from "./projects_category"  
const Projects_Init = (data) => {

  
    // Initialize all dropdowns within the container


    document.addEventListener('DOMContentLoaded', function () {
        if (window.jQuery) {

            // activity
          jQuery(document).on('gform_page_loaded', function (event, form_id, current_page) {
            const dropdowns = document.querySelectorAll(".dropdown-group-projects");    
            if (dropdowns.length) {
                [...dropdowns].map((dropdown) => new ProjectsCategory(dropdown));
              }
          });

          //edit job
          const dropdownsJ = document.querySelectorAll(".dropdown-group-projects");    
            if (dropdownsJ.length) {
                [...dropdownsJ].map((dropdownJ) => new ProjectsCategory(dropdownJ));
              }
              
         
    
          
        
        }
      });

  };
  
  export default Projects_Init;
  