// Vérification du login via css
document.addEventListener('DOMContentLoaded', function (){

        // récupération du formulaire
        let form = document.getElementById("LogIn")

        // accès grâce au nom du champ
        let username = form.username
        let password = form.password

        //Récupération de l'affichage de l'erreur
        let errorDiplay = document.getElementById("errorForm")

        //Vérification
        form.addEventListener("submit", function (event){

            //On empeche le comportement de base
            event.preventDefault()

            if(username =="" || password==""){
                errorDiplay.innerText="Tous les champs doivent etre remplis"    
            }
            else{
                form.submit()
                errorDiplay.innerText=""
            }
        })
    


    })
