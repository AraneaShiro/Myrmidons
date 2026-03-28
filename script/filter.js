document.addEventListener('DOMContentLoaded', function () {
    // Ensemble des fonctions liées à la recherche de filtre

    // Get des éléments
    let tabTag = []
    let tabIng = []
    let searchButton = document.getElementById("btnSearch")
    let searchBar = document.getElementById("searchBarInput")
    console.log(searchBar)
    let tagSelection = document.getElementById("tagSelection")
    let IngSelection = document.getElementById("ingredientSelector")
    let buttonAddIng = document.getElementById("AddIngredient")
    let buttonAddTag = document.getElementById("AddTag")
    let filterDisplayTag = document.getElementById("filterDisplayTag")
    let filterDisplayIng = document.getElementById("filterDisplayIng")

    function removeChildByText(parent, text) {
        for (const child of parent.children) {
            if (child.innerText.trim() === text.trim()) {
                child.remove()
                break // retire uniquement le premier trouvé
            }
        }
    }

    function deleteTag(name) { // supprime l'élément de la liste et du display
        let index = tabTag.indexOf(name)
        if (index > -1) { // Découpe si trouve
            tabTag.splice(index, 1) // ✅ BUGFIX 1 : "array" remplacé par "tabTag"
        }
        removeChildByText(filterDisplayTag, name)
    }

    function deleteIng(name) { // supprime l'élément de la liste et du display
        let index = tabIng.indexOf(name)
        if (index > -1) { // Découpe si trouve
            tabIng.splice(index, 1) // ✅ BUGFIX 1 : "array" remplacé par "tabIng"
        }
        removeChildByText(filterDisplayIng, name)
    }

    // Ajoute un ingrédient
    buttonAddIng.addEventListener("click", function (event) {
        let content = IngSelection.value
        if (content != "" && !tabIng.includes(content)) {
            tabIng.push(content)
            let butNewTag = document.createElement("BUTTON")
            butNewTag.innerText = content
            butNewTag.onclick = () => deleteIng(butNewTag.innerText) // ✅ BUGFIX 2 : arrow function
            butNewTag.classList.add("tagButton")
            filterDisplayIng.appendChild(butNewTag)
        }
    })

    // Ajoute un tag
    buttonAddTag.addEventListener("click", function (event) {
        let content = tagSelection.value
        if (content != "" && !tabTag.includes(content)) {
            tabTag.push(content)
            let butNew = document.createElement("BUTTON")
            butNew.innerText = content
            butNew.onclick = () => deleteTag(butNew.innerText) // ✅ BUGFIX 2 : arrow function
            butNew.classList.add("tagButton")
            filterDisplayTag.appendChild(butNew)
        }
    })

  function searchRecettes() {
    // On récupère la valeur de la barre de recherche
    let searchValue = searchBar.value.trim();

    // URL de la recherche (relative à ton site)
    let url = "/Back/index.php";

    // Construction des paramètres
    let params = [];

    if (searchValue !== "") {
        params.push("search=" + encodeURIComponent(searchValue));
    }

    // Ingrédients et tags
    tabIng.forEach(ing => params.push("ingredients[]=" + encodeURIComponent(ing)));
    tabTag.forEach(tag => params.push("tags[]=" + encodeURIComponent(tag)));

    // On concatène tous les paramètres
    let request = url + "?" + params.join("&");

    // Options pour fetch
    let options = {
        method: 'GET'
    };

    // Exécution de la requête
    fetch(request, options)
        .then(response => {
            if (response.ok) {
                return console.log(response.text()); // ou .json() si backend renvoie JSON
            } else {
                throw new Error(response.statusText);
            }
        })
        .then(data => {
            console.log("Résultat de la recherche :", data);
            // Ici tu peux mettre à jour le DOM avec les résultats
        })
        .catch(error => {
            console.error("Erreur avec le fetch :", error);
        });
}

    // Déclenchement sur le bouton recherche
    searchButton.addEventListener("click", searchRecettes)

    // Déclenchement aussi en appuyant sur Entrée dans la barre
    searchBar.addEventListener("keydown", (e) => {
        if (e.key === "Enter") searchRecettes()
    })
})