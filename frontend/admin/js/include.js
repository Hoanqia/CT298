function includeHTML() {
    document.querySelectorAll("[data-include]").forEach(el => {
        let file = el.getAttribute("data-include");
        fetch("includes/" + file)
            .then(response => response.text())
            .then(data => el.innerHTML = data)
            .catch(error => console.error("Error loading " + file, error));
    });
}
document.addEventListener("DOMContentLoaded", includeHTML);
