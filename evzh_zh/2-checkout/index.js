const productSelect = document.querySelector('select');
const amountInput = document.querySelector('#amount');
const showVAT = document.querySelector('#vat');
const addButton = document.querySelector('#add');
const stornoButton = document.querySelector('#storno');
const tableHead = document.querySelector('table thead');
const tableBody = document.querySelector('table tbody');
const totalOutput = document.querySelector('#total');

const vatTh = document.querySelector('#vatTh');

class RowData {
    constructor(code, name, quantity, price) {
        this.code = code;
        this.name = name;
        this.quantity = quantity;
        this.unitp = price;
        this.total = quantity * price;
        this.vat = Math.round(this.total * 0.27);
    }
}

let rowsData = [];

for (const [key, value] of Object.entries(products)) {
    console.log(`${key} - ${value.name} - ${value.price}`);
    
    let option = document.createElement("option");
    option.text = `${key} - ${value.name} - ${value.price}`;
    option.value = key;
    productSelect.add(option);
}

// functions
function addRow() {
    let code = productSelect.value;
    let selected = products[code];
    console.log(selected);

    let quantity = parseInt(amountInput.value);

    let row = tableBody.insertRow(-1);
    let rowData = new RowData(code, selected.name, quantity, selected.price);

    let codeTd = document.createElement("td");
    let nameTd = document.createElement("td");
    let quanTd = document.createElement("td");
    let priceTd = document.createElement("td");
    let vatTd = document.createElement("td");
    let totalTd = document.createElement("td");
    
    codeTd.innerHTML = code;
    nameTd.innerHTML = rowData.name;
    quanTd.innerHTML = rowData.quantity;
    priceTd.innerHTML = rowData.unitp + " Ft";
    vatTd.innerHTML = rowData.vat + " Ft";
    totalTd.innerHTML = rowData.total + " Ft";

    row.appendChild(codeTd);
    row.appendChild(nameTd);
    row.appendChild(quanTd);
    row.appendChild(priceTd);
    row.appendChild(vatTd);
    row.appendChild(totalTd);

    vatTd.setAttribute('class', 'vatTableData');
    vatTd.hidden = showVAT.checked ? false : true;
    vatTh.hidden = showVAT.checked ? false : true;

    rowsData.push(rowData);

    updateTotal();
    console.log(rowsData);
}

function updateTotal() {
    let total = 0;

    rowsData.forEach(element => total += element.total);
    totalOutput.innerHTML = `${total}`;
}

function deleteRows() {
    while(rowsData.length > 0) {rowsData.pop();}
    updateTotal();
    tableBody.innerHTML = '';
}

// event listeners
addButton.addEventListener("click", () => addRow());

stornoButton.addEventListener("click", () => deleteRows());

showVAT.addEventListener("click", () => {
    vatTh.hidden = showVAT.checked ? false : true;
    let vatTDs = document.querySelectorAll('.vatTableData');
    vatTDs.forEach(element => {
        element.hidden = showVAT.checked ? false : true;
    });
});