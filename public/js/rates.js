async function updateRate(){
    const newRate = document.getElementById('newRate').value;
    // console.log(!isNaN(Number(newRate)))
    if(newRate && !isNaN(Number(newRate))){
        const res = await updateRateValue(newRate, 1);
        if(res.status == 'ok'){
            window.location.reload();
        }
    }
} 

function printRate( element ) {
    const finalRate = element.getAttribute('data-rateValue');
    const owner = element.getAttribute('data-rateOwner');
    const breaker = element.getAttribute('data-rateBreakerName');
    fetch('../../backend/documentGenerator/pdf/pdfGenerator.php', {
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