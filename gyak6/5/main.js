const video = document.querySelector("video")
const playbtn = document.querySelector("#play")
playbtn.addEventListener("click", playPause)

function playPause() {
    if (video.paused) {
        video.play()
        playbtn.value = "Pause"
    } else {
        video.pause()
        playbtn.value = "Play"
    }
}