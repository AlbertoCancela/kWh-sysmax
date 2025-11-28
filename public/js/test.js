import { FetchData } from "../sysmax-api/fetchAPI.js";

let response = new FetchData().getLastRecords();
console.log(response)