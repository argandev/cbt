import {
    $api
} from "@/api";
import {
    defineStore
} from "pinia"
export const useJadwalStore = defineStore('jadwal_store', {
    state: () => {
        return {
            loadingGetData: true,
            available: {}
        }
    },
    actions: {
        async getDetailJadwal(jadwal_id) {
            try {
                const response = await $api.post('/siswa/detail_jadwal', {
                    jadwal_id: jadwal_id,
                });
                this.loadingGetData = false;
                if (response.status == 200 && response.data.error == false) {
                    this.available = response.data;
                }
            } catch (error) {
                if(error.response.data.error) {
                    this.available = error.response.data;

                }
            }
        },
        async getJadwalSekarang() {
            try {
                const response = await $api.get('/siswa/get_jadwal');

                this.loadingGetData = false;
                if (response.status == 200 && response.data.error == false) {
                    this.available = response.data;
                }
            } catch (error) {
                this.available = error;
                this.loadingGetData = false;
            }
        }
    }
});