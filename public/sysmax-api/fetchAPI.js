import { APIClient } from './classRequest.js';

const BASE_URL =
    window.location.hostname === "localhost"
        ? "http://localhost:8080/sysmax/"
        : "";


export class FetchData{
    api = new APIClient(BASE_URL);
    getSysmaxUser( id ){
        return this.api.get("user/"+id);    
    }
    
    getLastRecords(){
        return this.api.get("records/lastrecords");
    }

    getRateValue( id ){
        return this.api.get("rates/getratevalue/"+id);
    }

    getRecordsByPresets( presetCase ){
        return this.api.get("records/recordsbypreset/"+presetCase);
    }
    
    getRecordsToRates(){
        return this.api.get("records/recordstorates");
    }

    getBreakerMainUserData( breakerId ){
        return this.api.post("breakers/breakermainuserdata", {
            breakerId: breakerId
        });
    }
    getLastRecordsByBreaker(breakerId, numberRecords){
        return this.api.post("records/recordsbybreaker", {
            breakerId: breakerId,
            numberRecords: numberRecords,
        });
    }
    getRecordsBySearch(...args){
        return this.api.post("records/recordsbysearch", {
            date_start: args[0],
            date_end: args[1],
            dpto_code: args[2],
            order_date: args[3],
            order_consumption: args[4]
        });
    }

    updateRateValue( newValue, rateId = NULL){
        return this.api.put("rates/setratevalue", {
            newRate: newValue,
            rateId: rateId,
        });
    }

    async NRverification(email, eventId){
        this.api.post("/attendance/NRverification", {
            email: email,
            eventId: eventId,
        }).then(console.log);
    }
    async verifyToken(eventId, email, token){
        return await this.api.post("/attendance/verifyToken", {
            eventId: eventId,
            email: email,
            token: token
        });
    }
}