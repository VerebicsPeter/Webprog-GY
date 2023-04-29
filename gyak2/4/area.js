const output = document.querySelector("output")
const num = document.querySelector("#num")
const but = document.querySelector("#btn")

btn.addEventListener("click", calculateArea)

function calculateArea() {
    const r = num.value

    if (r >= 1) {
        let area = r * r * Math.PI

        output.innerHTML = `The area of the circle is ${area}`

        drawCircle(r)
    }
    else {
        // clear canvas //
        
        output.innerHTML = 'r is 0 or negative'

        let canvas = document.getElementById("circleCanvas");
    }
}

function drawCircle(r) {
    let c   = document.getElementById("circle");
    let ctx = c.getContext("2d");
    ctx.beginPath();
    ctx.arc(100, 75, r, 0, 2 * Math.PI);
    ctx.stroke();
}