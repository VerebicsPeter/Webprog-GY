import { setCookie, getCookie, deleteCookie } from "../cookies.js"

const p = document.querySelector("p")
const nameText = document.querySelector("#name")
const btn = document.querySelector("#btn")

btn.addEventListener("click", () => setCookie("username", nameText.value))

const user = getCookie("username")

if (user != "") {
    p.innerText = "Hello " + user
    deleteCookie("username");
} else {
    nameText.parentElement.hidden = false
}