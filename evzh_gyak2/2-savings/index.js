const form = document.querySelector("form");
const divContainer = document.querySelector(".container");

const inputFields = form.querySelectorAll("input");
const inputLabels = divContainer.querySelectorAll("label");

function initialConsumption() {
    let initial = [];

    inputFields.forEach(element => {
        let consumption = parseInt(element.getAttribute('data-consumption'));
        initial.push(consumption);
    });

    return initial;
}

function actualConsumption() {
    let actual = [];
    inputFields.forEach(element => {
        let val = parseInt(element.getAttribute('value'));
        let max = parseInt(element.getAttribute('max'));
        let ci  = (val / max) * parseInt(element.getAttribute('data-consumption'));
        actual.push(ci); 
    });
    return actual;
}

function setLabelWidths(total, actualConsumptions) {
    if (inputFields.length !== inputLabels.length) return;
    
    for (let i = 0; i < inputLabels.length; i++) {
        inputLabels[i].style.width = 
        `${(actualConsumptions[i] / total) * 100}%`;
    }
}

//const fe = document.querySelector('#fe');
//fe.addEventListener("change", () => console.log(fe.value));

const initialConsumptions = initialConsumption();
const M = initialConsumptions.reduce((acc, x) => acc + x, 0);
console.log(M);
console.log(initialConsumptions);

let actualConsumptions = actualConsumption();
console.log(actualConsumptions);

setLabelWidths(M, actualConsumptions);

form.addEventListener("input", () => {
    actualConsumptions = actualConsumption();
    setLabelWidths(M, actualConsumptions);
})