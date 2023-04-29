// ========= Utility functions ========= //
function random(a, b) {
  return Math.floor(Math.random() * (b - a + 1)) + a;
}

// ========= Selected elements ========= //
const inputGuess = document.querySelector("#inputGuess");
const form = document.querySelector("form");
const tableGuesses = document.querySelector("#guesses");
const divTheWord = document.querySelector("details > div");
const spanError = document.querySelector("#error");
const btnGuess = document.querySelector("form > button");
const divEndOfGame = document.querySelector("#end-of-game");
const btnRestart = document.querySelector("#restart");

// ========= Solution ========= //
let gameOver = false
let theWord = wordList[random(0, wordList.length)]
divTheWord.innerHTML = theWord
let guess

function SubmitGuess() {
  console.log(inputGuess.value)
  guess = inputGuess.value
  inputGuess.select()
  spanError.textContent = ""
  if (guess.length != 5) {
    spanError.textContent = "The length of the word is not 5!"
  } else if (!wordList.includes(guess)) {
    spanError.textContent = "The word is not considered acceptable!"
  } else AddGuess()
}

function AddGuess() {
  let matches = CountMatchingChars(theWord, guess)
  let row = tableGuesses.insertRow(0)
  let guessCell = row.insertCell(0)
  let matchCell = row.insertCell(1)
  guessCell.innerHTML = guess
  matchCell.innerHTML = matches
  if (matches === 5) {
    gameOver = true
    row.classList.add('correct')
    btnGuess.disabled = true
    divEndOfGame.hidden = false
  }
}

function CountMatchingChars(str1, str2) {
  if (str1.length !== str2.length) return -1
  let c = 0
  for (let i = 0; i < str1.length; i++) {
    if (str1[i] === str2[i]) c++        }
  return c
}

inputGuess.addEventListener("keydown", (e) => {
  if (e.keyCode === 13 && !gameOver) {e.preventDefault(); SubmitGuess()}
})
btnGuess.addEventListener("click", (e) => {e.preventDefault(); SubmitGuess()})

btnRestart.addEventListener("click", () => {
  theWord = wordList[random(0, wordList.length)]; divTheWord.innerHTML = theWord
  guess = ""
  tableGuesses.innerHTML = ""
  gameOver = false
  btnGuess.disabled = false; divEndOfGame.hidden = true
})