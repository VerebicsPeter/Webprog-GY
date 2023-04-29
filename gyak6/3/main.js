import { setCookie, getCookie, deleteCookie } from "../cookies.js"

const style = document.querySelector("#style")

document.querySelector('#small' ).addEventListener("click", setStyle("small") )
document.querySelector('#medium').addEventListener("click", setStyle("medium"))
document.querySelector('#large' ).addEventListener("click", setStyle("large") )

function setStyle(stylesheet) {
    setCookie("stylesheet", stylesheet)
    style.setAttribute("href", stylesheet + ".css")
}

const stylesheet = getCookie("stylesheet")

if (stylesheet != "") {setStyle(stylesheet)}