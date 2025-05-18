// formValidation.js

document.addEventListener("DOMContentLoaded", () => {
    const forms = document.querySelectorAll("form");

    forms.forEach(form => {
        const inputs = form.querySelectorAll("input, textarea");

        inputs.forEach(input => {
            // Ajout compteur si maxLength défini
            if (input.maxLength > 0) {
                const counter = document.createElement("div");
                counter.className = "char-counter";
                counter.textContent = `0 / ${input.maxLength}`;
                input.parentNode.insertBefore(counter, input.nextSibling);

                input.addEventListener("input", () => {
                    counter.textContent = `${input.value.length} / ${input.maxLength}`;
                });
            }

            // Affichage / Masquage du mot de passe
            if (input.type === "password") {
                const toggle = document.createElement("span");
                toggle.textContent = "👁️";
                toggle.style.cursor = "pointer";
                toggle.style.marginLeft = "8px";

                input.parentNode.insertBefore(toggle, input.nextSibling);

                toggle.addEventListener("click", () => {
                    input.type = input.type === "password" ? "text" : "password";
                });
            }
        });

        form.addEventListener("submit", e => {
            e.preventDefault();

            let valid = true;
            let errors = [];

            const email = form.querySelector("input[type='email']");
            const pwd = form.querySelector("input[type='password']");
            const pseudo = form.querySelector("input[name='pseudo']");

            if (email && !/\S+@\S+\.\S+/.test(email.value)) {
                valid = false;
                errors.push("Adresse e-mail invalide.");
            }

            if (pwd && pwd.value.length < 6) {
                valid = false;
                errors.push("Mot de passe trop court (min. 6 caractères).");
            }

            if (pseudo && pseudo.value.length < 3) {
                valid = false;
                errors.push("Pseudo trop court (min. 3 caractères).");
            }

            const errorContainer = form.querySelector(".form-errors") || document.createElement("div");
            errorContainer.className = "form-errors";
            errorContainer.style.color = "red";
            errorContainer.innerHTML = "";

            if (!form.contains(errorContainer)) {
                form.insertBefore(errorContainer, form.firstChild);
            }

            if (valid) {
                errorContainer.innerHTML = "";
                form.submit(); // Envoi manuel si tout est OK
            } else {
                errors.forEach(err => {
                    const p = document.createElement("p");
                    p.textContent = err;
                    errorContainer.appendChild(p);
                });
            }
        });
    });
});
