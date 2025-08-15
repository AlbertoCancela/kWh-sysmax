const modal = document.getElementById('generalModal');
function openGeneralModal( funct, data = null ) {
    console.log(funct)
    modal.classList.add('show');
    const arrFunctions = {
        setUserSettings: (typeof setUserSettings === 'function') ? setUserSettings : undefined,
        singleReport: (typeof singleReport === 'function') ? singleReport : undefined
    };

    if (arrFunctions[funct]) {
        arrFunctions[funct](data);
    } else {
        console.warn(`Función "${funct}" no encontrada.`);
    }
}

function singleReport() {
  const TITLE = document.querySelector('.generalModal-title');
  const CONTENT = document.querySelector('.generalModal-mainContent');

  TITLE.textContent = 'test';

  CONTENT.innerHTML = `
    <div style="width:100%" class="generalModal-userSetting-container">
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
      <div class="class="modal-section records"">
        <table class="modal-table_records singleReport">
            <thead>
                <th>Consumo (kWh)</th>
                <th>Temperatura (°C)</th>
                <th>Fecha de registro</th>
            </thead>
            <tbody>
                <tr>
                    <td>5.15kwh</td>
                    <td>17°C</td>
                    <td>2025-07-22 22:25:02</td>
                </tr>

                <tr>
                    <td>5.15kwh</td>
                    <td>17°C</td>
                    <td>2025-07-22 22:25:02</td>
                </tr>

                <tr>
                    <td>5.15kwh</td>
                    <td>17°C</td>
                    <td>2025-07-22 22:25:02</td>
                </tr>

                <tr>
                    <td>5.15kwh</td>
                    <td>17°C</td>
                    <td>2025-07-22 22:25:02</td>
                </tr>
                <tr>
                    <td>5.15kwh</td>
                    <td>17°C</td>
                    <td>2025-07-22 22:25:02</td>
                </tr>
                <tr>
                    <td>5.15kwh</td>
                    <td>17°C</td>
                    <td>2025-07-22 22:25:02</td>
                </tr>
            </tbody>
        </table>
      </div>
      <button id="generalModal-button" type="button">Descargar</button>
    </div>
  `;
}


function closeGeneralModal() {
    modal.classList.remove('show');
}


window.onclick = function(e) {
    if (e.target === modal) {
    closeGeneralModal();
    }
}

window.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeGeneralModal();
    }
});





// window.abrirModal = openGeneralModal;
