document.addEventListener('DOMContentLoaded', function () {

    // ── display ────────────────────────────────────────
    let display=document.getElementById("FormRecette")
    let showing=false

    // ── Éléments Tag Admin ────────────────────────────────────────
    let button_deleteTag    = document.getElementById("DeleteTag")
    let button_addNewTag    = document.getElementById("AddNewTag")
    let input_NewTag        = document.getElementById("NewTagInput")
    // Dropdown custom suppression tag
    let tagDeleteFilter     = document.getElementById("tagDeleteFilter")
    let tagDeleteList       = document.getElementById("tagDeleteList")
    let selectedDeleteTag   = null

    // ── Éléments Ingrédient Admin ─────────────────────────────────
    let input_NewIng      = document.getElementById("NewIngIput")
    let fileInput_NewIng  = document.getElementById("imgInputIng")
    let button_AddNewIng  = document.getElementById("AddNewIng")
    let button_DeleteIng  = document.getElementById("DeleteIng")
    let select_DeleteIng  = document.getElementById("ingDeleteSelection")

    // ── Éléments Formulaire Recette ───────────────────────────────
    let AddRecetteButton     = document.getElementById('AddRecetteForm')
    let inputTitle     = document.getElementById('inputTitle')
    let imgFileInput   = document.getElementById('imgFileInput')
    let imagePreview   = document.getElementById('imagePreview')
    let imgPlaceholder = document.getElementById('imgPlaceholder')
    let tagInput        = document.getElementById('tagInput')       // input du dropdown custom
    let tagInputList    = document.getElementById('tagInputList')   // ul du dropdown custom
    let selectedRecTag  = null
    let btnAddTag       = document.getElementById('btnAddTag')
    let tagsRow         = document.getElementById('tagsRow')
    let ingGrid         = document.getElementById('ingGrid')
    let ingSelect       = document.getElementById('ingSelect')      // input du dropdown custom
    let ingSelectList   = document.getElementById('ingSelectList')  // ul du dropdown custom
    let selectedRecIng  = null
    let btnAddIng       = document.getElementById('btnAddIng')
    let inputDesc      = document.getElementById('inputDesc')
    let btnSubmit      = document.getElementById('btnSubmit')
    let id              =document.getElementById("IdContainer")

    let tabTags  = []   // noms des tags ajoutés à la recette MAJ a chaque ajout ou suppression
    let tabIngs  = []   // noms des ingrédients ajoutés à la recette idem

    let URL="../Back/index.php" 

    // ══════════════════════════════════════════════════════════════
    //  DROPDOWN CUSTOM – SUPPRESSION TAG
    // ══════════════════════════════════════════════════════════════

    if (tagDeleteFilter && tagDeleteList) { //Si il existe
        let isFocused = false   //On ne l'est affichera pas au départ

        tagDeleteFilter.addEventListener("focus", () => {
            isFocused = true    //Il s'affiche
            filterTagDeleteDropdown()   //on filtre
        })
        tagDeleteFilter.addEventListener("input", () => { //A chaque changement on MAJ le filtre
            if (isFocused) filterTagDeleteDropdown()
        })
        tagDeleteFilter.addEventListener("blur", () => {
            isFocused = false
            setTimeout(() => tagDeleteList.classList.remove("open"), 150)
        })
        tagDeleteList.addEventListener("mousedown", (e) => {    //Lorsque l'on click
            let li = e.target.closest("li")         //la cicle devient le li de l'option du dropdown
            if (!li) return
            tagDeleteList.querySelectorAll("li.selected").forEach(el => el.classList.remove("selected"))    //On supprime les autres 
            li.classList.add("selected")    
            tagDeleteFilter.value = li.dataset.value
            selectedDeleteTag = li.dataset.value
            isFocused = false
            tagDeleteList.classList.remove("open")
        })

        function filterTagDeleteDropdown() {    //filtre donc meme idee
            let query = tagDeleteFilter.value.trim().toLowerCase()
            let items = tagDeleteList.querySelectorAll("li")
            let hasVisible = false
            items.forEach(li => {
                let match = li.textContent.toLowerCase().includes(query)
                li.hidden = !match
                if (match) hasVisible = true
            })
            tagDeleteList.classList.toggle("open", hasVisible)
        }
    }
    // ── command test ───────────────────────────────
    //console.log(button_deleteTag)



    // ══════════════════════════════════════════════════════════════
    //  HELPER
    // ══════════════════════════════════════════════════════════════

    function showError(id, visible, msg = null) {
        let el = document.getElementById(id)
        if (!el) return
        el.classList.toggle('visible', visible)
        if (msg) el.textContent = msg
    }

   function resetForm() {
    // Inputs
    inputTitle.value = ""
    inputDesc.value = ""
    id.innerText = ""

    // Image (FIX COMPLET)
    imgFileInput.value = ""

    // Supprime image <img>
    imagePreview.innerHTML = ""

    // Supprime background (mode édition)
    imagePreview.style.backgroundImage = ""
    imagePreview.style.backgroundSize = ""
    imagePreview.style.backgroundPosition = ""

    // Réaffiche le placeholder
    imgPlaceholder.style.display = "block"

    // Tags
    tabTags = []
    renderTags()
    tagInput.value = ""
    selectedRecTag = null

    // Ingrédients
    tabIngs = []
    ingGrid.innerHTML = ""
    ingSelect.value = ""
    selectedRecIng = null

    // Reset erreurs
    document.querySelectorAll('.invalid').forEach(el => el.classList.remove('invalid'))
    document.querySelectorAll('.visible').forEach(el => el.classList.remove('visible'))
}

    // ══════════════════════════════════════════════════════════════
    //  DROPDOWN CUSTOM – TAGS RECETTE
    // ══════════════════════════════════════════════════════════════

    //Fonction pour la mise en place des dropdown de la recette
    function setupRecipeDropdown(input, list, onSelect) {
        let isFocused = false

        input.addEventListener("focus", () => {
            isFocused = true
            filterList()
        })
        input.addEventListener("input", () => {
            if (isFocused) filterList()
        })
        input.addEventListener("blur", () => {
            isFocused = false
            setTimeout(() => list.classList.remove("open"), 150)
        })
        list.addEventListener("mousedown", (e) => {
            let li = e.target.closest("li")
            if (!li) return
            list.querySelectorAll("li.selected").forEach(el => el.classList.remove("selected"))
            li.classList.add("selected")
            input.value = li.textContent.trim()
            onSelect(li.dataset.value, li.textContent.trim())
            isFocused = false
            list.classList.remove("open")
        })

        function filterList() {
            let query = input.value.trim().toLowerCase()
            let items = list.querySelectorAll("li")
            let hasVisible = false
            items.forEach(li => {
                let match = li.textContent.toLowerCase().includes(query)
                li.hidden = !match
                if (match) hasVisible = true
            })
            list.classList.toggle("open", hasVisible)
        }
    }

    setupRecipeDropdown(tagInput, tagInputList, (val, label) => { selectedRecTag = { val, label } })
    setupRecipeDropdown(ingSelect, ingSelectList, (val, label) => { selectedRecIng = { val, label } })
    // ══════════════════════════════════════════════════════════════

    /** Vérifie qu'un tag est sélectionné dans le select de suppression */
    function validateDeleteTag() {
        if (!selectedDeleteTag || selectedDeleteTag.trim() === "") {
            alert("Veuillez sélectionner un tag à supprimer.")
            return false
        }
        return true
    }

    /** Vérifie qu'un ingrédient est sélectionné dans le select de suppression */
    function validateDeleteIng() {
        if (!select_DeleteIng.value || select_DeleteIng.value.trim() === "") {
            alert("Veuillez sélectionner un ingrédient à supprimer.")
            return false
        }
        return true
    }

    /** Vérifie que l'input "Nouveau tag" n'est pas vide */
    function validateNewTag() {
        let value = input_NewTag.value.trim()
        if (value === "") {
            alert("Veuillez entrer un nom de tag.")
            return false
        }
        if (value.length < 2) {
            alert("Le nom du tag doit contenir au moins 2 caractères.")
            return false
        }
        return true
    }

    /** Vérifie que l'input "Nouvel ingrédient" n'est pas vide */
    function validateNewIng() {
        let value = input_NewIng.value.trim()
        if (value === "") {
            alert("Veuillez entrer un nom d'ingrédient.")
            return false
        }
        if (value.length < 2) {
            alert("Le nom de l'ingrédient doit contenir au moins 2 caractères.")
            return false
        }
        return true
    }

    /** Vérifie que le fichier est une image valide */
    function validateImageInput(inputFile) {
        if (!inputFile.files || inputFile.files.length === 0) {
            alert("Veuillez sélectionner un fichier.")
            return false
        }
        let file = inputFile.files[0]
        let allowedTypes = ["image/jpeg", "image/png", "image/gif", "image/webp", "image/svg+xml"]
        if (!allowedTypes.includes(file.type)) {
            alert("Le fichier doit être une image (JPEG, PNG, GIF, WEBP, SVG).")
            return false
        }
        return true
    }

    // ══════════════════════════════════════════════════════════════
    //  VALIDATIONS – FORMULAIRE RECETTE
    // ══════════════════════════════════════════════════════════════

    function validateTitle() {
        let ok = inputTitle.value.trim().length >= 2
        inputTitle.classList.toggle('invalid', !ok)
        showError('errTitle', !ok, 'Le nom de la recette est requis (min 2 caractères).')
        return ok
    }

    function validateImage() {
    let allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml']

    // MODE MODIFICATION (ID présent)
    if (id.innerText.trim() !== "") {
        // Si aucune nouvelle image → OK
        if (imgFileInput.files.length === 0) {
            imagePreview.classList.remove('invalid')
            showError('errImg', false)
            return true
        }
    }
    
    // MODE NORMAL (ou si nouvelle image ajoutée)
    let ok = imgFileInput.files.length > 0 && allowedTypes.includes(imgFileInput.files[0].type)

    imagePreview.classList.toggle('invalid', !ok)
    showError('errImg', !ok, 'Veuillez sélectionner une image valide.')

    return ok
}

    /** Vérifie qu'un tag est sélectionné dans le dropdown */
    function validateTagSelect() {
        let ok = selectedRecTag !== null
        tagInput.classList.toggle('invalid', !ok)
        showError('errTag', !ok, 'Veuillez sélectionner un tag.')
        return ok
    }

    /** Vérifie qu'un ingrédient est sélectionné dans le dropdown */
    function validateIngSelect() {
        let ok = selectedRecIng !== null
        ingSelect.classList.toggle('invalid', !ok)
        showError('errIng', !ok, 'Veuillez sélectionner un ingrédient.')
        return ok
    }

    /** Vérifie qu'au moins un ingrédient a été ajouté à la liste */
    function validateIngredients() {
        let items = ingGrid.querySelectorAll('.ing-item')
        if (items.length === 0) {
            showError('errIng', true, 'Ajoutez au moins un ingrédient.')
            return false
        }
        showError('errIng', false)
        return true
    }

    /** Verifie que la description a au moins 10 char */
    function validateDescription() {
        let ok = inputDesc.value.trim().length >= 10
        document.getElementById('descSection').classList.toggle('invalid', !ok)
        showError('errDesc', !ok, 'La description doit contenir au moins 10 caractères.')
        return ok
    }

    // ══════════════════════════════════════════════════════════════
    //  LOGIQUE – IMAGE PRINCIPALE
    // ══════════════════════════════════════════════════════════════

    imgFileInput.addEventListener('change', function () {
        let file = this.files[0]
        if (file && file.type.startsWith('image/')) {   //Si c'est bien une image
            let reader = new FileReader()
            reader.onload = e => {  //On affiche
                imgPlaceholder.style.display = 'none'
                let img = imagePreview.querySelector('img')
                if (!img) {
                    img = document.createElement('img')
                    imagePreview.appendChild(img)
                }
                img.src = e.target.result
            }
            reader.readAsDataURL(file)
            imagePreview.classList.remove('invalid')
            showError('errImg', false)
        }
    })

    // ══════════════════════════════════════════════════════════════
    //  LOGIQUE – TAGS RECETTE 
    // ══════════════════════════════════════════════════════════════

    btnAddTag.addEventListener('click', function () {   //Ajout d'un tag dans la nouvelle recette/Alter
        if (!validateTagSelect()) return
        let name = selectedRecTag.label
        if (tabTags.includes(name)) {
            showError('errTag', true, 'Ce tag est déjà ajouté.')
            return
        }
        tabTags.push(name)
        renderTags()
        tagInput.value = ''
        selectedRecTag = null
        showError('errTag', false)
    })

    function renderTags() { //Affichage des tags lors de l'ajout
        tagsRow.innerHTML = ''
        //Si c est vide
        if (tabTags.length === 0) {
            tagsRow.innerHTML = '<span style="opacity:0.45;font-size:0.85rem;">Aucun tag ajouté</span>'
            return
        }
        //Pour chaque tag on cree un element clickable qui le detruit
        tabTags.forEach(tag => {
            let chip = document.createElement('div')
            chip.className = 'tag-chip'
            chip.innerHTML = `<span>${tag}</span><button title="Supprimer">×</button>`
            chip.querySelector('button').onclick = () => {
                tabTags = tabTags.filter(t => t !== tag)
                renderTags()
            }
            tagsRow.appendChild(chip)
        })
    }

    // ══════════════════════════════════════════════════════════════
    //  LOGIQUE – INGRÉDIENTS RECETTE 
    // ══════════════════════════════════════════════════════════════

    //Ajout d'un ingredient au formulaire de recette
    btnAddIng.addEventListener('click', function () {
        if (!validateIngSelect()) return
        let name = selectedRecIng.label
        if (tabIngs.includes(name)) {
            showError('errIng', true, 'Cet ingrédient est déjà ajouté.')
            return
        }
        tabIngs.push(name)

        let item = document.createElement('div')
        item.className = 'ing-item'
        item.innerHTML = `
            <span>${name}</span>
            <button title="Supprimer">×</button>
        `
        item.querySelector('button').onclick = () => {
            tabIngs = tabIngs.filter(i => i !== name)
            item.remove()
            showError('errIng', false)
        }
        ingGrid.appendChild(item)

        ingSelect.value = ''
        selectedRecIng = null
        showError('errIng', false)
    })

    // ══════════════════════════════════════════════════════════════
    //  LOGIQUE – SUBMIT RECETTE
    // ══════════════════════════════════════════════════════════════

    btnSubmit.addEventListener('click', function () {
        //Les validations
        let v1 = validateTitle()
        let v2 = validateImage()
        let v3 = validateIngredients()
        let v4 = validateDescription()

        if (v1 && v2 && v3 && v4) {
         
            //Le stockage des datas
            let data= new FormData()
            data.append("newTitle",inputTitle.value)
            data.append("newTags",tabTags)
            data.append("newDesc", inputDesc.value)
            data.append("newIngredients",tabIngs)
            data.append("newId",id.innerText)

            if (imgFileInput.files[0]) {
                data.append("imgFileInput", imgFileInput.files[0])
            }

            let options ={
                method :'POST',
                body : data
            }

            fetch(URL,options).then(response =>{
            if (response.ok) {
                // 
                    id.innerText=''
                    console.log("new Recette Added")
                    resetForm()
                
            } else {
                alert("ERREUR avec la requête.", response.statusText);
            }
        }).catch(error => {
            console.log("ERREUR avec le fetch new Recette.", error)
        })

            
        }

    })

    // ══════════════════════════════════════════════════════════════
    //  LOGIQUE – BOUTONS ADMIN
    // ══════════════════════════════════════════════════════════════

    //Si le bouton de deletion existe (j ai eu des problemes lorsque l'on est pas logIn)
    if(button_deleteTag !=null){
        button_deleteTag.addEventListener("click", function () {    //On envoie une post pour delete le tag selectionné
        if (!validateDeleteTag()) return
        console.log("DeleteTag:", selectedDeleteTag)

            let data= new FormData()
            data.append("DeletedTags", selectedDeleteTag)

            let options ={
                method :'POST',
                body : data
            }

            fetch(URL,options).then(response =>{
            if (response.ok) {
                    // Retire le li du dropdown
                    tagDeleteList.querySelectorAll("li").forEach(li => {
                        if (li.dataset.value === selectedDeleteTag) li.remove()
                    })
                    tagDeleteFilter.value = ""
                    selectedDeleteTag = null
                    console.log("Tag deleted")
                
            } else {
                alert("ERREUR avec la requête.", response.statusText);
            }
        }).catch(error => {
            console.log("ERREUR avec le fetch DeleteTag.", error)
        })
    })
    }
    

    button_addNewTag.addEventListener("click", function () { //Button de creation d'un new TAG
        if (!validateNewTag()) return
        console.log("addTag:", input_NewTag.value.trim())
        

            let data= new FormData()
            
            data.append("newTags",input_NewTag.value)
   
            let options ={
                method :'POST',
                body : data
            }

            fetch(URL,options).then(response =>{
            if (response.ok) {
                
                    console.log("Tag Created")
                
            } else {
                alert("ERREUR avec la requête.", response.statusText);
            }
        }).catch(error => {
            console.log("ERREUR avec le fetch new Recette.", error)
        })
    })


    button_AddNewIng.addEventListener("click", function () {    //Ajout d'un nouvelle ingredient
        if (!validateNewIng()) return
        if (!validateImageInput(fileInput_NewIng)) return
        console.log("AddIng:", input_NewIng.value.trim())
   

            let data= new FormData()
            
            data.append("NewIng", input_NewIng.value)
            data.append("imgInputIng", fileInput_NewIng.files[0]) 
   
            let options ={
                method :'POST',
                body : data
            }

            fetch(URL,options).then(response =>{
            if (response.ok) {
                
            
                    console.log("Ingredient cree")
                
            } else {
                alert("ERREUR avec la requête.", response.statusText);
            }
        }).catch(error => {
            console.log("ERREUR avec le fetch new Recette.", error)
        })
    })



AddRecetteButton.addEventListener("click", function () {    //Ajout d'une recette/modification si un ID est present
    if(showing){
            display.style.display="none"
        AddRecetteButton.innerText="Ajouter une recette"
        showing=false
        
    }else{
        display.style.display="block"
        AddRecetteButton.innerText="Cache le formulaire"
        showing=true
    }
    
})

  //Pour chaque button modifier
  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('ModifRecette')) {

        const card = e.target.closest('.card');

        //  Récupération des données
        const titre = card.querySelector('.card__title h2').textContent;
        const image = card.querySelector('.card__image img').src;
        const description = card.querySelector('.card__desc p').textContent;
        let IDRecette = card.querySelector('.IdRecette').textContent;
        
        const tags=[];
    
        
        card.querySelectorAll(".tags-row p").forEach(tag => {
            tags.push(tag.textContent.trim());
        });
console.log(tags)
        let ingredients = [];
        card.querySelectorAll('.card__list ul li').forEach(li => {
            ingredients.push(li.textContent.trim());
        });

        // =========================
        //  REMPLISSAGE DU FORMULAIRE
        // =========================

        // Titre
        document.getElementById('inputTitle').value = titre;

        // ID
        console.log(document.getElementById('IdContainer'))
        document.getElementById('IdContainer').innerText = IDRecette;

        // Description
        document.getElementById('inputDesc').value = description;

        // Image (preview)
        let preview = document.getElementById('imagePreview');
        preview.style.backgroundImage = `url(${image})`;
        preview.style.backgroundSize = 'cover';
        preview.style.backgroundPosition = 'center';

        // Cache le placeholder
        document.getElementById('imgPlaceholder').style.display = 'none';

        // Tags — réinitialisation et rendu AVANT le forEach ingrédients
        tabTags = []
        tags.forEach(tag => tabTags.push(tag))
        renderTags()

        // Ingrédients
        const ingGrid = document.getElementById('ingGrid');
        ingGrid.innerHTML = '';
        tabIngs = [] // reset avant de remplir
        ingredients.forEach(ing => {
            let name = ing
            if (tabIngs.includes(name)) return

            tabIngs.push(name)

            let item = document.createElement('div')
            item.className = 'ing-item'
            item.innerHTML = `
                <span>${name}</span>
                <button title="Supprimer">×</button>
            `
            item.querySelector('button').onclick = () => {
                tabIngs = tabIngs.filter(i => i !== name)
                item.remove()
                showError('errIng', false)
            }
            ingGrid.appendChild(item)
        })

        ingSelect.value = ''
        selectedRecIng = null
        showError('errIng', false)

        // =========================
        //  UI
        // =========================

        // Cache la carte
        card.style.display = 'none';

        // Affiche le formulaire (si caché)
        document.getElementById('FormRecette').style.display = 'block';
        showing=true;
        AddRecetteButton.innerText="Cache le formulaire"
    }
});

        // =========================
        //  Delete button de chaque recette
        // =========================

    document.querySelectorAll('.card .DeleteRecette').forEach(button => {
        button.addEventListener('click', function() {

            // remonte à la carte parente
            const card = this.closest('.card');

            // On recupere l ID de la recette
            const ID = card.querySelector('h6').textContent;

   

            let data= new FormData()
            data.append("DeletedId",ID)

            let options ={
                method :'POST',
                body : data
            }

            fetch(URL,options).then(response =>{
            if (response.ok) {
                
                    card.remove();
                    console.log("Recette deleted")

            } else {
                alert("ERREUR avec la requête.", response.statusText);
            }
        }).catch(error => {
            console.log("ERREUR avec le fetch new Recette.", error)
        })

        });
    });





})