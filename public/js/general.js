import { PHPFetcher } from './handler_DOM.js'

export function closeSession(){
    const data = {"action": "closeSession"}
    fetch('../backend/controller/sessions.php', {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then( response => response.text() )
    .then( response => {
        if(response){
            alert("sesión cerrada")
            location.reload() //href="index.php";
        }
    })
}

export async function getSingleBreakerData( $breakerId ){
    const FETCHER = new PHPFetcher('http://localhost:8000/backend/tuyaApi/')
    const RESPONSE = await FETCHER.fetchData('tuyaGetSingleBreaker.php', { deviceId: $breakerId }, 'POST')
    return RESPONSE;
}