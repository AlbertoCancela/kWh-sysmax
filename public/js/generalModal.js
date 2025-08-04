const modal = document.getElementById('generalModal');
function openGeneralModal( funct, data = null ) {
    modal.classList.add('show');
    const arrFunctions = {
        'setUserSettings': setUserSettings,
    };

    if (arrFunctions[funct]) {
        arrFunctions[funct](data);
    } else {
        console.warn(`Función "${funct}" no encontrada.`);
    }
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

// User Settings
function setUserSettings( data ){
    action = data.querySelectorAll('p')[1].getAttribute('modalType')
    const TITLE = document.querySelector('.generalModal-title');
    const CONTENT = document.querySelector('.generalModal-mainContent');
    TITLE.textContent = 'Configuración de usuario';
    var content = '';
    if(action == 'username'){
        const CURRENTUSERNAME = data.querySelectorAll('p')[1].getAttribute('pa-userName')
        content = `<div> <label id="userSetting-current">Actual:</label><i>${CURRENTUSERNAME}</i></div>
                    <div><label>Nuevo:</label><input id="username" class="newContent newUserName" type="text" placeholder="max. 15 caracteres"></div>`
    }else if (action == 'password'){
        content = `<div>
                        <label>Escribe tu contraseña</label><input type="password" placeholder="contraseña actual" id="currentPassword">
                    </div>
                    <div>
                        <label>Nueva contraseña</label><input class="newContent" type="password" placeholder="nueva contraseña" id="newPassword">
                        <span onclick="togglePassword('newPassword', this)" style="cursor: pointer; margin-left: 5px; color: var(--sysmax-blue)">mostrar contraseña</span>
                    </div>`
    }

    CONTENT.innerHTML = 
    `<div class="generalModal-userSetting-container">
        ${content}
        <button id="generalModal-button" onclick="applyUserChanges('${action}')">Aplicar Cambios</button>
    </div>`
    if(action == 'username'){
        document.addEventListener('input', function(e) {
        if (e.target.matches('input.newUserName')) {
            e.target.value = e.target.value
            .toLowerCase()
            .replace(/[^a-z0-9_\.]/g, '');
        }});
    }
}

function togglePassword(inputId, iconElement) {
    const input = document.getElementById(inputId);
    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    iconElement.textContent = isPassword ? 'ocultar contraseña' : 'mostrar contraseña'; // cambia el ícono
}

async function applyUserChanges( action ){
    var id = document.getElementById('settings-userName').getAttribute('pa-id');
    var newValue = document.querySelector('.newContent').value;
    // console.log(newValue)
    switch(action){
        case 'username':
            var isEmpty = !newValue ? 'Por favor, rellena el campo requerido' : false;
            var lengthLimit = newValue.length > 15 ? 'Límite de caracteres alcanzado (15)' : false;
            var message =  isEmpty ? isEmpty : lengthLimit ? lengthLimit : false
            if(message){
                Swal.fire({
                    title: "Límite de caracteres",
                    text: `${message}`,
                    icon: "warning",
                    timer: 1600,
                    timerProgressBar: true
                });
            }else{
                Swal.fire({
                    title: "¿Estás seguro/a?",
                    text: "Tu inicio de sesión será con este nuevo nombre de usuario",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Cambiar",
                    cancelButtonText: "Cancelar"
                    }).then( async (result) => {
                    if (result.isConfirmed) {
                        var response = await changeUserName(id, newValue)
                        if(response.status === 'ok'){
                            Swal.fire({
                            title: "Hecho!",
                            text: "Se han guardado los cambios. Es necesario reiniciar.",
                            icon: "success"
                            }).then(()=>{
                                closeSession()
                                window.location('/src')
                            });
                        }
                    }
                });
            }

            break;
        case 'password':
            var currentPassword = document.getElementById('currentPassword').value 
            var newPassword = document.getElementById('newPassword').value
            var username = document.getElementById('settings-userName').getAttribute('pa-userName');
            const VERIFICATION = await verifyPassword(username, currentPassword);

            if((VERIFICATION.result).length != 1){
                Swal.fire({
                    title: "Error",
                    text: `La contraseña (actual) introducida es incorrecta.`,
                    icon: "error",
                    timer: 1600,
                    timerProgressBar: true
                });
            }else{
                Swal.fire({
                    title: "¿Estás seguro/a?",
                    text: "Tu inicio de sesión será con esta nueva contraseña. Asegúrate de guardar tus credenciales y no compartirlas.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Cambiar",
                    cancelButtonText: "Cancelar"
                    }).then( async (result) => {
                    if (result.isConfirmed) {
                        var response = await changePassword(username, newPassword)
                        if(response.status === 'ok'){
                            Swal.fire({
                            title: "Hecho!",
                            text: "Se han guardado los cambios. Es necesario reiniciar.",
                            icon: "success"
                            }).then(()=>{
                                closeSession()
                                window.location('/src')
                            });
                        }
                    }
                });
            }
            break;
    }
}



// window.abrirModal = openGeneralModal;
