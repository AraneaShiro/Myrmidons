

document.addEventListener('DOMContentLoaded', function (){

    //Ensemble des fonctions lié a la recherche de filtre

//Get des éléments
let tabTag=[]
let tabIng=[]
let searchButton = document.getElementById("btnSearch")
let searchBar= document.getElementById("searchBar")
let tagSelection= document.getElementById("tagSelection")
let IngSelection=document.getElementById("ingredientSelector")
let buttonAddIng=document.getElementById("AddIngredient")
let buttonAddTag=document.getElementById("AddTag")
let filterDisplayTag=document.getElementById("filterDisplayTag")
let filterDisplayIng=document.getElementById("filterDisplayIng")


function removeChildByText(parent, text) {
  for (const child of parent.children) {
    if (child.innerText.trim() === text.trim()) {
      child.remove()
      break // retire uniquement le premier trouvé
    }
  }
}


function deleteTag(name){ //supprime l'élément de la liste et du display
    let index= tabTag.indexOf(name)
    if (index > -1) { //Découpe si trouve
            array.splice(index, 1); // on ne supprime qu'un objet
    }
    removeChildByText(filterDisplayTag,name);
    }



function deleteIng(name){ //supprime l'élément de la liste et du display
    let index= tabIng.indexOf(name)
    if (index > -1) { //Découpe si trouve
            array.splice(index, 1); // on ne supprime qu'un objet
    }
    removeChildByText(filterDisplayIng,name);
    }



//Ajoute
buttonAddIng.addEventListener("click", function(event){

    let content= IngSelection.value
    if(content!=""){
        tabIng.push(content)
        let butNewTag=document.createElement("BUTTON")
        butNewTag.innerText=content
        butNewTag.onclick =deleteIng(butNewTag.innerText)
        butNewTag.classList.add("tagButton")
        filterDisplayIng.appendChild(butNewTag)
    }
})

buttonAddTag.addEventListener("click", function(event){

    let content= tagSelection.value
    if(content!=""){
        tabTag.push(content)
        let butNew=document.createElement("BUTTON")
        butNew.innerText=content
        butNew.onclick =deleteTag(butNew.innerText)
        butNew.classList.add("tagButton")
        filterDisplayTag.appendChild(butNew)
    }
})

function searchRecettes() { //Envoie la demande de recherche
    //On récupérer les mots de la barre de recherche
    let searchValue = searchBar.value.trim()

  // Construction des paramètres GET
    let params = new FormData()

    if (searchValue != "") {
    params.append("search", searchValue)
    }

    tabIng.forEach(ing => params.append("ingredients", ing))
    tabTag.forEach(tag => params.append("tags", tag))

    let options = {
            method: 'GET',
            body: params
        }
  // Envoi de la requête
    fetch(URL A METTRE, options).then(response => {
            if (response.ok) {
                console.log("Requete ok")
            } else {
                alert("ERREUR avec la requête.", response.statusText);
            }
        }).catch(error => {
            console.log("ERREUR avec le fetch.", error)
        })
}

// Déclenchement sur le bouton recherche
searchButton.addEventListener("click", searchRecettes)

// Déclenchement aussi en appuyant sur Entrée dans la barre
searchBar.addEventListener("keydown", (e) => {
  if (e.key === "Enter") searchRecettes()
})
    


    })
