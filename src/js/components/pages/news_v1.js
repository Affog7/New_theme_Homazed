import Modals_Init from "../modal";
import Slider_map_search_init from "../Slider_map_search_Init";

class News_V1 {
    constructor(el) {
        this.el = el;
        this.results_news_selectors = this.el.parentElement.querySelector("#results_news_selectors");
        let searchTimeout;

        // Gestion de l'événement d'entrée utilisateur
        this.el.addEventListener('input', (event) => {
            clearTimeout(searchTimeout); // Efface le délai précédent

            const query = event.target.value; // Récupération de la valeur de l'entrée

            // Ne lance la recherche que si l'utilisateur a tapé au moins 3 caractères
            if (query.length >= 3) {
                searchTimeout = setTimeout(() => {
                    this.fetchTemplates(query);
                }, 300); // Délai de 300 ms pour éviter trop de requêtes
            } else {
                this.results_news_selectors.innerHTML = ''; // Vide les résultats si la recherche est trop courte
            }
        });
    }

    // Méthode pour récupérer les templates via l'API
    fetchTemplates(query) {
        const apiUrl = `/wp-json/custom/v1/posts?search=${encodeURIComponent(query)}`;

        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Aucun post trouvé.');
                }
                return response.json();
            })
            .then(data => {
                this.displayResults(data);
              Slider_map_search_init();
            })
            .catch(error => {
                this.results_news_selectors.innerHTML = `<p>${error.message}</p>`;
            });
    }

    // Méthode pour afficher les résultats dans le DOM
    displayResults(posts) {
        const resultsContainer = this.results_news_selectors; // Utilisation correcte du conteneur
        resultsContainer.innerHTML = ''; // Vide les résultats précédents

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

        // Met à jour les modals après ajout des nouveaux contenus
        Modals_Init(resultsContainer);

    }
}

export default News_V1;
