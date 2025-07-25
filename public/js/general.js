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
            location.reload()
        }
    })
}

export async function switchBreakerStatus(breakerid, status){
    const FETCHER = new PHPFetcher('../backend/tuyaApi/');
    const RESPONSE = await FETCHER.fetchData('tuyaSwitchStatus.php', {status: status, breakerid: breakerid}, 'POST');
    return (RESPONSE);
}

export async function getSingleBreakerRecords(breakerId) { //From Sql
    const FETCHER = new PHPFetcher('../backend/controller/');
    const RESPONSE = await FETCHER.fetchData('breakers.php', { query: 'safrW-bIdL7', query2: 'ssfbW-bId', params:{id_breaker: breakerId}, action: 'getSingleBreakerD'}, 'POST');
    return (RESPONSE);
}

export async function getSingleBreakerData( $breakerId ){ //From tuya
    const FETCHER = new PHPFetcher('../backend/tuyaApi/')
    const RESPONSE = await FETCHER.fetchData('tuyaGetSingleBreaker.php', { deviceId: $breakerId }, 'POST')
    return RESPONSE;
}