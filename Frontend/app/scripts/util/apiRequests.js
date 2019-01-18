const axios = require('axios');

const baseUrl = "api.farmsim.localhost";

global.axiosInstance = axios.create({
    baseURL: 'baseUrl',
    //timeout: 1000,
    headers: {'Accept': 'application/json,text/plain,*/*'}
});


function getFarm(userId){
    global.axiosInstance.get("/users/"+userId)
        .then((response)  =>  {
            return response.data;
        }, (error)  =>  {
            return false;
        });
}
