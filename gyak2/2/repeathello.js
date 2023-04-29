const output = document.querySelector("output")
const num = document.querySelector("#num")
const btn = document.querySelector("#btn")

btn.addEventListener("click", hello)

function hello() {
    for (let i = 0; i < num.value; i++) {
        const p = document.createElement("p")
        p.textContent = "Hello, world!"
        p.style.fontSize = 12 + i + "px"
        output.appendChild(p)
    }
}