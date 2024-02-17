<script setup>
import Card from 'primevue/card';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import { onMounted, ref } from 'vue';
import InputText from 'primevue/inputtext';
import InputGroupAddon from 'primevue/inputgroupaddon'
import InputGroup from 'primevue/inputgroup'
import { useJadwalStore } from '@/stores/jadwal';
import { useRoute } from 'vue-router';
import router from '@/router'
import timezone from 'moment-timezone'

var dialogVisible = ref(false);
const mulaiUjian = ref(false)
const countdownUjian = ref("")
const $route = useRoute();
const jadwalStore = useJadwalStore();
onMounted(function () {
    jadwalStore.getDetailJadwal($route.params.jadwal_id);
});
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
                <Card class="border shadow-lg">
                    <template #header>
                        <div class="p-3 text-lg text-center uppercase text-primary-500">
                            <i class="font-bold pi pi-info-circle"></i>
                            Konfirmasi Ujian {{ useJadwalStore.available }}

                            <p class="mt-1 text-xs text-gray-800 capitalize">
                                Pastikan akun anda dan mata ujian yang di ikuti sudah benar! Agar tidak ada kesalahan
                            </p>
                        </div>
                    </template>
                    <template #content>
                        <!-- form konfirmasi info soal -->
                        <div class="p-2 px-3 mb-6 leading-snug rounded bg-gray-50">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                <div class="grid grid-cols-1 gap-2 tracking-tighter">
                                    <div>
                                        <div class="font-semibold">Nama Peserta:</div> Dadan Hidayat
                                    </div>
                                    <div>
                                        <div class="font-semibold">Nomor Peserta:</div> 09982773
                                    </div>

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
                                        <div class="flex gap-2 items-center">
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

                        <form action="">
                            <InputGroup>
                                <InputGroupAddon>
                                    <span class="text-sm font-semibold">Token Ujian</span>
                                </InputGroupAddon>
                                <InputText placeholder="Ketikan token ujian" />
                            </InputGroup>
                        </form>
                        <!-- end informais soal -->
                    </template>
                    <template #footer>
                        <div class="flex justify-end">
                            <Button v-if="mulaiUjian" @click="dialogVisible = true" :loading="false" severity="info"
                                icon="pi pi-check" label="Konfirmasi" iconPos="right" />
                            <div class="bg-gray-100 block w-full p-3 rounded text-center" v-else> Ujian Akan mulai Pada {{
                                countdownUjian }}</div>
                        </div>
                    </template>
                </Card>
            </div>
        </div>
    </div>
</template>