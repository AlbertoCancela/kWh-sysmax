import { getSingleBreakerData } from "/../public/js/general.js";

const modal = document.getElementById('miModal');
const toggle = document.getElementById('breakerToggle');

async function abrirModal(data) {
    modal.classList.add('show');
    if(data){

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
}


toggle.addEventListener('change', async () => {
  const newState = toggle.checked; // true o false
  console.log("Nuevo estado:", newState);

  // Aquí puedes llamar a tu API o backend para actualizar
  // await updateBreakerState(BREAKER_ID, newState);
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
