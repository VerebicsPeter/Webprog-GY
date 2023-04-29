// ========= Selected elements ========= //
const canvas = document.querySelector('canvas');
const ctx = canvas.getContext("2d");

// =============== Utilities ================= //
function isCollision(box1, box2) {
  return !(
    box2.y + box2.height < box1.y ||
    box1.x + box1.width  < box2.x ||
    box1.y + box1.height < box2.y ||
    box2.x + box2.width  < box1.x
  );
}

function random(a, b) {
  return Math.floor(Math.random() * (b - a + 1)) + a;
}

// ========= Application state ========= //
const arrow = {
  fx: 10, fy: 290,
  tx: 30, ty: 350,
};
const ball = {
  x: 10, y: 290,
  width: 20, height: 20,
  vx: 0,  // px/s
  vy: 0,  // px/s
  ay: 0,  // px/s^2
  img: new Image(),
};
const windows = [
  { x: 479, y: 122, width: 15, height: 30 },
  { x: 494, y: 240, width: 18, height: 42 },
  { x: 562, y: 240, width: 18, height: 42 },
];
const bush = {
  x: 250,y: 200,
  width: 100, height: 200,
  img: new Image(),
};
let lovedWindow = 0;
let gameState   = 0; // 0-start, 1-moving, 2-hit, 3-missed
let r = random(0, 2)

// ========= Time-based animation (from the lecture slide) ========= //
let lastFrameTime = performance.now();

function next(currentTime = performance.now()) {
  const dt = (currentTime - lastFrameTime) / 1000; // seconds
  lastFrameTime = currentTime;

  update(dt); // Update current state
  collision(); // Check for collisions
  render(); // Rerender the frame
  
  //console.log(gameState)
  requestAnimationFrame(next);
}

function update(dt) {
  ball.x += ball.vx
  ball.y += ball.vy
  ball.vy += ball.ay
}

function collision() {
  let collidedWindows = false
  
  windows.forEach(e => {if (isCollision(e, ball)) collidedWindows = true;});

  if(isCollision(ball, bush) || collidedWindows || 
    ball.x < 0 || ball.y < 0 || ball.x > canvas.width || ball.y > canvas.height)
  { // on collision
    ball.vx = 0; ball.vy = 0; ball.ay = 0;
    if (isCollision(ball, windows[r])) {
      gameState = 2;
    } else {
      gameState = 3;
    }
  } else {
    gameState = ball.vx > 0 ? 1 : 0;
  }
}

function render() {
  // Background
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  // Draw collision boxes and windows
  ctx.beginPath();
  
  ctx.rect(ball.x, ball.y, ball.width, ball.height);
  ctx.fillStyle = "red"; ctx.fill();
  
  ctx.rect(bush.x, bush.y, bush.width, bush.height);
  ctx.fillStyle = "red"; ctx.fill();

  for (let i = 0; i < windows.length; i++) {
    let e = windows[i]
    ctx.beginPath();
    ctx.rect(e.x, e.y, e.width, e.height);
    ctx.fillStyle = i === r ? 'yellow' : 'blue';
    ctx.fill();
  }

  // Draw line
  ctx.beginPath();
  ctx.moveTo(arrow.fx, arrow.fy);
  ctx.lineTo(arrow.tx, arrow.ty);
  ctx.lineWidth = 3;
  ctx.strokeStyle = 'red'; ctx.stroke();

  // Draw images
  ctx.drawImage(ball.img, ball.x, ball.y);
  ctx.drawImage(bush.img, bush.x, bush.y);

  if (gameState === 2) {
    ctx.beginPath();
    ctx.font = "30px Arial";
    ctx.fillStyle = 'yellow';
    ctx.fillText("szegsz;)", 10, 50);
  }
  if (gameState === 3) {
    ctx.beginPath();
    ctx.font = "30px Arial";
    ctx.fillStyle = 'yellow';
    ctx.fillText("shite:C", 10, 50);
  }
}

// ========= Start the loop ========= //
bush.img.src = "bush.png";
ball.img.src = "ball.png";
next();

// ========= Events listeners ========= //
canvas.addEventListener("mousemove", (e) => {
  let x = e.offsetX
  let y = e.offsetY
  arrow.tx = x;
  arrow.ty = y;
})

canvas.addEventListener("mousedown", (e) => {
  if (ball.vx === 0 && ball.vy === 0 && ball.x === 10)
  // if speed is null and ball is on starting position
  {
    ball.vx = (arrow.tx - arrow.fx) / 75
    ball.vy = (arrow.ty - arrow.fy) / 75
    ball.ay = 0.025
  }
})
