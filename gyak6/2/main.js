import { setCookie, getCookie, deleteCookie } from "../cookies.js"

const select = document.querySelector("#bgcol")


select.addEventListener("change", () => {
    document.body.style.backgroundColor = select.value
    setCookie("bgcol", select.value)
})

const bgcol = getCookie("bgcol")

if (bgcol != "") {
    select.value = bgcol
    document.body.style.backgroundColor = bgcol
}