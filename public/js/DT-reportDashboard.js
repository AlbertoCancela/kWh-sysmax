import { PHPFetcher } from './handler_DOM.js';
import { renderTable } from './dataTable.js';
import { FetchData } from '../sysmax-api/fetchAPI.js';

let currentPage = 1;
let data = [];
const tbody = document.querySelector(`#table-reports tbody`);

document.addEventListener('DOMContentLoaded', () => {
    fetchDataFromBackend();
});

async function fetchDataFromBackend() { 
    const fetchAPI = new FetchData();
    const response = await fetchAPI.getRecordsBySearch();
    const data = response.data.map((item, index) => ({
        idBreaker: item.ID,
        departement: item.DEPARTMENT_CODE,
        temperatura: item.LAST_TEMP,
        consumo: (item.CONSUMPTION)/100,
        propietario: item.PROPERTY,
        fechaRegistro: item.RECORD_DATE,
    }));

    const rowStructure = ( item ) => `
        <td>${item.idBreaker}</td>
        <td>${item.departement}</td>
        <td>${item.temperatura}</td>
        <td>${item.consumo}</td>
        <td>${item.propietario}</td>
        <td>${item.fechaRegistro}</td>
        `;
    renderTable(currentPage, 'table-reports', rowStructure, data);
}

async function fetchDataFromPresets( numberCase ) {
    tbody.innerHTML = '<td colspan="6">Cargando...</td>'
    const fetchData = new FetchData();
    const response = await fetchData.getRecordsByPresets(numberCase);
    data = response.data.map((item, index) => ({
        idBreaker: item.ID,
        // id: item.ID,
        departement: item.DEPARTMENT_CODE,
        temperatura: item.LAST_TEMP,
        consumo: (item.CONSUMPTION)/100,
        propietario: item.PROPERTY,
        fechaRegistro: item.RECORD_DATE,
        // name: item.NAME,
    }));

    const rowStructure = ( item ) => `
        <td>${item.idBreaker}</td>
        <td>${item.departement}</td>
        <td>${item.temperatura}</td>
        <td>${item.consumo}</td>
        <td>${item.propietario}</td>
        <td>${item.fechaRegistro}</td>
        `;
    renderTable(currentPage, 'table-reports', rowStructure, data);
 }

export async function searchData(){

    let dateStart;
    let dateEnd;
    let departmentCode;
    let orderDate;
    let orderConsumption;

    dateStart = document.getElementById('date-start').value || null;
    dateEnd = document.getElementById('date-end').value || null;
    departmentCode = document.getElementById('breakerSearchInput').value || null;
    orderDate = document.querySelector('#orderByDate').value || null;
    orderConsumption = document.querySelector('#orderByConsumption').value || null;
    console.log(orderConsumption + ' - ' + orderDate + ' - ' + departmentCode);
    if(!dateVerification(dateStart, dateEnd)){
        console.log('error')
        return;
    }

    
    tbody.innerHTML = '<td colspan="6">Cargando...</td>';
    const fetchAPI = new FetchData();
    const response = await fetchAPI.getRecordsBySearch(dateStart, dateEnd, departmentCode, orderDate, orderConsumption)
    data = response.data.map((item, index) => ({
        idBreaker: item.ID,
        // id: item.ID,
        departement: item.DEPARTMENT_CODE,
        temperatura: item.LAST_TEMP,
        consumo: (item.CONSUMPTION)/100,
        propietario: item.PROPERTY,
        fechaRegistro: item.RECORD_DATE,
        // name: item.NAME,
    }));

    const rowStructure = ( item ) => `
        <td>${item.idBreaker}</td>
        <td>${item.departement}</td>
        <td>${item.temperatura}</td>
        <td>${item.consumo}</td>
        <td>${item.propietario}</td>
        <td>${item.fechaRegistro}</td>
        `;
    renderTable(currentPage, 'table-reports', rowStructure, data);

}

function dateVerification(dateStart, dateEnd){
    if(!dateStart || !dateEnd){
        simpleSweetAlert('center', 'Fecha inválida', 'warning', 'Por favor, rellena los campos', 1500)
        return false;
    }
    if(dateStart > dateEnd){
        simpleSweetAlert('center', 'Fecha inválida', 'warning', 'Selecciona un rango de fechas válido', 1500)
        return false;
    }
    return true;
}


function simpleSweetAlert(position, title, icon, text, timer){
    Swal.fire({
        position: position,
        icon: icon,
        title: title,
        text: text,
        showConfirmButton: false,
        timer: timer
    });
}

window.searchData = searchData;
window.fetchDataFromPresets = fetchDataFromPresets;

// Mostrar la tabla al cargar
// renderTable(currentPage);