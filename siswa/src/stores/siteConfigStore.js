import moment from "moment";
import { defineStore } from "pinia";

export const useSiteConfigStore = defineStore('site_config',()=>{
    const site_name = "ArganCBT V0.1";
    const site_copyright = moment().format('Y')+' ARGANDEV';
    const API_ENDPOINT = "http://localhost:8000/api";
    return {
        site_copyright,
        site_name,
        API_ENDPOINT,
    }
})