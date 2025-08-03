import "./bootstrap";
import "../metronic/core/index";
import "../metronic/app/layouts/demo1";

window.defaultThemeMode = window.defaultThemeMode || "light"; // light|dark|system
let themeMode;

if (document.documentElement) {
    if (localStorage.getItem("theme")) {
        themeMode = localStorage.getItem("theme");
    } else if (document.documentElement.hasAttribute("data-theme-mode")) {
        themeMode = document.documentElement.getAttribute("data-theme-mode");
    } else {
        themeMode = window.defaultThemeMode;
    }

    if (themeMode === "system") {
        themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches
            ? "dark"
            : "light";
    }

    document.documentElement.classList.add(themeMode);
}
