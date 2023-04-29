const video = document.querySelector("video")
c1 = document.getElementById("c1");
ctx1 = c1.getContext("2d");
c2 = document.getElementById("c2");
ctx2 = c2.getContext("2d");
let width, height

video.addEventListener("play", () => {
    width = video.videoWidth;
    height = video.videoHeight;
    timerCallback();
})

function playPause() {
    if (video.paused) {
        video.play()
        playbtn.value = "Pause"
    } else {
        video.pause()
        playbtn.value = "Play"
    }
}

//kepkockankent csinaljuk
function timerCallback() {
    if (video.paused || video.ended) {
        return;
    }
    computeFrame();
    setTimeout(timerCallback, 0);
}

function computeFrame() {
    //kirajzoljuk a videot az elso canvasra
    ctx1.drawImage(video, 0, 0, width, height)
    //lekerjuk az adott kepkockat
    const frame = ctx1.getImageData(0, 0, width, height)
    const data = frame.data

    //4 csatorna van, r,g,b es a -> alpha, atlatszosag, ezert lepunk 4-et

    for (let i = 0; i < data.length; i += 4) {
        const r = data[i]
        const g = data[i + 1]
        const b = data[i + 2]

        //rgb -bol ki tudjuk szamolni a vilagossagot, 0-255 ertekekbol, 0-1 intervallumra tesszuk, 
        //mai korban hsv:  A "Hue" csatorna a szinarnyalatot, a "Saturation" a szintelitettseget, a "Value" pedig a fenyesseget adja meg.
        //HSV szinterben az egymashoz hasonlo szinek, legalabbis ahogyan az emberi latas erzekeli oket, 
        //kozeli HSV ertekeken jelennek meg.

        const val = ((r + g + b) / 3) / 255
        //0.2 alatt fekete, egyebkent feher
        const col = val < 0.2 ? 0 : 255

        // Átmenettel
        //const col = (r + g + b) / 3

        data[i] = col
        data[i + 1] = col
        data[i + 2] = col
    }

    //kirakjuk a feldolgozott kepet a 2. canvasra
    ctx2.putImageData(frame, 0, 0)
}