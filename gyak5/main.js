const menuDiv = document.querySelector("#menu")
const gameDiv = document.querySelector("#game")

const name1Text = document.querySelector("#name1")
const name2Text = document.querySelector("#name2")
const sizeText = document.querySelector("size")
const startBtn = document.querySelector("#start")
startBtn.addEventListener("click", startGame)

const table = document.querySelector("tbody")
table.addEventListener("click", clickTile)
const output = document.querySelector("#output")
let size; let sign = 'X'; let placedSigns = 0

function startGame() {
    if (!tryReadInput()) return

    output.innerHTML = `${name1} következik`
    menuDiv.hidden = true
    gameDiv.hidden = false

    for (let i = 0; i < size; i++) {
        const row = table.insertRow()
        for (let j = 0; j < size; j++) {
            row.insertCell()
        }
    }
}

function tryReadInput() {
    if (name1Text === "" || name2Text === "" || sizeText  === "" || sizeText < 15 || sizeText > 25)
    return false

    size = parseInt(document.querySelector("#size").value)
    name1 = name1Text.value
    name2 = name2Text.value
    return true
}

function clickTile(e) {
    if (e.target.matches('td')) {
        const row = e.target.closest("tr").rowIndex
        const col = e.target.closest("td").cellIndex
        placeSign(row, col)
        
        if (checkForWin(row, col)) {
            output.innerText = (sign == 'X' ? name1 : name2) + " nyert!"
            table.removeEventListener("click", clickTile)
        }
        else if (checkForTie()) {
            output.innerText("Döntetlen")
            table.removeEventListener("click", clickTile)
        }
        else changePlayer()
    }
}

checkForTie = () => placeSign == size * size

placeSign   = (row, col) =>
{
    const cell = table.rows[row].cells[col]
    if (cell.innerText != "") return
    cell.innerText = sign
    placedSigns++
}

isInPlayArea = (row, col) => {return row < size && row >= 0 && col < size && col >= 0}

function countInDirection(row, col, rowx, colx) {
    let i

    for (i = 0; isInPlayArea(row, col); i++) {
        if (getCellSign(row, col) == sign) {row += rowx; col += colx} else break
    }

    return i // this returns the number of cells matching 'sign'
}

function checkForWin(row, col) {
    return 5 < countInDirection(row, col,  1,  1) + countInDirection(row, col, -1, -1) // diag
    ||     5 < countInDirection(row, col,  1, -1) + countInDirection(row, col, -1,  1) // left-diag
    ||     5 < countInDirection(row, col,  1,  0) + countInDirection(row, col, -1,  0) // vertical
    ||     5 < countInDirection(row, col,  0,  1) + countInDirection(row, col,  0, -1) // horizontal
}

function getCellSign(row, col) {
    return table.rows[row].cells[col].innerText
}

function changePlayer() {
    sign = sign == 'X' ? 'O' : 'X'
    //output.innerText 
}
// hf kijavitani