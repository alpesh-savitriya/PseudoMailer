import axios from 'axios';

export const HTTP = axios.create({
    baseURL: process.env.ROOT_API, //`http://pseudomailer.com/api/v1/`,
    headers: {
        "Content-Type": "application/json"
    }
});