// Selected elements
const ulContestants = document.querySelector("ul#contestants");
const divEditor = document.querySelector("#contestant-editor");
const btnNew = document.querySelector("#btnNew");
const inputNew = document.querySelector("#inputNew");

// Data
let contestants = {
  "1": {
    id: "1",
    name: "Contestant 1",
    penalties: [
      { timestamp: Date.now(), duration: 60000 },
      { timestamp: Date.now() - 2000, duration: 10000 },
      { timestamp: Date.now() - 10000, duration: 30000 },
    ],
  },
  "2": {
    id: "2",
    name: "Contestant 2",
    penalties: [
      { timestamp: Date.now(), duration: 10000 },
      { timestamp: Date.now() - 5000, duration: 10000 },
      { timestamp: Date.now() - 30000, duration: 30000 },
    ],
  },
};

let selectedContestantID = null;
let selectedContestant = null;

// ========= Solution ========= //

function calculatePenalty(obj) {
  let sum = 0;
  obj.penalties.forEach(p => 
    {let dt = Math.max((p.timestamp + p.duration) - Date.now(), 0); sum += dt;});
  return sum;
}

function setTimeAndClassForListItem(penalty, name, id, obj) {
  for (const [key, value] of Object.entries(obj)) {
    if (value.getAttribute("data-id") == id) {
      if (penalty > 0) {
        value.classList.add('penalty');
      } else {
        value.classList.remove('penalty');
      }
      value.innerHTML = `${name} <span>${penalty != 0 ? Math.floor((penalty/1000) + 1) : 0}s</span>`;
    }
  }
}

function updateEditorListItems() {
  if (selectedContestant === null) return;

  let ulEditor = divEditor.children[2];
  ulEditor.innerHTML = "";

  selectedContestant.penalties.forEach(e => {
    let li = document.createElement("li");
    const date = new Date(e.timestamp);
    const seconds = Math.floor(e.duration/1000);
    let secondsLeft = seconds - Math.floor((Date.now() - date)/1000);

    if (secondsLeft < 0) secondsLeft = 0;
    
    li.innerHTML = 
    `${date.toLocaleString('en-US')} + ${seconds}s <progress max="${seconds}" value="${secondsLeft}"></progress> (${secondsLeft}s)`
    
    ulEditor.appendChild(li);
  });
}

function updateContestantListItems() {
  for (const [key, value] of Object.entries(contestants)) {
    let penalty = calculatePenalty(value);
    
    setTimeAndClassForListItem(penalty, value.name, value.id, ulContestants.children);
  }
}

function tick() {
  updateEditorListItems();
  updateContestantListItems();
}

// main
for (const [key, value] of Object.entries(contestants)) {
  let li = document.createElement("li");
  li.setAttribute("data-id", value.id);
  li.innerHTML = `${value.name} <span>${0}s</span>`;
  ulContestants.appendChild(li);
}
setInterval(() => {tick()}, 1000);

// events
ulContestants.addEventListener("click", (e) => {
  if (e.target === null) return;

  selectedContestantID = e.target.getAttribute("data-id");
  selectedContestant   = contestants[selectedContestantID];
  divEditor.children[0].innerHTML = selectedContestant.name;

  updateEditorListItems();
  
  if (divEditor.hidden === true) {
    divEditor.hidden = false;
  } else {
    divEditor.hidden = true;
  }
});

divEditor.children[1].addEventListener("click", (e) => {
  if (e.target === null) return;
  
  const d = e.target.getAttribute("data-duration");
  const t = Date.now();

  selectedContestant.penalties.push({timestamp: t, duration: d * 1000});
  console.log(selectedContestant.penalties);
  updateEditorListItems();
});

btnNew.addEventListener("click", (e) => {
  if (inputNew.value == '') return;

  let l = Object.keys(contestants).length;
  let index = (l+1).toString();
  let nameStr = inputNew.value;
  
  contestants[index] = {id: index, name: nameStr, penalties: []}

  let li = document.createElement("li");
  li.setAttribute("data-id", index);
  li.innerHTML = `${nameStr} <span>${0}s</span>`;
  ulContestants.appendChild(li);
});