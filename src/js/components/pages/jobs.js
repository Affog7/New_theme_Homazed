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


          // title
          jQuery(document).on('gform_page_loaded', function (event, form_id, current_page) {
            const dropdowns = document.querySelectorAll(".dropdown-group-jobs-title");    
            if (dropdowns.length) {
                [...dropdowns].map((ele) => new JobTitle(ele));
              }
          }); 


          // Jobs keys
          jQuery(document).on('gform_page_loaded', function (event, form_id, current_page) {
            
             // Cacher tous les textareas
             const textareas = document.querySelectorAll('.jobs-features-key textarea');
             textareas.forEach(textarea => {
                 textarea.style.display = 'none';
             });
         
             // Ajouter un événement de clic sur chaque label
             const labels = document.querySelectorAll('.jobs-features-key label');
             labels.forEach(label => {
                label.style.cursor = 'pointer';
                label.addEventListener('mousedown', function (event) {
                    event.preventDefault(); // Empêcher la sélection de texte pendant l'ouverture du textarea
        
                    // Cacher tous les textareas
                    textareas.forEach(textarea => {
                        textarea.style.display = 'none';
                    });
        
                    // Trouver et afficher le textarea correspondant
                    const textarea = this.nextElementSibling.querySelector('textarea');
                    if (textarea) {
                        textarea.style.display = 'block';
                    }
                });
            });



          }); 

         
           
      
        
        }
      });

  };
  
  export default Jobs_Init;
  