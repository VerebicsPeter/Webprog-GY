const list = document.querySelector("#list")

list.addEventListener("click", onClick)

let x = false
let prev

function onClick(e) {
    if (e.target.matches("ul > li")) {
        if (!x)
        {
            prev = e.target; x = true
        }
        else
        {
            let text = prev.innerText
            prev.innerText = e.target.innerText
            e.target.innerText = text
            x = false
        }
    }
}

// !!! csoport ZH lesz !!!