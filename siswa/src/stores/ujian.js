import {
    $api
} from "@/api";
import {
    defineStore
} from "pinia";

export const useUjianStore = defineStore('ujian_store', {
   state : ()=>{
    return {
        response : null,
        userLogin:false,
        loading : false,
    }
   },
    actions: {
        async konfirmasi(data) {
           return await $api.post('/siswa/ujian/konfirmasi', data);
        }
    },
});