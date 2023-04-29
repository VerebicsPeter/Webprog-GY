let x = true

document.querySelector("tbody").addEventListener("click", (e) => {
    if (e.target.innerText == "") {
        e.target.innerText = x ? "X" : "O"
        x = !x
    }
})