const avg = document.querySelector('#avg')
const textInput = document.querySelector('#num')
const addButton = document.querySelector('#btn')
const numList = document.querySelector('#numlist')

let selected = []

addButton.addEventListener('click', () => {
    console.log(textInput.value)
    
    if (isNaN(textInput.value) || textInput.value.length === 0) console.log('not a number')
    else { console.log('number')
        let n = parseFloat(textInput.value)

        let lis  = numList.children
        let nums = []
        for (li of lis) {nums.push(parseFloat(li.innerText))}

        if (nums.every(x => x < n) && nums.length < 5) {
            let li = document.createElement("li")
            li.appendChild(document.createTextNode(`${n}`)); li.addEventListener('click', selectListElem)
            numList.appendChild(li)
            selected = []; resetColor()
        }
        if (nums.length >= 5) {
            addButton.disabled = true
        }
    }
})

selectListElem = (e) => {
    if (!(selected.includes(e.target))) selected.push(e.target)
    e.target.style.color = 'red'
    
    let nums = []
    for (li of selected) { nums.push(parseFloat(li.innerText)) }

    avg.textContent = `${nums.reduce((acc, curr) => acc + curr) / nums.length}`
}

resetColor = () => {
    for (li of numList.children) {
        li.style.color = 'black'
    }
}