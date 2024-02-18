<script setup>
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import { onMounted, ref } from 'vue';
import InputText from 'primevue/inputtext';

import { useJadwalStore } from '@/stores/jadwal';
import { useRoute } from 'vue-router';
import router from '@/router'
import timezone from 'moment-timezone'
import Book2 from '@/components/icons/Book2.vue'
import { useUjianStore } from '@/stores/ujian';
import { useToast } from 'primevue/usetoast';
const toast = useToast();
const ujianStore = useUjianStore();
const loadingBtn = ref(false);
const mulaiUjian = ref(false)
const countdownUjian = ref("")
const $route = useRoute();
const jadwalStore = useJadwalStore();
const form = ref({
    token: null,
    jadwal_id: $route.params.jadwal_id,
})
onMounted(function () {
    jadwalStore.getDetailJadwal($route.params.jadwal_id);
});

function konfirmasi() {
    loadingBtn.value = true;
    ujianStore.konfirmasi(form.value).then(function(response){
        loadingBtn.value = false;
        console.log(response);
    }).catch(function(error){
        loadingBtn.value = false;
        toast.add({
            severity : "error",
            summary : "Kesalahan",
            detail : error.response.data.message,
            life :6000,
        })
    });
}

function CountDown(startTime) {
    //now 
    const ints = setInterval(function () {
        const now = timezone.tz('Asia/Jakarta').unix();
        const timeDifference = (startTime) - now;
        const hours = Math.floor(timeDifference / 3600); // 1 jam = 3600 detik
        const minutes = Math.floor((timeDifference % 3600) / 60); // 1 menit = 60 detik
        const seconds = timeDifference % 60; // Detik
        if (hours <= 0 && minutes <= 0 && seconds <= 0) {
            mulaiUjian.value = true;
            clearInterval(ints);
        } else {
            countdownUjian.value = `${hours} Jam - ${minutes} Menit - ${seconds} Detik`;
        }
    }, 1000);
}

</script>
<template>
    <div v-if="dd = jadwalStore?.available?.data?.unix_time">
        {{ !mulaiUjian ? CountDown(dd) + " M" : '' }}
    </div>
    <div class="container">

        <!-- dialog konfirmsi -->
        <Dialog :visible="jadwalStore.available.error" modal header="Informasi">
            <p>
                {{ jadwalStore.available.message }}
            </p>
            <template #footer>
                <Button @click="router.push('/home')" label="Ya Baiklah" severity="info" />
            </template>
        </Dialog>
        <!-- main utama -->

        <div class="my-5 mt-5 sm:mt-5">
            <div class="max-w-lg mx-auto">
                <div class="flex flex-col gap-3 border border-gray-200 shadow-lg">
                    <div class="px-6 py-3 text-lg text-left uppercase border-b text-primary-500">
                        <i class="font-bold pi pi-info-circle"></i>
                        Konfirmasi Ujian {{ useJadwalStore.available }}

                        <p class="mt-1 text-xs text-gray-800 capitalize">
                            Pastikan akun anda dan mata ujian yang di ikuti sudah benar! Agar tidak ada kesalahan
                        </p>
                    </div>
                    <!-- form konfirmasi info soal -->
                    <div class="p-2 px-6 leading-snug rounded">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                            <div class="grid grid-cols-1 gap-2 tracking-tighter">
                                <div>
                                    <div class="font-semibold">Mata Pelajaran:</div>
                                    <div v-if="ata = jadwalStore?.available?.data?.bank_soal?.nama">
                                        {{ ata }}
                                    </div>
                                    <div v-else>
                                        loading...
                                    </div>
                                </div>
                                <div>
                                    <div class="font-semibold">Kelas(Group):</div> XII-RPL 10
                                </div>
                                <div>
                                    <div class="font-semibold">Waktu/Jumlah Soal:</div>
                                    <div class="flex items-center gap-2">
                                        <div v-if="lama_ujian = jadwalStore?.available?.data?.lama_ujian">
                                            {{ lama_ujian }} Menit
                                        </div>
                                        <div v-else>
                                            loading...
                                        </div>
                                        <span>/</span>
                                        <div v-if="jumlah_soal = jadwalStore?.available?.data?.bank_soal?.jumlah_soal">
                                            {{ jumlah_soal }} Soal
                                        </div>
                                        <div v-else>
                                            loading...
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="my-4 font-bold text-green-500 sm:my-0">
                                Sesi 1 Jam Ke 2
                            </div>
                        </div>
                    </div>

                    <div class="p-4 px-6 py-2">
                        <div @submit.prevent="konfirmasi" action="">
                            <label for="token" class="font-semibold text-gray-200">Token</label>
                            <InputText v-model="form.token" class="w-full py-3 rounded-sm bg-gray-50 h-9"
                                placeholder="Ketikan token ujian" />
                        </div>
                        <!-- end informais soal -->
                        <div class="flex justify-end mt-4 mb-6">
                            <Button v-if="mulaiUjian" @click="konfirmasi" :loading="loadingBtn" severity="info"
                                icon="pi pi-check" label="Konfirmasi" iconPos="right" />
                            <div class="block w-full p-3 tracking-tighter text-center bg-gray-100 border border-gray-400 rounded"
                                v-else>
                                <div class="flex items-center justify-start gap-2">
                                    <Book2 />
                                    <div class="text-sm text-left">
                                        Tombol mulai ujian akan muncul ketika waktunya sudah di mulai
                                        <div class="text-xs">Berdo'a lah agar ujian nya lancar</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>