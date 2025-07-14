import { PHPFetcher } from './handler_DOM.js'

export async function getSingleBreakerData( $breakerId ){
    const FETCHER = new PHPFetcher('http://localhost:8000/backend/tuyaApi/')
    const RESPONSE = await FETCHER.fetchData('tuyaGetSingleBreaker.php', { deviceId: $breakerId }, 'POST')
    return RESPONSE;
}
