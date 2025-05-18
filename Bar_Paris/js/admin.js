// admin.js

document.addEventListener("DOMContentLoaded", () => {
    const delay = 2000; // 2 secondes de "latence"

    // Cibler les éléments interactifs d'admin
    const interactiveElements = document.querySelectorAll(".admin-action");

    interactiveElements.forEach(element => {
        element.addEventListener("change", () => {
            element.disabled = true;

            // Affichage d'un petit effet de "chargement"
            const loading = document.createElement("span");
            loading.textContent = " ⏳";
            loading.className = "loading-indicator";
            element.parentNode.appendChild(loading);

            setTimeout(() => {
                element.disabled = false;
                loading.remove();
                // Ici on simule que la nouvelle valeur est appliquée
                console.log(`Valeur simulée appliquée : ${element.value || element.checked}`);
            }, delay);
        });

        // Pour les boutons
        element.addEventListener("click", (e) => {
            if (element.tagName === "BUTTON") {
                element.disabled = true;
                const originalText = element.textContent;
                element.textContent = "⏳...";

                setTimeout(() => {
                    element.disabled = false;
                    element.textContent = originalText;
                    console.log(`Action simulée pour ${element.dataset.user}`);
                }, delay);
            }
        });
    });
});
