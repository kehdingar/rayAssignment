import axios from "axios"

const instance = axios.create({
    baseURL: "http://localhost:81/src/Controller/"
})
export default instance