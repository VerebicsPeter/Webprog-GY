document.addEventListener("input", oninput)

oninput = (e) => {
    if (e.target.matches(".szam")) {
        console.log("isNumber")
        if (e.target.value.match(/\s/) || isNaN(e.target.value)) {
            e.target.value = e.target.value.slice(0, -1)
        }
    }
}

// !!! csoport ZH lesz !!!