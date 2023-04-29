let contacts = document.querySelector('#contacts')

contacts.addEventListener('click', (e) => {
  onclick(e)
})

function onclick(e) {
  let str = e.target.getAttribute('data-toggle')
  console.log(str)
  if (str !== null) {
    let lastp = e.target.parentNode
    let allps = lastp.parentNode.children

    for (const p of allps) {
      if (p.getAttribute('class') !== null && p.getAttribute('class') !== 'name') {
        if (p.getAttribute('class') === str) p.removeAttribute('hidden')
        else p.setAttribute('hidden',  'true')
      }
    }
  }
}