const iban = document.querySelector("#iban")

iban.addEventListener("input", (e) => {
    let num = e.target.value.replace(/\s/g, "") // replace spaces
    if (isNaN(num)) {
        e.target.value = e.target.value.slice(0, -1)
    }
    else {
        for (let i = 4; i < num.length; i += 5) {
            num = num.slice(0, i) + " " + num.slice(i)
        }
        e.target.value = num
    }
})
