//userSettings
const userSettingActions = {
    'userName': async (id, value) => await changeUserName(id, value),
    'name': async (id, value) => await changeName(id, value), // ejemplo
    'email': async (id, value) => await changeEmail(id, value),
};

function setUserSettings(data) {
    const element = data.querySelectorAll('p')[1];
    const actionType = element.getAttribute('modalType');
    const actionId = element.getAttribute('id');

    const TITLE = document.querySelector('.generalModal-title');
    const CONTENT = document.querySelector('.generalModal-mainContent');
    TITLE.textContent = 'Configuración de usuario';

    let content = '';

    if (actionType === 'simplechange') {
        const allowedFields = {
            'settings-userName': 'userName',
            'settings-name': 'name',
            'settings-email': 'email',
        };

        var attribute = allowedFields[actionId];
        const currentValue = element.getAttribute(`pa-${attribute}`);

        content = generateSimpleChangeContent(currentValue);
    } else if (actionType === 'password') {
        content = generatePasswordChangeContent();
    }

    CONTENT.innerHTML = `
        <div class="generalModal-userSetting-container">
            ${content}
            <button id="generalModal-button" onclick="applyUserChanges('${actionType}', '${attribute}')">Aplicar Cambios</button>
        </div>
    `;
}

function generateSimpleChangeContent(currentValue) {
    return `
        <div>
            <label id="userSetting-current">Actual:</label><i>${currentValue}</i>
        </div>
        <div>
            <label>Nuevo:</label>
            <input id="username" class="newContent" type="text" placeholder="max. 32 caracteres">
        </div>
    `;
}

function generatePasswordChangeContent() {
    return `
        <div>
            <label>Escribe tu contraseña</label>
            <input type="password" placeholder="contraseña actual" id="currentPassword">
        </div>
        <div>
            <label>Nueva contraseña</label>
            <input class="newContent" type="password" placeholder="nueva contraseña" id="newPassword">
            <span onclick="togglePassword('newPassword', this)" style="cursor: pointer; margin-left: 5px; color: var(--sysmax-blue)">mostrar contraseña</span>
        </div>
    `;
}

function togglePassword(inputId, iconElement) {
    const input = document.getElementById(inputId);
    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    iconElement.textContent = isPassword ? 'ocultar contraseña' : 'mostrar contraseña';
}

async function applyUserChanges(action, fieldToChange) {
    console.log(fieldToChange)
    const id = document.getElementById('settings-userName').getAttribute('pa-id');
    const username = document.getElementById('settings-userName').getAttribute('pa-userName');

    if (action === 'simplechange') {
        const newValue = document.querySelector('.newContent').value.trim();
        const errorMessage = validateSimpleChange(newValue);

        if (errorMessage) return showWarning('Límite de caracteres', errorMessage);

        const confirmed = await confirmChange(
            '¿Estás seguro/a?',
            'Tu inicio de sesión será con este nuevo nombre de usuario'
        );

        if (confirmed) {
            const updateFn = userSettingActions[fieldToChange]
            const response = await updateFn(id, newValue);
            console.log(response)
            // if (response.status === 'ok') return successAndReload();
        }

    } else if (action === 'password') {
        const currentPassword = document.getElementById('currentPassword').value;
        const newPassword = document.getElementById('newPassword').value;

        const verification = await verifyPassword(username, currentPassword);

        if (!verification.result || verification.result.length !== 1) {
            return showWarning('Error', 'La contraseña (actual) introducida es incorrecta.');
        }

        const confirmed = await confirmChange(
            '¿Estás seguro/a?',
            'Tu inicio de sesión será con esta nueva contraseña. Asegúrate de guardar tus credenciales y no compartirlas.'
        );

        if (confirmed) {
            const response = await changePassword(username, newPassword);
            if (response.status === 'ok') return successAndReload();
        }
    }
}

function validateSimpleChange(value) {
    if (!value) return 'Por favor, rellena el campo requerido';
    if (value.length > 32) return 'Límite de caracteres alcanzado (32)';
    return null;
}

function showWarning(title, message) {
    Swal.fire({
        title,
        text: message,
        icon: "warning",
        timer: 1600,
        timerProgressBar: true
    });
}

async function confirmChange(title, text) {
    const result = await Swal.fire({
        title,
        text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Cambiar",
        cancelButtonText: "Cancelar"
    });
    return result.isConfirmed;
}

function successAndReload() {
    Swal.fire({
        title: "Hecho!",
        text: "Se han guardado los cambios. Es necesario reiniciar.",
        icon: "success"
    }).then(() => {
        closeSession();
    });
}