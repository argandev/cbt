<script setup>
import moment from 'moment'
import Button from 'primevue/button'
import Books from '@/components/icons/Books.vue'
import { useAuthStore } from '@/stores/auth'
import Skeleton from 'primevue/skeleton'
import { onMounted, ref } from 'vue'
import { useJadwalStore } from '@/stores/jadwal';
import router from '@/router'
const jadwal = useJadwalStore();
const loadingData = ref(true);
const data = ref({})
/**
 * akun store
 */
const akunSiswa = useAuthStore().getAkunSiswa()
onMounted(function () {
    jadwal.getJadwalSekarang();
    akunSiswa
        .then(function (e) {
            console.info("Berhasil dapatkan data")
            loadingData.value = false
            data.value = e.data.data;
        })
        .catch((error) => {
            console.error(error)
        });
});
</script>
<template>
    <div class="my-5">
        <div class="flex flex-col items-start justify-start gap-3 sm:flex-row sm:gap-8">
            <div class="w-full mt-5">
                <!-- list jadwal tersedia hari ini -->
                <div class="mb-3 font-bold text-left text-gray-800 capitalize">
                    Jadwal Hari ini
                    <div>{{ moment().format('LLL') }}</div>
                </div>

                <div v-if="!jadwal.loadingGetData">
                    <div v-if="jadwal.available.data.length > 0">

                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-3">
                            <div v-for="jadwal in jadwal.available.data" class="p-2 rounded shadow" v-bind:key="jadwal.id">
                                <div v-key="i" class="flex flex-col gap-3 p-3">
                                    <div class="flex flex-col gap-2">
                                        <p class="font-bold tracking-tighter sm:text-lg">{{ jadwal.nama }}</p>
                                        <p class="flex items-center gap-1 text-sm">
                                            <Books width="20" height="20" />
                                            <span class="font-bold">Pendidikan Agama Islam</span>
                                        </p>
                                        <p class="text-xs italic">Durasi Pengerjaan {{ jadwal.durasi }} Menit</p>
                                    </div>
                                    <Button @click="router.push({ path: `/konfirmasi/${jadwal.id}`, replace: true })"
                                        severity="info">Mulai
                                        Ujian</Button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="flex items-center justify-start w-full p-3 text-white bg-red-500 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="m21.17 15.4l-5.91-9.85c-.78-1.3-1.96-2.04-3.26-2.04s-2.48.74-3.26 2.03L2.83 15.4c-.44.73-.66 1.49-.66 2.21c0 .57.14 1.13.42 1.62C3.23 20.35 4.47 21 6 21h12c1.53 0 2.77-.65 3.41-1.77c.28-.49.42-1.02.42-1.58c.01-.74-.21-1.51-.66-2.25M12 8.45c.85 0 1.55.7 1.55 1.55c0 .85-.69 1.55-1.55 1.55c-.85 0-1.55-.7-1.55-1.55c0-.86.69-1.55 1.55-1.55m1.69 8.46c-.03.04-.8.92-2.07.92h-.15c-.51-.03-.93-.25-1.18-.63c-.31-.47-.36-1.11-.12-1.82l.41-1.22c.23-.68.01-.79-.11-.85l-.14-.02c-.25 0-.6.15-.71.21c-.1.05-.23.03-.31-.07c-.07-.1-.07-.23.01-.32c.03-.04.87-.99 2.22-.91c.51.03.93.25 1.18.63c.32.47.36 1.11.12 1.83l-.41 1.22c-.23.68-.01.79.11.85l.14.02c.25 0 .6-.15.71-.2c.11-.06.23-.03.31.07c.07.07.07.2-.01.29" />
                        </svg>Tidak Ad jadwal hari ini
                    </div>
                </div>
                <div class="grid grid-cols-3" v-else>
                    <div class="p-2 border rounded shadow-lg">
                        <Skeleton class="mb-2"></Skeleton>
                        <div class="flex gap-2">
                            <Skeleton width="2rem" class="mb-2"></Skeleton>
                            <Skeleton class="mb-2"></Skeleton>
                        </div>
                        <Skeleton></Skeleton>
                        <Skeleton class="mt-4" height="2rem"></Skeleton>
                    </div>
                </div>
            </div>

            <!-- end tersedia hari in -->

            <div class="w-full max-w-full sm:max-w-sm">
                <div class="shadow">
                    <div class="p-3 text-lg font-semibold uppercase">
                        <i class="pi pi-user"></i> INFO SISWA
                    </div>
                    <div v-if="!loadingData" class="grid grid-cols-1 px-3 pb-3 divide-y">
                        <div class="flex items-center justify-between pt-3 pb-1">
                            <span class="font-bold">Kode Peserta</span>
                            <span>{{ data.kode_peserta }}</span>
                        </div>
                        <div class="flex items-center justify-between pt-3 pb-1">
                            <span class="font-bold">Nama</span>
                            <span>{{ data.nama }}</span>
                        </div>
                        <div class="flex items-center justify-between pt-3 pb-1">
                            <span class="font-bold"> Nis/Nisn </span>
                            <span>{{ data.nis }} / {{ data.nisn }}</span>
                        </div>
                        <div class="flex items-center justify-between pt-3 pb-1">
                            <span class="font-bold"> Kelas </span>
                            <span>{{ data.kelas.nama }}</span>
                        </div>
                       <div class="mt-4">
                        <Button class="mt-4" severity="danger"> Logout</Button>
                       </div>
                    </div>
                    <div class="p-3" v-else>
                        <div v-for="i in 6" class="flex justify-between" v-bind:key="i">
                            <Skeleton width="15rem" class="mb-2"></Skeleton>
                            <Skeleton width="5rem" class="mb-2"></Skeleton>
                        </div>
                        <Skeleton class="my-4" height="2rem"></Skeleton>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
@/stores/jadwal