document.getElementById('login-login').addEventListener("submit", ( event )=>{
    event.preventDefault(); 

    const form = event.target;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    data['action'] = 'startSession';
    
    fetch('../backend/controller/sessions.php', {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then( response => response.json() )
    .then( response => {
        if(response.status == 'ok'){
            alert("sesión iniciada")
            location.href="/kWh-sysmax/src";
        }else{
            console.log(response)
            document.getElementById('spanLogin').classList.remove('hidden');
        }
    })
});
