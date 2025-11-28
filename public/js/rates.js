import { FetchData } from "../sysmax-api/fetchAPI.js";

async function updateRate(){
    const fetchAPI = new FetchData();
    const newRate = document.getElementById('newRate').value;
    if(newRate && !isNaN(Number(newRate))){
        const response = await fetchAPI.updateRateValue(newRate, 1);
        if(response.success){
            window.location.reload();
        }
    }
} 

function printRate( element ) {
    const finalRate = element.getAttribute('data-rateValue');
    const owner = element.getAttribute('data-rateOwner');
    const breaker = element.getAttribute('data-rateBreakerName');
    console.log(finalRate + ' - ' + owner + ' - ' + breaker)
    fetch('/backend/documentGenerator/pdf/pdfGenerator.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            finalRate: finalRate,
            owner: owner,
            breaker: breaker
        })
    })
    .then(response => response.blob()) // Recibir el PDF como archivo binario
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        window.open(url, '_blank'); // Abre el PDF generado en una nueva pestaña
    })
    .catch(error => console.error('Error generando PDF:', error));
}

const printRateByTimeAndId = async (id, dateStart = null, dateEnd = null) => {
    let response = await getBreakerConsumption(id, dateStart, dateEnd);

    const rate = await getRateValue(1);
    const rate_value = rate.breakers[0].RATE_VALUE;
    // const rate_updateat = rate.breakers[0].UPDATE_AT;

    // console.log(rate_value + '*' + response.breakers[0]['CONSUMPTION']/100)
    const finalRate = (parseFloat(response.breakers[0]['CONSUMPTION']/100) * rate_value).toFixed(2);
    const owner = response.breakers[0]['B_OWNER'];
    const breaker = response.breakers[0]['DEVICE_NAME'];

    // console.log(response);
    fetch('/backend/documentGenerator/pdf/pdfGenerator.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            finalRate: finalRate,
            owner: owner,
            breaker: breaker
        })
    })
    .then(response => response.blob()) // Recibir el PDF como archivo binario
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        window.open(url, '_blank'); // Abre el PDF generado en una nueva pestaña
    })
    .catch(error => console.error('Error generando PDF:', error));
}

window.updateRate = updateRate;
window.printRate = printRate;
window.printRateByTimeAndId = printRateByTimeAndId;