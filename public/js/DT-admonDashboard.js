import { PHPFetcher } from './handler_DOM.js';
import { renderTable } from './dataTable.js';
import { FetchData } from '../sysmax-api/fetchAPI.js';
let currentPage = 1;
let data = [];

document.addEventListener('DOMContentLoaded', async () => {
    fetchDataFromBackend();
});

async function fetchDataFromBackend() {
    // const myVariable = new PHPFetcher('/backend/controller/');
    // const response = await myVariable.fetchData('breakers.php', { query: 'ssfb', action: 'getAllBreakersD'}, 'POST');
    const data = (await new FetchData().getLastRecords()).data;
    const records = data.map((item, index) => ({
        id: item.ID,
        departement: item.DEPARTMENT_CODE,
        name: item.NAME,
        consumo: (item.CONSUMPTION)/100 + ' kWh',
        temperatura: item.LAST_TEMP + '°C',
        fechaRegistro: item.RECORD_DATE,
        propietario: item.PROPERTY,
        idBreaker: item.ID
    }));

    // console.log(records)

    const rowStructure = ( item ) => `
        <td>${item.departement}</td>
        <td>${item.name}</td>
        <td>${item.consumo}</td>
        <td>${item.temperatura}</td>
        <td>${item.fechaRegistro}</td>
        <td>${item.propietario}</td>
        <td>
            <button onclick="abrirModal(this)" class="dashboard-showDetails" IdBreaker="${item.idBreaker}">
            <i class='bx bx-file bx-sm'></i>
            </button>
        </td>`;
    renderTable(currentPage, 'table-breakerDisplay', rowStructure, records);
}




// Mostrar la tabla al cargar
// renderTable(currentPage);