document.addEventListener('DOMContentLoaded', function () {

    // -------------------------------------------------------
    // Références DOM
    // -------------------------------------------------------
    let tabTag = []  //Tableau des TAG qui sont utilisé en temps que filtre
                    //Il est MAJ a chaque ajout ou suppression
    let tabIng = [] //Idem pour les ingrédients

    let searchButton     = document.getElementById("btnSearch")
    let searchBar        = document.getElementById("searchBarInput")
    let buttonAddIng     = document.getElementById("AddIngredient")
    let buttonAddTag     = document.getElementById("AddTag")
    let filterDisplayTag = document.getElementById("filterDisplayTag")
    let filterDisplayIng = document.getElementById("filterDisplayIng")

    // Dropdown ingrédient
    let ingredientFilter = document.getElementById("ingredientFilter")
    let ingredientList   = document.getElementById("ingredientList")
    let selectedIng      = null

    // Dropdown tag
    let tagFilter  = document.getElementById("tagFilter")
    let tagList    = document.getElementById("tagList")
    let selectedTag = null

    // -------------------------------------------------------
    // Helpers génériques dropdown
    // -------------------------------------------------------
    function openDropdown(list) {
        list.classList.add("open")
    }

    function closeDropdown(list) {
        list.classList.remove("open")
    }

    // -------------------------------------------------------
    // Filtre des DropDown
    // -------------------------------------------------------
    
    function filterDropdown(input, list) {
        let query = input.value.trim().toLowerCase()
        let items = list.querySelectorAll("li")
        let hasVisible = false

        items.forEach(li => {
            let match = li.textContent.toLowerCase().includes(query)
            li.hidden = !match
            if (match) hasVisible = true
        })

        if (hasVisible) {
            openDropdown(list)
        } else {
            closeDropdown(list)
        }
    }



    function setupDropdown(input, list, onSelect) {
        let isFocused = false

        input.addEventListener("focus", () => { //Si l'input est focus
            isFocused = true
            filterDropdown(input, list)
        })

        input.addEventListener("input", () => { //lorsque l'on input on filtre les drop
            if (isFocused) filterDropdown(input, list)
        })

        input.addEventListener("blur", () => {  //Lorsqu'il perd le focus
            isFocused = false
            setTimeout(() => closeDropdown(list), 150)
        })

        list.addEventListener("mousedown", (e) => { 
            let li = e.target.closest("li")
            if (!li) return

            list.querySelectorAll("li.selected").forEach(el => el.classList.remove("selected"))
            li.classList.add("selected")

            input.value = li.dataset.value
            onSelect(li.dataset.value)
            isFocused = false
            closeDropdown(list)
        })
    }

    //Mise ne place des filtre ingredient et tag
    setupDropdown(ingredientFilter, ingredientList, (val) => { selectedIng = val })
    setupDropdown(tagFilter,        tagList,        (val) => { selectedTag = val })

    // -------------------------------------------------------
    // Gestion des filtres actifs
    // -------------------------------------------------------

    //Enleve un element du parent en fonction du text
    function removeChildByText(parent, text) {
        for (const child of parent.children) {
            if (child.innerText.trim() === text.trim()) {
                child.remove()
                break
            }
        }
    }

    //Supprime le tag avec le name
    function deleteTag(name) {
        let index = tabTag.indexOf(name)
        if (index > -1) tabTag.splice(index, 1)
        removeChildByText(filterDisplayTag, name)
    }

    //Meme idée mais avec les ingredients
    function deleteIng(name) {
        let index = tabIng.indexOf(name)
        if (index > -1) tabIng.splice(index, 1)
        removeChildByText(filterDisplayIng, name)
    }

    //Ajoute les buttons de tag et ing dans la filtre de recherche
    function addChip(container, name, onDelete) {
        let chip = document.createElement("BUTTON")
        chip.innerText = name
        chip.onclick = () => onDelete(chip.innerText) //Lorsque l'on click dessus on le détruit
        chip.classList.add("tagButton")
        container.appendChild(chip)
    }

    buttonAddIng.addEventListener("click", function () { //Ajout d'ingredient au filtre
        if (selectedIng && !tabIng.includes(selectedIng)) {
            tabIng.push(selectedIng)
            addChip(filterDisplayIng, selectedIng, deleteIng)
        }
    })

    buttonAddTag.addEventListener("click", function () {    //Ajout de tag au filtre
        if (selectedTag && !tabTag.includes(selectedTag)) {
            tabTag.push(selectedTag)
            addChip(filterDisplayTag, selectedTag, deleteTag)
        }
    })

    // -------------------------------------------------------
    // Recherche
    // -------------------------------------------------------
    function searchRecettes() {
        let searchValue = searchBar.value.trim()
        let url = "../Back/index.php"
        let params = []

        //-----------Recupération des parametres----------------
        if (searchValue !== "") {
            params.push("search=" + encodeURIComponent(searchValue)) 
        }

        params.push("ingredients=" + encodeURIComponent(tabIng.join(",")))
        params.push("tags="        + encodeURIComponent(tabTag.join(",")))

        //-----------Fetch----------------
        fetch(url + "?" + params.join("&"), { method: 'GET' })
            .then(response => {
                if (response.ok) {
                    console.log("Recherche ok")
                }
            })
            .catch(error => {
                console.error("Erreur avec le fetch :", error)
            })
    }

    searchButton.addEventListener("click", searchRecettes) 
    searchBar.addEventListener("keydown", (e) => {
        if (e.key === "Enter") searchRecettes()
    })
})