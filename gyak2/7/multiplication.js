const texts = document.querySelectorAll("#text")
const but 	= document.querySelector("#btn")
const table = document.querySelector('tbody')

btn.addEventListener("click", addRow)

function addRow() {
    let row = table.insertRow();
    texts.forEach(text => row.insertCell().textContent = text.value)
}	