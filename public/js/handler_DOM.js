export class PHPFetcher {
    constructor(baseUrl = '') {
        this.baseUrl = baseUrl
    }

    async fetchData(scriptName, data = {}, method = 'POST') {
        return this.#send(scriptName, method, data)
    }

    async #send(scriptName, method, data) {
        const url = `${this.baseUrl}${scriptName}`
        const response = await fetch(url, {
        method,
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
        });
        if (!response.ok) throw new Error(`${method} error: ${response.status}`)
        return await response.json()
    
    }
}

// const myVariable = new PHPFetcher('http://localhost:8000/backend/tuyaApi/')
// const RESPONSE = await myVariable.fetchData('tuyaGetSingleBreaker.php', {deviceId: '65e6a732254c5669aceikp'}, 'POST')

// console.log(RESPONSE)