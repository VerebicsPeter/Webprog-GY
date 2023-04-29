let setbtn     = document.querySelector('#setbtn')
let hue        = document.querySelector('#h')
let saturation = document.querySelector('#s')
let light      = document.querySelector('#l')
let text       = document.querySelector('#t')

function setbg() {
  document.body.style.backgroundColor = `hsl(${hue.value}, ${saturation.value}%, ${light.value}%)`
  document.body.style.color = light.value <= 50 ? 'white' : 'black'
}

setbtn.addEventListener('click', () => {
  text.value = `${hue.value}, ${saturation.value}%, ${light.value}%`
  console.log( `${hue.value}, ${saturation.value}%, ${light.value}%` )

  setbg()
})

hue.addEventListener('input', () => {
  setbg()
})
light.addEventListener('input', () => {
  setbg()
})
saturation.addEventListener('input', () => {
  setbg()
})