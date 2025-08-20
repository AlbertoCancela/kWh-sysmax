import { PHPFetcher } from './handler_DOM.js';
import { renderTable } from './dataTable.js';

let currentPage = 1;
let data = [];

function singleReport( data ) {
    const TITLE = document.querySelector('.generalModal-title');
    const CONTENT = document.querySelector('.generalModal-mainContent');

    TITLE.textContent = 'test';
    console.log(data)
    CONTENT.innerHTML = `
        <div style="width:100%;" class="generalModal-userSetting-container">
            <div style="display: flex; flex-direction: row; gap:.6em">
                <div style="flex: 1">
                    <label>Desde:</label>
                    <input style="width:100%" id="" class="" type="date" placeholder="max. 32 caracteres">
                </div>
                <div style="flex: 1">
                    <label>Hasta:</label>
                    <input style="width:100%" id="" class="" type="date" placeholder="max. 32 caracteres">
                </div>
            </div>
        <div class="modal-section records" style="height: 26em; max-height: 26em; overflow: scroll;">
            <table id="table-singleBreaker-reports" class="modal-table_records singleReport">
                <thead>
                    <th>Consumo (kWh)</th>
                    <th>Temperatura (°C)</th>
                    <th>Fecha de registro</th>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
            
            </div>
                <div style="display:flex; flex-direction:row;" id="pagination"></div>
                <button id="generalModal-button" type="button">Descargar</button>
            </div>
    `;
    fetchSingleBreakerData( data );
}

async function fetchSingleBreakerData( idBreaker ) {
    const myVariable = new PHPFetcher('/kWh-sysmax/backend/controller/');
    let queryAdditions = ` WHERE r.ID_BREAKER = '${idBreaker}' AND r.RECORD_DATE BETWEEN DATE('now', '-15 day') AND DATE('now') ORDER BY r.RECORD_DATE DESC`;
    const response = await myVariable.fetchData('breakers.php', { query: 'ssfrjo', addition: queryAdditions,action: 'getRecordsToReport'}, 'POST');
    data = response.breakers.map((item, index) => ({
        temperatura: item.LAST_TEMP,
        consumo: (item.CONSUMPTION)/100,
        fechaRegistro: item.RECORD_DATE,
    }));

    const rowStructure = ( item ) => `
        <td>${item.consumo}</td>
        <td>${item.temperatura}</td>
        <td>${item.fechaRegistro}</td>
        `;
    renderTable(currentPage, 'table-singleBreaker-reports', rowStructure, data);
}

window.singleReport = singleReport;