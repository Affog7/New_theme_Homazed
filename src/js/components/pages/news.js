
const News_Init = () => {

             
         

            let searchTimeout;

          document.querySelector('#searchInputNews').addEventListener('input', function() {
              clearTimeout(searchTimeout); // Efface le délai précédent
  
              const query = this.value;
  
              // Ne lance la recherche que si l'utilisateur a tapé au moins 3 caractères
              if (query.length >= 3) {
                  searchTimeout = setTimeout(() => {
                      fetchTemplates(query);
                  }, 300); // Délai de 300 ms pour éviter trop de requêtes
              } else {
                  document.querySelector('#results_news_selectors').innerHTML = '';
              }
          });
          
   
 
      
        function fetchTemplates(query) {
          const apiUrl = `/wp-json/custom/v1/posts?search=${encodeURIComponent(query)}`;

          fetch(apiUrl)
              .then(response => {
                  if (!response.ok) {
                      throw new Error('Aucun post trouvé.');
                  }
                  return response.json();
              })
              .then(data => {
                  displayResults(data);
              })
              .catch(error => {
                  document.querySelector('#results_news_selectors').innerHTML = `<p>${error.message}</p>`;
              });
      }

      function displayResults(posts) {
          const resultsContainer = document.querySelector('#results_news_selectors');
          resultsContainer.innerHTML = ''; // Vider les résultats précédents

          posts.forEach(post => {
              const postElement = document.createElement('div');
              postElement.classList.add('post-template');
              postElement.innerHTML = `
                  <h2>${post.title}</h2>
                  <div>${post.content}</div>
                  <p><strong>Type de post:</strong> ${post.type}</p>
              `;
              resultsContainer.appendChild(postElement);
          });
      }
         
   

  };
  
  export default News_Init;
  