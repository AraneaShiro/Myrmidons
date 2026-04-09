document.addEventListener('DOMContentLoaded', function () {
    let form = document.getElementById("LogIn")
    console.log(form)
    let username = form.username
    let password = form.password
    let errorDisplay = document.getElementById("errorForm")

    form.addEventListener("submit", function (event) {
        event.preventDefault()

        if (username.value == "" || password.value == "") {
            errorDisplay.innerText = "Tous les champs doivent être remplis"
        } else {
            errorDisplay.innerText = ""
            form.submit()
        }
    })
})