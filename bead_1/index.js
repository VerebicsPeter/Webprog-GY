// div selectors //
const menuDiv = document.querySelector("#menu")
const gameDiv = document.querySelector("#game")
const statDiv = document.querySelector("#stat")
const restartDiv = document.querySelector("#restart")
const playerOneInfo = document.querySelector("#playerOneInfo")
const playerTwoInfo = document.querySelector("#playerTwoInfo")
playerOneInfo.addEventListener("dragstart", onDragStart)
playerTwoInfo.addEventListener("dragstart", onDragStart)

// name and start button selectors //
const name1Text = document.querySelector("#name1")
const name2Text = document.querySelector("#name2")
const startBtn = document.querySelector("#start")
const restartBtn = document.querySelector("#restartBtn")
const menuBtn = document.querySelector('#menuBtn')
startBtn.addEventListener("click", onStartClick)
restartBtn.addEventListener("click", onRestartClick)
menuBtn.addEventListener('click', onMenuClick)

// game table selector and event listeners //
const table = document.querySelector("tbody")
table.addEventListener("click", onTileClick)
table.addEventListener("dragover", onTileDragOver)
table.addEventListener("drop", onTileDrop)
let dragged = '' // dragged images name

// elements for string outputs //
const output = document.querySelector("#output")
const winner = document.querySelector("#winner")

// game size //
const gameSize = document.querySelector("#size")
// number of cats //
const gameCats = document.querySelector("#cats")
// game point (needed for winning) //
const gamePoints = document.querySelector("#points")

// gameStats array (holds past games' stats) //
let gameStats = JSON.parse(getCookie("gameStats"))
updateStatDiv()

// game state object //
let gameState = {
    player1 : {
        name : '', value : 1,
        cats : gameCats.value, points : 0
    },
    player2 : {
        name : '', value : 2,
        cats : gameCats.value, points : 0
    },
    current : {},
    board : [],
    state : ''
}

function tryReadInput()
{
    if (name1Text.value === "" || name2Text.value === "") return false

    name1 = name1Text.value
    name2 = name2Text.value
    return true
}

// start game event handler //
function onStartClick()
{
    if (!tryReadInput()) return
    meow(0); startGame()
}

// restart game event handler //
function onRestartClick()
{
    meow(0); startGame()
}
// menu btn event handler //
function onMenuClick()
{
    meow(0);
    menuDiv.hidden = false
    statDiv.hidden = false
    restartDiv.hidden = true
    gameDiv.hidden = true
    playerOneInfo.hidden = true
    playerTwoInfo.hidden = true
}

// click tile event handler //
function onTileClick(e)
{
    if (gameState.state !== "none") return
    if (e.target.matches("td"))
    {
        const row = e.target.closest("tr").rowIndex
        const col = e.target.closest("td").cellIndex
        const td = e.target.closest("td")
        
        // only place if player has cats
        if (gameState.current.cats > 0) {
            let cell = gameState.board[row][col]
            // only place if cell is empty
            if (cell === 0) {turn(row, col, td)}
        }
        updateInfoViews()
        console.log(`(${row},${col}) = ${gameState.board[row][col]}`)
    }
}

// drag player cat image event handler //
function onDragStart(e) {
    let pathStr = e.target.src.split('/')
    let pngName = pathStr[pathStr.length - 1]
    console.log(pngName)
    if (pngName === "cat1.png" && gameState.current.value !== 1) return
    if (pngName === "cat2.png" && gameState.current.value !== 2) return
    dragged = pngName
}
// dragover event handler for tile //
function onTileDragOver(e) { e.preventDefault() }
// drop envent handler for tile //
function onTileDrop(e) {
    if (dragged === '' || (dragged !== 'cat1.png' && dragged !== 'cat2.png')) return
    if (dragged === "cat1.png" && gameState.current.value !== 1) return
    if (dragged === "cat2.png" && gameState.current.value !== 2) return
    onTileClick(e)
}

