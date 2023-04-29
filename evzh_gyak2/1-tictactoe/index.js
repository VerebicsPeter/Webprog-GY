const task1 = document.querySelector('#task1')
const task2 = document.querySelector('#task2')
const task3 = document.querySelector('#task3')
const task4 = document.querySelector('#task4')

const game = [
  "XXOO",
  "O OX",
  "OOO ",
]

let fstLength = game[0].length

let isSameLength = true
game.forEach(row => {if (row.length !== fstLength) isSameLength = false})
task1.innerHTML = `${isSameLength}`

let onlyOX = true
for (let i = 0; i < fstLength; i++) {
  if (game[0].charAt(i) !== 'X' && game[0].charAt(i) !== 'O') onlyOX = false
}
task2.innerHTML = `${onlyOX}`

let cntO = 0, cntX = 0
game.forEach(row => {
  for (let i = 0; i < row.length; i++) {
    if (row.charAt(i) === 'X') cntX++
    if (row.charAt(i) === 'O') cntO++
  }
})
task3.innerHTML = `${cntX + cntO}`

let rowIndex = -1
for (let i = 0; i < game.length; i++) {
  if (game[i].includes('OOO') || game[i].includes('XXX')) rowIndex = i
}
task4.innerHTML = `${rowIndex == -1 ? 'Nincs ilyen sor.' : rowIndex}`
