const modal = document.getElementById('generalModal');
function openGeneralModal( funct, data = null ) {
    // console.log(funct)
    modal.classList.add('show');
    const arrFunctions = {
        setUserSettings: (typeof setUserSettings === 'function') ? setUserSettings : undefined,
        singleReport: (typeof singleReport === 'function') ? singleReport : undefined
    };
    if (arrFunctions[funct]) {
        arrFunctions[funct](data.getAttribute('idBreaker'));
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





// window.abrirModal = openGeneralModal;
