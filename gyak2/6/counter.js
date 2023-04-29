let num = 0
const max = 100
const min = 0

// for timer //
const delay = 800
const rate  = 100

let delayTimer, rateTimer
//////////////

const text = document.querySelector("#num")
const addBtn = document.querySelector("#add")
const subtractBtn = document.querySelector("#subtract")

add = () => {text.value = ++num; updateDisable()}
addBtn.addEventListener("click", add)

subtract = () => {text.value = --num; updateDisable()}
subtractBtn.addEventListener("click", subtract)

function updateDisable() {
    addBtn.disabled = (num == max)
    subtractBtn.disable = (num == min)
}

// mouse down and up event listeners //

addBtn.addEventListener("mousedown", () => {
    delayTimer = setTimeout(() => rateTimer = setInterval(add, rate) , delay)
})

addBtn.addEventListener("mouseup", killTimers)

subtractBtn.addEventListener("mousedown", () => {
    delayTimer = setTimeout(() => rateTimer = setInterval(subtract, rate) , delay)
})

subtractBtn.addEventListener("mouseup", killTimers)

//////////////////////////////////////

function killTimers() {
    clearTimeout(delayTimer)
    clearTimeout(rateTimer)
}