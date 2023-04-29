const canvas = document.querySelector("canvas");
const ctx = canvas.getContext("2d");

// Állapot
const egg = {
  x: 305, y: -30,
  width: 30, height: 40,
  vy: 0,    // px/s
  ay: 150,  // px/s2
  broken: false, catched: false,
};
const basket = {
  x: 270, y: canvas.height - 50 - 50,
  width: 100,
  height: 50,
  vx: 0, // px/s
};
let gameState = 0; // 0-start, 1-vége
let points = 0;

const eggs = [];

// Időalapú animációs ciklus (az előadásból)
let lastFrameTime = performance.now();

function next(currentTime = performance.now()) {
  const dt = (currentTime - lastFrameTime) / 1000; // másodperc

  lastFrameTime = currentTime;

  update(dt); // állapot frissítése
  render();   // képkocka kirajzolása

  requestAnimationFrame(next);
}

function update(dt) {
  egg.y += egg.vy;
  egg.vy += (egg.ay / 1000);
}

function render() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  ctx.drawImage(wholeEggImage, egg.x, egg.y, egg.width, egg.height);
  ctx.drawImage(basketImage, basket.x, basket.y, basket.width, basket.height);
}

// Képek betöltése animációs ciklus indítása
const wholeEggImage = new Image();
const brokenEggImage = new Image();
const basketImage = new Image();
wholeEggImage.src = "whole-egg.png";
brokenEggImage.src = "broken-egg.png";
basketImage.src = "basket.png";

egg.vy = 1;
next();

// =============== Segédfüggvények =================

function isCollision(box1, box2) {
  return !(
    box2.y + box2.height < box1.y ||
    box1.x + box1.width < box2.x ||
    box1.y + box1.height < box2.y ||
    box2.x + box2.width < box1.x
  );
}

function random(a, b) {
  return Math.floor(Math.random() * (b - a + 1)) + a;
}
