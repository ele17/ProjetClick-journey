// recherche.js

document.addEventListener("DOMContentLoaded", () => {
    const sortSelect = document.getElementById("sort-criteria");
    const resultsContainer = document.getElementById("results-container");

    if (!sortSelect || !resultsContainer) return;

    // Fonction utilitaire pour récupérer une valeur numérique depuis un attribut data-
    function getNumericValue(element, attribute) {
        return parseFloat(element.dataset[attribute]) || 0;
    }

    // Fonction de tri des éléments en fonction du critère sélectionné
    function sortResults(criteria) {
        // Sélectionner tous les éléments de résultats
        const items = Array.from(resultsContainer.querySelectorAll(".result-item"));

        items.sort((a, b) => {
            let aVal, bVal;
            switch (criteria) {
                case "date":
                    // On suppose que data-date contient une date au format ISO.
                    aVal = new Date(a.dataset.date);
                    bVal = new Date(b.dataset.date);
                    return aVal - bVal;
                case "prix":
                    aVal = getNumericValue(a, "prix");
                    bVal = getNumericValue(b, "prix");
                    return aVal - bVal;
                case "duree":
                    aVal = getNumericValue(a, "duree");
                    bVal = getNumericValue(b, "duree");
                    return aVal - bVal;
                case "etapes":
                    aVal = getNumericValue(a, "etapes");
                    bVal = getNumericValue(b, "etapes");
                    return aVal - bVal;
                default:
                    return 0;
            }
        });

        // Réorganiser les éléments dans le conteneur
        items.forEach(item => resultsContainer.appendChild(item));
    }

    // Événement sur le sélecteur de tri
    sortSelect.addEventListener("change", (event) => {
        sortResults(event.target.value);
    });
});