// start the game
function startGame() {
    resetGameState()
    gameState.player1.name = name1
    gameState.player2.name = name2
    playerOneInfo.querySelector('h3').innerHTML = `${name1}`
    playerTwoInfo.querySelector('h3').innerHTML = `${name2}`
    updateInfoViews()
    // hide menus
    menuDiv.hidden = true
    statDiv.hidden = true
    restartDiv.hidden = true
    // unhide game divs
    gameDiv.hidden = false
    playerOneInfo.hidden = false
    playerTwoInfo.hidden = false

    table.innerHTML = ""
    for (let i = 0; i < gameSize.value; i++) {
        const row = table.insertRow()
        for (let j = 0; j < gameSize.value; j++) {
            row.insertCell();
        }
    }
    
    for (let i = 0; i < gameSize.value; i++) {
        let rowData = []
        for (let j = 0; j < gameSize.value; j++) {
            rowData.push(0)
        }
        gameState.board.push(rowData);
    }

    console.log(gameState.board)
}

// resets game's state
function resetGameState() {
    gameState.board = []
    gameState.player1.cats = gameCats.value; gameState.player1.points = 0
    gameState.player2.cats = gameCats.value; gameState.player2.points = 0
    gameState.current = gameState.player1
    gameState.state = "none" // only changes on final states
}

// updates game's state, should only be invoked >after< running booping function
function updateGameState() {
    let board = gameState.board

    if (gameState.player1.cats === 0 && gameState.player2.cats === 0) {
        gameState.state = "Döntetlen."
        return true
    }
    if (gameState.player1.cats === 0) {
        gameState.state = `${gameState.player1.name} vesztett.`
        return true
    }
    if (gameState.player2.cats === 0) {
        gameState.state = `${gameState.player2.name} vesztett.`
        return true
    }

    for (let i = 0; i < gameSize.value; i++) {
        for (let j = 0; j < gameSize.value; j++) {
            let r = matchingNeighbours(i, j, board)
            if (r.length > 0)
            {
                let points = r.length / 3
                let x = r[0][0], y = r[0][1]
                if (gameState.board[x][y] === 1) gameState.player1.points += points
                if (gameState.board[x][y] === 2) gameState.player2.points += points

                r.forEach(e => {
                    if (gameState.board[e[0]][e[1]] !== 0) {
                        if (gameState.board[e[0]][e[1]] === 1) gameState.player1.cats++
                        if (gameState.board[e[0]][e[1]] === 2) gameState.player2.cats++
                        gameState.board[e[0]][e[1]] = 0
                    }
                })
                updateBoardView()
            }
        }
    }
    // check if game is won
    if (gameState.player1.points >= gamePoints.value) {
        gameState.state = `${gameState.player1.name} nyert.`
        return true
    }
    if (gameState.player2.points >= gamePoints.value) {
        gameState.state = `${gameState.player2.name} nyert.`
        return true
    }
    return false
}

function matchingNeighbours(row, col, board) {
    if (board[row][col] === 0) return []
    
    let res = []
    let h = false, v = false, ld = false, rd = false
    if (-1 < col - 1 && col + 1 < gameSize.value) h = board[row][col - 1] === board[row][col] && board[row][col + 1] === board[row][col] // horizontal
    if (-1 < row - 1 && row + 1 < gameSize.value) v = board[row - 1][col] === board[row][col] && board[row + 1][col] === board[row][col] // vertical
    if (-1 < col - 1 && col + 1 < gameSize.value && -1 < row - 1 && row + 1 < gameSize.value) {
        ld = board[row - 1][col - 1] === board[row][col] && board[row + 1][col + 1] === board[row][col] // left-diagonal
    }
    if (-1 < col - 1 && col + 1 < gameSize.value && -1 < row - 1 && row + 1 < gameSize.value) {
        rd = board[row + 1][col - 1] === board[row][col] && board[row - 1][col + 1] === board[row][col] // right-diagonal
    }

    if (h)  res.push([row, col - 1], [row, col], [row, col + 1])
    if (v)  res.push([row - 1, col], [row, col], [row + 1, col])
    if (ld) res.push([row - 1, col - 1], [row, col], [row + 1, col + 1])
    if (rd) res.push([row + 1, col - 1], [row, col], [row - 1, col + 1])

    return res
}

function turn(row, col, td) {
    td.innerHTML = getPictureResourece(gameState.current.value); meow(gameState.current.value)
    // place cat
    gameState.board[row][col] = gameState.current.value
    gameState.current.cats--;
    // boop cats
    boopBoard(row, col)
    // update view
    updateBoardView()
    if (updateGameState()) {
        let stats = {
            players: `${gameState.player1.name} vs. ${gameState.player2.name}`, outcome: `${gameState.state}`,
            date: new Date().toLocaleDateString()
        }
        gameStats.push(stats); updateStatDiv()
        setCookie("gameStats", JSON.stringify(gameStats), 1);
        winner.innerHTML = `${gameState.state}`
        restartDiv.hidden = false
    } else {
        switchPlayer()
    }
}

