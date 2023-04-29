const task1 = document.querySelector('#task1');
const task2 = document.querySelector('#task2');
const task3 = document.querySelector('#task3');
const task4 = document.querySelector('#task4');

console.log(districts);

// a)
let gt20 = 0;
districts.forEach(element => {
    if (element.area > 20) gt20++;
});
task1.innerHTML = gt20;

// b)
let nameOf22thDistrict = '';
districts.forEach(element => {
    if (element.numeric === "XXII.") nameOf22thDistrict = element.name;
})
if (nameOf22thDistrict !== '') task2.innerHTML = nameOf22thDistrict;

// c)
let mostDense = '';
let maxPopulationDensity = -Infinity;
districts.forEach(element => {
    let density = element.population / element.area;
    if (density > maxPopulationDensity) {
        maxPopulationDensity = density;
        mostDense = element.name;
    }
})
task3.innerHTML = `${mostDense}, ${maxPopulationDensity.toFixed(2)}`;

// d)
let topFive = [];
districts.sort((a, b) => {
    if (a.population > b.population) return  1;
    if (a.population < b.population) return -1;
    return 0;
})

let len = districts.length;
for (let i = len - 1; i >= len -5 && i >= 0; i--) {
    topFive.push(districts[i].name);
}
task4.innerHTML = topFive.toString().replaceAll(',', ", ");