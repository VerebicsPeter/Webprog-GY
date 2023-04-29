const image = document.querySelector("#image")
const button = document.querySelector("#btn")
const textField = document.querySelector("#text")

button.addEventListener("click", genTable)

function genTable() {
    image.src = textField.value
}