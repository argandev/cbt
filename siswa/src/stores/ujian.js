import {
    $api
} from "@/api";
import {ref} from 'vue'
import {
    defineStore
} from "pinia";

export const useUjianStore = defineStore('ujian_store', {
   state : ()=>{
    return {
        jawaban_siswa : ref(null),
        response : null,
        userLogin:false,
        loading : false,
    }
   },
    actions: {
       //exam confirmaiton
        async konfirmasi(data) {
           return await $api.post('/siswa/ujian/konfirmasi', data);
        },
        async getJawabanSiswa(ujian_id){
            this.loading = true;
           try {
               const response =  await $api.get( "/siswa/ujian/jawaban_siswa?jadwal_id="+ujian_id);
               if ( response.status==200 && response.data.data.error==false ) {
                   this.loading = false;
                   this.jawaban_siswa.value = response.data;
               } else{
                   this.jawaban_siswa.value = {};
                   this.loading.value = false;
               }
           }catch(e){
               this.loading = false;
           }
        }
    },
});