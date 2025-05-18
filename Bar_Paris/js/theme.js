document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("toggle-theme");
    const themeLink = document.getElementById("theme-css");

    if (!toggleBtn || !themeLink) {
        console.warn("Thème : éléments introuvables.");
        return;
    }

    const lightTheme = "style.css";
    const darkTheme = "dark.css";

    // Détection du chemin de base : à adapter selon la page
    let basePath = themeLink.getAttribute("href").replace(/(style|dark)\.css$/, "");

    const savedTheme = localStorage.getItem("theme") || darkTheme;
    themeLink.href = `${basePath}${savedTheme}`;

    toggleBtn.addEventListener("click", function () {
        const currentTheme = themeLink.href.includes(darkTheme) ? darkTheme : lightTheme;
        const newTheme = currentTheme === darkTheme ? lightTheme : darkTheme;
        themeLink.href = `${basePath}${newTheme}`;
        localStorage.setItem("theme", newTheme);
    });
});
