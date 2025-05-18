// profil.js

document.addEventListener("DOMContentLoaded", () => {
    const fields = document.querySelectorAll(".editable-field");
    const submitBtn = document.getElementById("submit-profile-changes");

    let hasChanged = false;

    fields.forEach(fieldWrapper => {
        const input = fieldWrapper.querySelector("input, textarea");
        const editBtn = fieldWrapper.querySelector(".edit-btn");
        const validateBtn = fieldWrapper.querySelector(".validate-btn");
        const cancelBtn = fieldWrapper.querySelector(".cancel-btn");

        let originalValue = input.value;

        function showButtons(editing) {
            editBtn.style.display = editing ? "none" : "inline-block";
            validateBtn.style.display = editing ? "inline-block" : "none";
            cancelBtn.style.display = editing ? "inline-block" : "none";
        }

        editBtn.addEventListener("click", () => {
            input.disabled = false;
            input.focus();
            showButtons(true);
        });

        cancelBtn.addEventListener("click", () => {
            input.value = originalValue;
            input.disabled = true;
            showButtons(false);
        });

        validateBtn.addEventListener("click", () => {
            input.disabled = true;
            originalValue = input.value;
            showButtons(false);
            hasChanged = true;
            if (submitBtn) submitBtn.style.display = "inline-block";
        });

        // Par défaut : champ désactivé et seuls boutons edit visibles
        input.disabled = true;
        showButtons(false);
    });
});
