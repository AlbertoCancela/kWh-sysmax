import { getSingleBreakerData, getSingleBreakerRecords, switchBreakerStatus } from "../public/js/general.js";

const modal = document.getElementById('miModal');
const toggle = document.getElementById('breakerToggle');

async function abrirModal(data) {
    modal.classList.add('show');
    if(data){
        const BREAKERID = data.getAttribute('idBreaker');
        var modalData = await getSingleBreakerRecords(BREAKERID);
        sessionStorage.setItem('breakerid', BREAKERID);
        fillModalBreakerData(modalData['records'],modalData['breakerData'][0])
        fillModalMainData(data);
    }
}

function fillModalBreakerData(breakerRecords, breakerData){
    const BREAKERNAME = document.getElementById('modal-data-breakerName');
    const BREAKERID = document.getElementById('modal-data-breakerId');
    const USER = document.getElementById('modal-data-user');
    const DEPARTMENT = document.getElementById('modal-data-department');
    const TABLE = document.querySelector('.modal-table_records')

    BREAKERNAME.textContent = breakerData['DEVICE_NAME']
    BREAKERID.textContent = breakerData['ID']
    USER.textContent = breakerData['USERNAME']
    DEPARTMENT.textContent = breakerData['DEPARTMENT_CODE']

    var tdArr = '';
    breakerRecords.forEach( record => {
        tdArr += `<tr><td>${record['KWH']/100} kWh</td><td>${record['TEMP']}</td><td>${record['RECORD_DATE']}</td></tr>` 
    })
    TABLE.querySelector('tbody').innerHTML = tdArr;
}

async function fillModalMainData(data){
    const KWH = document.querySelector('#modal-data-kwh')
    // const STATUS = document.getElementById('statusContainer');
    const TEMP = document.querySelector('#modal-data-temp')
    
    KWH.textContent = '...'
    TEMP.textContent = '...'
    toggle.checked = false;

    const BREAKER_ID = data.getAttribute('idBreaker')
    const RESPONSE = await getSingleBreakerData(BREAKER_ID)    
    KWH.textContent = `${(RESPONSE.total_forward_energy)/100}`;
    TEMP.textContent = `${RESPONSE.temp_current} °C`;
    toggle.checked = RESPONSE.switch === true;  
}

toggle.addEventListener('change', async () => {
    const newState = toggle.checked; // true o false
    const BREAKERID = sessionStorage.getItem('breakerid')
    console.log("Nuevo estado:", BREAKERID);
    Swal.fire({
        title: "Confirmación",
        text: `Deseas cambiar el estado de break a ${newState == true ? 'Encendido' : 'Apagado'}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: `${newState == true ? 'Encender' : 'Apagar'}`
    }).then(async (result) => {
        if (result.isConfirmed) {
            const RESPONSE = await switchBreakerStatus(BREAKERID, newState);
            if(RESPONSE.success){
                Swal.fire({
                title: `${newState == true ? 'ENCENDIDO' : 'APAGADO'}`,
                text: `El dispositivo ha sido ${newState == true ? 'encendido' : 'apagado'}`,
                icon: "success"
                });
            }else{
                Swal.fire({
                title: `Error`,
                text: `No ha sido posible establecer conexión con el dispositivo`,
                icon: "error"
                });
            }
        }else{
            toggle.checked = !newState;
        }
    });
    
});


function cerrarModal() {
    modal.classList.remove('show');
}

window.onclick = function(e) {
    if (e.target === modal) {
    cerrarModal();
    }
}

window.abrirModal = abrirModal;
