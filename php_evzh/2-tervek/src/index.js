const f = _ => document.querySelector('.deathstar')?.classList.toggle('shiny')
f()
setInterval(f, 2000)