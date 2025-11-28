export class APIClient {
    constructor(baseURL) {
        this.baseURL = baseURL;
    }

    async request(endpoint, method = "GET", data = null) {
        const url = `${this.baseURL}${endpoint}`;
        const options = {
            method,
            headers: {
                "Content-Type": "application/json"
            }
        };
        if (data && method !== "GET" && method !== "DELETE") {
            options.body = JSON.stringify(data);
        }

        const response = await fetch(url, options);
        if (!response.ok) {
            const error = await response.json().catch(() => ({}));
            throw new Error(error.error || `Error HTTP ${response.status}`);
        }
        return await response.json();
    }

    get(endpoint) { return this.request(endpoint, "GET"); }
    post(endpoint, data) { return this.request(endpoint, "POST", data); }
    put(endpoint, data) { return this.request(endpoint, "PUT", data); }
    delete(endpoint) { return this.request(endpoint, "DELETE"); }
}
