// div selectors //
const menuDiv = document.querySelector("#menu")
const gameDiv = document.querySelector("#game")
const playerOneInfo = document.querySelector("#playerOneInfo")
const playerTwoInfo = document.querySelector("#playerTwoInfo")

// name and start button selectors //
const name1Text = document.querySelector("#name1")
const name2Text = document.querySelector("#name2")
const startBtn = document.querySelector("#start")
startBtn.addEventListener("click", onStartClick)

// game table selector and event listeners //
const table = document.querySelector("tbody")
table.addEventListener("click", onTileClick)
const output = document.querySelector("#output")

// game size //
const gameSize = 6
// game point (needed for winning) //
let gamePoints = document.querySelector('#points').value

// game state object //
let gameState= {
    player1 : {
        name : '', value : 1,
        cats : 8, points : 0
    },
    player2 : {
        name : '', value : 2,
        cats : 8, points : 0
    },
    current : {},
    board : [],
    state : ''
}

function tryReadInput()
{
    if (name1Text === "" || name2Text === "") return false

    name1 = name1Text.value
    name2 = name2Text.value
    return true
}

// start game event handler //
function onStartClick()
{
    if (!tryReadInput()) return
    meow(); startGame()
}

// click tile event handler //
function onTileClick(e)
{
    if (e.target.matches("td")) {
        const row = e.target.closest("tr").rowIndex
        const col = e.target.closest("td").cellIndex
        const td = e.target.closest("td")
        
        // only place if player has cats
        if (gameState.current.cats > 0) {
            // replace with function //
            let cell = gameState.board[row][col]
            // only place if cell is empty
            if (cell === 0) {turn(row, col, td)}
        }
        updateInfoViews()
        console.log(`(${row},${col}) = ${gameState.board[row][col]}`)
    }
}

// start the game
function startGame() {
    resetGameState()
    gameState.player1.name = name1
    gameState.player2.name = name2
    playerOneInfo.querySelector('h3').innerHTML = `${name1}`
    playerTwoInfo.querySelector('h3').innerHTML = `${name2}`
    updateInfoViews()

    menuDiv.hidden = true
    gameDiv.hidden = false
    playerOneInfo.hidden = false
    playerTwoInfo.hidden = false

    table.innerHTML = ""
    for (let i = 0; i < gameSize; i++) {
        const row = table.insertRow()
        for (let j = 0; j < gameSize; j++) {
            row.insertCell();
        }
    }
    
    for (let i = 0; i < gameSize; i++) {
        rowData = []
        for (let j = 0; j < gameSize; j++) {
            rowData.push(0)
        }
        gameState.board.push(rowData);
    }

    console.log(gameState.board)
}

// resets game's state
function resetGameState() {
    gameState.board = []
    gameState.player1.cats = 8; gameState.player1.points = 0
    gameState.player2.cats = 8; gameState.player2.points = 0
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
        gameState.state = `${gameState.player1.name} nyert.`
        return true
    }
    if (gameState.player2.cats === 0) {
        gameState.state = `${gameState.player2.name} nyert.`
        return true
    }

    for (let i = 0; i < gameSize; i++) {
        for (let j = 0; j < gameSize; j++) {
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
    if (gameState.player1.points >= gamePoints) {
        gameState.state = `${gameState.player1.name} nyert.`
        return true
    }
    if (gameState.player2.points >= gamePoints) {
        gameState.state = `${gameState.player2.name} nyert.`
        return true
    }
    return false
}

function matchingNeighbours(row, col, board) {
    if (board[row][col] === 0) return []
    
    let res = []
    let h = false, v = false, ld = false, rd = false
    if (-1 < col - 1 && col + 1 < gameSize) h = board[row][col - 1] === board[row][col] && board[row][col + 1] === board[row][col] // horizontal
    if (-1 < row - 1 && row + 1 < gameSize) v = board[row - 1][col] === board[row][col] && board[row + 1][col] === board[row][col] // vertical
    if (-1 < col - 1 && col + 1 < gameSize && -1 < row - 1 && row + 1 < gameSize) {
        ld = board[row - 1][col - 1] === board[row][col] && board[row + 1][col + 1] === board[row][col] // left-diagonal
    }
    if (-1 < col - 1 && col + 1 < gameSize && -1 < row - 1 && row + 1 < gameSize) {
        rd = board[row + 1][col - 1] === board[row][col] && board[row - 1][col + 1] === board[row][col] // right-diagonal
    }

    if (h)  res.push([row, col - 1], [row, col], [row, col + 1])
    if (v)  res.push([row - 1, col], [row, col], [row + 1, col])
    if (ld) res.push([row - 1, col - 1], [row, col], [row + 1, col + 1])
    if (rd) res.push([row + 1, col - 1], [row, col], [row - 1, col + 1])

    return res
}

function turn(row, col, td) {
    td.innerHTML = getPictureResourece(gameState.current.value); meow()
    // place cat
    gameState.board[row][col] = gameState.current.value
    gameState.current.cats--;
    // boop cats
    boopBoard(row, col)
    // update view
    updateBoardView()
    if (updateGameState()) {
        alert(gameState.state); startGame()
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
            if (i < 0 || j < 0 || i >= gameSize || j >= gameSize) continue

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

    if (row < 0 || row >= gameSize || col < 0 || col >= gameSize) { // if booped off board
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

function getPictureResourece(num) {
    if (num == 1) return '<img src="./assets/cat1.png" width="50" height="50"></img>'
    if (num == 2) return '<img src="./assets/cat2.png" width="50" height="50"></img>'
    return ""
}

function meow() {
    let audio = new Audio('./assets/meow.mp3'); audio.play(); 
}
