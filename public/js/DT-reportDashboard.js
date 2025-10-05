import { PHPFetcher } from './handler_DOM.js';
import { renderTable } from './dataTable.js';

let currentPage = 1;
let data = [];

document.addEventListener('DOMContentLoaded', () => {
    fetchDataFromBackend();
});

async function fetchDataFromBackend() {    
    const myVariable = new PHPFetcher('/kWh-sysmax/backend/controller/');
    let queryAdditions = " WHERE r.RECORD_DATE BETWEEN DATE('now', '-15 day') AND DATE('now') ORDER BY r.RECORD_DATE DESC";
    const response = await myVariable.fetchData('breakers.php', { query: 'ssfrjo', addition: queryAdditions,action: 'getRecordsToReport'}, 'POST');
    data = response.breakers.map((item, index) => ({
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

async function fetchDataFromPresets( data ) {  
    const myVariable = new PHPFetcher('/kWh-sysmax/backend/controller/');
    const preset = data.getAttribute('presetQuery');
    let queryAdditions = '';
    switch( preset ){
        case 'safbsl15':
            queryAdditions = " WHERE r.RECORD_DATE BETWEEN DATE('now', '-15 day') AND DATE('now') GROUP BY r.ID_BREAKER ORDER BY r.RECORD_DATE DESC";
            break;
        case 'sasbtcgb':
            queryAdditions = " GROUP BY r.ID_BREAKER";
            break;
        case 'sabsgbd':
            queryAdditions = " GROUP BY r.ID_BREAKER ORDER BY CONSUMPTION ASC";
            break;
        case 'sabtcy':
            queryAdditions = " WHERE r.RECORD_DATE = DATE('now', '-1 day')";
            break;
    }

    const response = await myVariable.fetchData('breakers.php', { query: 'ssfrjoaf', addition: queryAdditions, action: 'getRecordsToReport'}, 'POST');
    data = response.breakers.map((item, index) => ({
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
    let dateStart = document.getElementById('date-start').value;
    let dateEnd = document.getElementById('date-end').value;
    if(!dateVerification(dateStart, dateEnd)){
        console.log('error')
        return;
    }
    let queryAdditions = ` WHERE r.RECORD_DATE BETWEEN '${dateStart}' AND '${dateEnd}' `;
    let specificSearch = document.getElementById('breakerSearchInput').value;
    if(specificSearch){
        queryAdditions += ` AND d.DEPARTMENT_CODE = '${specificSearch}' `;
    }

    let orderByDate = document.querySelector('#orderByDate').value;
    let orderByConsumption = document.querySelector('#orderByConsumption').value;
    
    const validDir = new Set(['ASC', 'DESC']);
    const orderParts = [];

    if (validDir.has(orderByDate)) {
        orderParts.push(`r.RECORD_DATE ${orderByDate}`);
    }
    if (validDir.has(orderByConsumption)) {
        orderParts.push(`r.KWH ${orderByConsumption}`);
    }

    if (orderParts.length > 0) {
        queryAdditions += ` ORDER BY ${orderParts.join(', ')}`;
    }
    
    
    const myVariable = new PHPFetcher('/kWh-sysmax/backend/controller/');
    const response = await myVariable.fetchData('breakers.php', { query: 'ssfrjo', addition: queryAdditions,action: 'getRecordsToReport'}, 'POST');
    data = response.breakers.map((item, index) => ({
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