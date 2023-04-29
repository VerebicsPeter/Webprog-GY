const audio = new Audio("hover.mp3")

document.addEventListener("click", onClick)

function onClick(e) {
    if (!e.target.matches("span")) return
    audio.play()
}