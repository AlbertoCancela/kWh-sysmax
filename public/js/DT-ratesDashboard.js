import { PHPFetcher } from './handler_DOM.js';
import { renderTable } from './dataTable.js';

let currentPage = 1;
let data = [];

document.addEventListener('DOMContentLoaded', () => {
    fetchDataFromBackend();
});

async function fetchDataFromBackend() {
    const rate = await getRateValue(1);
    const rate_value = rate.breakers[0].RATE_VALUE;
    const rate_updateat = rate.breakers[0].UPDATE_AT;
    
    document.getElementById('p-rateValue').innerHTML = rate_value
    document.getElementById('p-rateDate').innerHTML = rate_updateat.split(' ')[0]


    const myVariable = new PHPFetcher('/kWh-sysmax/backend/controller/');
    const response = await myVariable.fetchData('breakers.php', { query: 'ssfb', action: 'getAllBreakersD'}, 'POST');
    data = response.breakers.map((item, index) => ({
        id: item.ID,
        departement: item.DEPARTMENT_CODE,
        name: item.NAME,
        consumo: (item.CONSUMPTION)/100 + ' kWh',
        temperatura: item.LAST_TEMP + '°C',
        fechaRegistro: item.RECORD_DATE,
        propietario: item.PROPERTY,
        idBreaker: item.ID
    }));

    const rowStructure = ( item ) => `
        <td>${item.name}</td>
        <td>${item.consumo}</td>
        <td>$ ${(parseFloat(item.consumo) * rate_value).toFixed(2)}</td>
        <td class="content-center hover:cursor-pointer" data-id="${item.id}">
            <img onclick="printRate(this)" 
            class="h-10 w-10" 
            src="/kWh-sysmax/public/img/pdfPngRetro.png" alt=""
            data-rateOwner="${item.propietario}" 
            data-rateBreakerName="${item.name}" 
            data-rateValue="${(parseFloat(item.consumo) * rate_value).toFixed(2)}
            ">
        </td>
        `;
    renderTable(currentPage, 'table-rates', rowStructure, data);
}




// Mostrar la tabla al cargar
// renderTable(currentPage);