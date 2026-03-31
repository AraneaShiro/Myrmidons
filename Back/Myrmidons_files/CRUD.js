document.addEventListener('DOMContentLoaded', function () {

    // ── display ────────────────────────────────────────
    let display=document.getElementById("FormRecette")
    let showing=false

    // ── Éléments Tag Admin ────────────────────────────────────────
    let button_deleteTag  = document.getElementById("DeleteTag")
    let button_addNewTag  = document.getElementById("AddNewTag")
    let select_DeleteTag  = document.getElementById("tagDeleteSelection")
    let input_NewTag      = document.getElementById("NewTagInput")

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
    let tagInput       = document.getElementById('tagInput')      // <select> peuplé par PHP
    let btnAddTag      = document.getElementById('btnAddTag')
    let tagsRow        = document.getElementById('tagsRow')
    let ingGrid        = document.getElementById('ingGrid')
    let ingSelect      = document.getElementById('ingSelect')     // <select> peuplé par PHP
    let btnAddIng      = document.getElementById('btnAddIng')
    let inputDesc      = document.getElementById('inputDesc')
    let btnSubmit      = document.getElementById('btnSubmit')
    let id              =document.getElementById("IdContainer")

    let tabTags  = []   // noms des tags ajoutés à la recette
    let tabIngs  = []   // noms des ingrédients ajoutés à la recette

    let URL="../Back/index.php"
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

    // ══════════════════════════════════════════════════════════════
    //  VALIDATIONS – ADMIN
    // ══════════════════════════════════════════════════════════════

    /** Vérifie qu'un tag est sélectionné dans le select de suppression */
    function validateDeleteTag() {
        if (!select_DeleteTag.value || select_DeleteTag.value.trim() === "") {
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
        let ok = imgFileInput.files.length > 0 && allowedTypes.includes(imgFileInput.files[0].type)
        imagePreview.classList.toggle('invalid', !ok)
        showError('errImg', !ok, 'Veuillez sélectionner une image valide.')
        return ok
    }

    /** Vérifie que le select de tag a bien une valeur choisie */
    function validateTagSelect() {
        let ok = tagInput.value !== "" && tagInput.value !== null
        tagInput.classList.toggle('invalid', !ok)
        showError('errTag', !ok, 'Veuillez sélectionner un tag.')
        return ok
    }

    /** Vérifie que le select d'ingrédient a bien une valeur choisie */
    function validateIngSelect() {
        let ok = ingSelect.value !== "" && ingSelect.value !== null
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
        if (file && file.type.startsWith('image/')) {
            let reader = new FileReader()
            reader.onload = e => {
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
    //  LOGIQUE – TAGS RECETTE (depuis le select PHP)
    // ══════════════════════════════════════════════════════════════

    btnAddTag.addEventListener('click', function () {
        if (!validateTagSelect()) return
        let name = tagInput.value.trim()
        if (tabTags.includes(name)) {
            showError('errTag', true, 'Ce tag est déjà ajouté.')
            return
        }
        tabTags.push(name)
        renderTags()
        tagInput.value = ''           // remet le select sur l'option vide
        showError('errTag', false)
    })

    function renderTags() {
        tagsRow.innerHTML = ''
        if (tabTags.length === 0) {
            tagsRow.innerHTML = '<span style="opacity:0.45;font-size:0.85rem;">Aucun tag ajouté</span>'
            return
        }
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
    //  LOGIQUE – INGRÉDIENTS RECETTE (depuis le select PHP)
    // ══════════════════════════════════════════════════════════════

    btnAddIng.addEventListener('click', function () {
        if (!validateIngSelect()) return
        let name = ingSelect.value.trim()
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

        ingSelect.value = ''          // remet le select sur l'option vide
        showError('errIng', false)
    })

    // ══════════════════════════════════════════════════════════════
    //  LOGIQUE – SUBMIT RECETTE
    // ══════════════════════════════════════════════════════════════

    btnSubmit.addEventListener('click', function () {
        let v1 = validateTitle()
        let v2 = validateImage()
        let v3 = validateIngredients()
        let v4 = validateDescription()

        if (v1 && v2 && v3 && v4) {
         

            let data= new FormData()
            data.append("newTitle",inputTitle)
            data.append("newTags",tabTags)
            data.append("newIngredients",tabIngs)
            data.append("newId",id.innerText)

            let options ={
                method :'POST',
                body : data
            }

            fetch(URL,options).then(response =>{
            if (response.ok) {
                response.json().then(data => { // json() parse les données
                    id.innerText=''
                    console.log("new Recette Added")
                })
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

    if(button_deleteTag !=null){
        button_deleteTag.addEventListener("click", function () {
        if (!validateDeleteTag()) return
        console.log("DeleteTag id:", select_DeleteTag.value)
   

            let data= new FormData()
            
            data.append("DeletedTags",select_DeleteTag.value)
   
            let options ={
                method :'POST',
                body : data
            }

            fetch(URL,options).then(response =>{
            if (response.ok) {
                response.json().then(data => { // json() parse les données
                    console.log("Tag deleted")
                })
            } else {
                alert("ERREUR avec la requête.", response.statusText);
            }
        }).catch(error => {
            console.log("ERREUR avec le fetch new Recette.", error)
        })
    })
    }
    

    button_addNewTag.addEventListener("click", function () {
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
                response.json().then(data => { // json() parse les donnée
                    console.log("Tag Created")
                })
            } else {
                alert("ERREUR avec la requête.", response.statusText);
            }
        }).catch(error => {
            console.log("ERREUR avec le fetch new Recette.", error)
        })
    })

    if(button_DeleteIng !=null){
        button_DeleteIng.addEventListener("click", function () {
            if (!validateDeleteIng()) return
            console.log("DeleteIng id:", select_DeleteIng.value)
            

                let data= new FormData()
                
                data.append("DeletedIng",select_DeleteIng.value)

                let options ={
                    method :'POST',
                    body : data
                }

                fetch(URL,options).then(response =>{
                if (response.ok) {
                    response.json().then(data => { // json() parse les données
                        console.log("Ingredient deleted")
                    })
                } else {
                    alert("ERREUR avec la requête.", response.statusText);
                }
            }).catch(error => {
                console.log("ERREUR avec le fetch new Recette.", error)
            })
        })
    }

    button_AddNewIng.addEventListener("click", function () {
        if (!validateNewIng()) return
        if (!validateImageInput(fileInput_NewIng)) return
        console.log("AddIng:", input_NewIng.value.trim())
   

            let data= new FormData()
            
            data.append("NewIng",fileInput_NewIng.value)
   
            let options ={
                method :'POST',
                body : data
            }

            fetch(URL,options).then(response =>{
            if (response.ok) {
                response.json().then(data => { // json() parse les données
            
                    console.log("Ingredient cree")
                })
            } else {
                alert("ERREUR avec la requête.", response.statusText);
            }
        }).catch(error => {
            console.log("ERREUR avec le fetch new Recette.", error)
        })
    })



AddRecetteButton.addEventListener("click", function () {
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
        console.log(IDRecette)
        const tags=[];
    

        card.querySelectorAll(".tags-row .tag").forEach(tag => {
            tags.push(tag.textContent.trim());
        });

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

        // Ingrédients
        const ingGrid = document.getElementById('ingGrid');
        ingGrid.innerHTML = ''; // reset)
        ingredients.forEach(ing => {
            let name = ing
        if (tabIngs.includes(name)) {
            showError('errIng', true, 'Cet ingrédient est déjà ajouté.')
            return
        }
        tabIngs.push(name)

       
        // Tags
        const tagRow = document.getElementById("tagsRow");
        tagRow.innerHTML = '';
        tabTags = []; // réinitialise tabTags pour éviter doublons
        tags.forEach(tag => {
            tabTags.push(tag);
        });
        renderTags(); // <-- appelé une seule fois
        
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

        ingSelect.value = ''          // remet le select sur l'option vide
        showError('errIng', false)
        });

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
