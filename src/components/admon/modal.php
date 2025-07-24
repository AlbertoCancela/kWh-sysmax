<!-- Modal -->
 
<div id="miModal" class="modal">
    <div class="modal-content">
        <!-- <span class="close-btn" onclick="cerrarModal()">&times;</span> -->
        <section class="modal-data">
            <div class="modal-section title">
                <h2 id="modal-data-breakerName">Data</h2>
                <h4 id="modal-data-breakerId">...</h4>
            </div>
            <hr>
            <div class="modal-section data">
                <div class="reference-data">
                    <p class="reference-data-text">Usuario: 
                        <i id="modal-data-user" class="modal-fetch-data">...</i>
                    </p>
                    <p class="reference-data-text">Departamento: 
                        <i id="modal-data-department" class="modal-fetch-data">...</i>
                    </p>
                </div>
                <div class="main-data">
                    <div class="main-data-TKS">
                        <h3>Temp</h3>
                        <i class='bx bxs-thermometer bx-md'></i>
                        <b id="modal-data-temp" class="modal-fetch-data">...</b>
                    </div>
                    <div class="main-data-TKS">
                        <h3>kWh</h3>
                        <i class='bx bx-tachometer bx-md'></i>
                        <b id="modal-data-kwh" class="modal-fetch-data">...</b>
                    </div>
                    <div class="main-data-TKS">
                        <h3>Estado</h3>
                        <i class='bx bx-power-off bx-md'></i>
                        <div id="statusContainer" class="status-toggle">
                            <label class="switch">
                                <input type="checkbox" id="breakerToggle">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-section records">
                <table class="modal-table_records">
                    <thead>
                        <th>Consumo</th>
                        <th>Temperatura</th>
                        <th>Fecha de registro</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3">Consultando datos, espere un momento...</td>
                        </tr>

                        <!-- <tr>
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
                        </tr> -->
                        
                    </tbody>
                </table>
            </div>
            <a id="modal-data-buttonToReports" href=""> Generar reporte </a>
        </section>
    </div>
</div>