// obj is the game state object
function boopBoard(row, col) {
    // iterate neighbours and move them if they are the other player
    for (let i = row - 1; i <= row + 1; i++) {
        for (let j = col - 1; j <= col + 1; j++) {
            if (i === row && j === col) continue
            if (i < 0 || j < 0 || i >= gameSize.value || j >= gameSize.value) continue

            if (gameState.board[i][j] !== 0) // check if neighbour is player
            {
                console.log(`booping field at (${i},${j})`);
                boopField(i, j, row, col)
            }
        }
    }
}

// (x,  y ) is the location of neighbor to boop
// (x0, y0) is the location of the tile that boops
function boopField(x, y, x0, y0) {
    let dx = x - x0, dy = y - y0
    let row = x + dx
    let col = y + dy

    if (row < 0 || row >= gameSize.value || col < 0 || col >= gameSize.value) { // if booped off board
        if (gameState.board[x][y] === 1) gameState.player1.cats++
        if (gameState.board[x][y] === 2) gameState.player2.cats++
        gameState.board[x][y] = 0
    } else {
        if (gameState.board[row][col] === 0) {
            gameState.board[row][col] = gameState.board[x][y]
            gameState.board[x][y] = 0
        }
    }
}

function switchPlayer() {
    gameState.current = gameState.current.value == 1 ? gameState.player2 : gameState.player1
}

function updateBoardView() {
    let trs = document.querySelectorAll("tr")

    trs.forEach(e => {
        let row = e.rowIndex
        let tds = e.children
        for (let i = 0; i < tds.length; i++) {
            let col = tds[i].cellIndex
            let value = gameState.board[row][col]
            tds[i].innerHTML = value === 0 ? '' : getPictureResourece(value)
        }
    })
}

function updateInfoViews() {
    playerOneInfo.querySelector("p").innerHTML = `${gameState.player1.cats} cica <br/> ${gameState.player1.points} pont`
    playerTwoInfo.querySelector("p").innerHTML = `${gameState.player2.cats} cica <br/> ${gameState.player2.points} pont`
    
    const playerOneImgContainer = playerOneInfo.querySelector('div')
    const playerTwoImgContainer = playerTwoInfo.querySelector('div')
    playerOneImgContainer.innerHTML = ''; playerTwoImgContainer.innerHTML = ''

    for (let i = 0; i < gameState.player1.cats; i++) {
        let img = document.createElement('img')
        img.src = './assets/cat1.png'; img.width = '50'; img.height = '50'
        playerOneImgContainer.appendChild(img)
    }
    for (let i = 0; i < gameState.player2.cats; i++) {
        let img = document.createElement('img')
        img.src = './assets/cat2.png'; img.width = '50'; img.height = '50'
        playerTwoImgContainer.appendChild(img)
    }

    output.innerHTML = `${gameState.current.name} következik`
}

function updateStatDiv() {
    let innerDiv = statDiv.querySelector("div"); innerDiv.innerHTML = "";
    gameStats.forEach(element => {
        let div = document.createElement('div')
        div.innerHTML = `${element.players}: ${element.outcome} (${element.date})<hr>`
        innerDiv.appendChild(div)
    });
}

function getPictureResourece(num) {
    if (num == 1) return '<img src="./assets/cat1.png" width="50" height="50"></img>'
    if (num == 2) return '<img src="./assets/cat2.png" width="50" height="50"></img>'
    return ""
}

function meow(num) {
    if (num !== 0 && num !== 1 && num !== 2) return
    let audio = new Audio(`./assets/meow${num}.mp3`); audio.play()
}

// cookies //

// sets the gameStats as a cookie
function setCookie(name, value, days) {
    let expires = ""
    if (days) {
        let date = new Date()
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000))
        expires = "; expires=" + date.toUTCString()
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/"
}
// get the gameStats from a cookie
function getCookie(name) {
    let nameEq = name + "="
    let ca = document.cookie.split(';')
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i]
        while (c.charAt(0) == ' ') c = c.substring(1, c.length)
        if (c.indexOf(nameEq) == 0) return c.substring(nameEq.length, c.length)
    }
    return null;
}
