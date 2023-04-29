// Kiválasztott elemek
const buttonAdd = document.querySelector("button");
const divList = document.querySelector("#list");
const textarea = document.querySelector("textarea");
const inputLabel = document.querySelector("#label-input");
const divViewer = document.querySelector("#viewer");
const divLabels = document.querySelector("#labels");

//console.log(quotesDatabase);

// Állapot
const quotes = {
  /*
  "example-id": {
    id: "example-id",
    text: "example quote",
    labels: ""
  }
  */
};

let selectedQuote = null;

// Megoldás

function addDiv(obj) {
  let div = document.createElement('div');
  div.setAttribute('data-id', obj.id);
  div.innerHTML = obj.text.substring(0, 60) + " ...";

  div.addEventListener("click", (e) => onDivClicked(e));

  divList.appendChild(div);
}

function onDivClicked(e) {
  console.log(e.target);

  let id = e.target.getAttribute('data-id');
  console.log(id);
  
  selectedQuote = quotes[id];
  console.log(selectedQuote);

  textarea.textContent = selectedQuote.text;
  inputLabel.textContent = selectedQuote.labels;
}

buttonAdd.addEventListener("click", () => {
  let id = getId();
  let quote = quotesDatabase[random(0, quotesDatabase.length)];
  quotes[id] = {id: id, text: quote, labels: ""};
  
  console.log(quote);
  console.log(quotes);

  addDiv(quotes[id]);
});

// =============== Segédfüggvények =================

function random(a, b) {
  return Math.floor(Math.random() * (b - a + 1)) + a;
}
function getId() {
  return crypto.randomUUID();
}
