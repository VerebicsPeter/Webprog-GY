document.addEventListener("click", onclick)

onclick = (e) => {
    if (e.target.matches("a"))
    {
        if (!e.target.href.includes("elte")) e.preventDefault()
    }
}

// !!! csoport ZH lesz !!!