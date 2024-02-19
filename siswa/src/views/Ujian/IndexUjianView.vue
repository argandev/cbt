<script setup>
import Slider from 'primevue/slider'
import Button from 'primevue/button';
import RadioButton from 'primevue/radiobutton';
import Dialog from 'primevue/dialog';
import { ref } from 'vue'
const ukuranFont = ref(14)
const visibleSoals = ref(false);
</script>
<template>
    <Dialog v-model:visible="visibleSoals" modal header="NAVIGASI SOAL">
        <div class="grid grid-cols-10 gap-2">
            <div v-for="i in 60" v-bind:key="i"
                class="p-2 flex items-center justify-center bg-red-500 cursor-pointer text-white font-bold rounded-lg"
                v-tooltip.top="'Belum di isi no ' + i">{{ i }}</div>
        </div>
        <template #footer>
            <Button severity="info" label="Siap!" @click="visibleSoals = false" />
        </template>
    </Dialog>
    <div class="relative mt-3 border rounded-xl shadow-sm">
        <div class="flex overflow-hidden items-center justify-between">
            <div class="my-2 flex items-center gap-3 jusitfy-start">
                <div class="bg-gray-200 w-16 flex items-center justify-center rounded-r-xl p-3">
                    <span class="font-bold text-lg flex items-center justify-center rounded-full">1</span>
                </div>
                <div class="">Pilihan Ganda</div>
            </div>
            <div v-tooltip.left="'Sisa waktu pengerjaan anda'" class="px-4 bg-blue-500 py-2 text-white font-bold">30:29
            </div>
        </div>
        <div class="border-t py-4 my-3 border-b">
            <div class="px-3">
                <div class="flex items-center justify-between">
                    <div class="flex gap-1 flex-col">
                        <label class="text-sm" for="">Ukuran Huruf</label>
                        <Slider v-model="ukuranFont" orientation="horizontal" />
                    </div>
                    <div class="grid grid-cols-2">
                        <Button v-tooltip.left="'Mode fokus'" class="rounded-none" icon="pi pi-arrow-up-right" />
                        <Button v-tooltip.top="'Lihat navigasi soal'" @click="visibleSoals = true" class="rounded-none"
                            severity="info" icon="pi pi-th-large" />
                    </div>
                </div>
            </div>
        </div>
        <div class="px-6 mb-4 flex flex-col gap-4">
            <div class="soal">
                <img src="https://akcdn.detik.net.id/visual/2024/02/14/komeng-2_169.jpeg?w=650&q=90" alt="">
                <p>
                    Siapakah nama orang di atas?
                </p>
            </div>
            <div class="jawan flex flex-col gap-3">
                <div class="flex items-start gap-2 ">
                    <div
                        class="bg-blue-500 w-8 h-8 flex items-center justify-center font-bold text-white rounded cursor-pointer">
                        A</div>
                    <p>
                        Alfiansyah Komeng Uhuy
                    </p>
                </div>
                <div class="flex items-start gap-2">
                    <div
                        class="bg-gray-200 hover:bg-blue-500 hover:text-white transition-all w-8 h-8 flex items-center justify-center font-bold text-black rounded cursor-pointer">
                        B</div>
                    <p>
                        Kang Asep
                    </p>
                </div>
                <div class="flex items-start gap-2 ">
                    <div
                        class="bg-gray-200 hover:bg-blue-500 hover:text-white transition-all w-8 h-8 flex items-center justify-center font-bold text-black rounded cursor-pointer">
                        C</div>
                    <p>
                        Ujang Sembako
                    </p>
                </div>
            </div>

        </div>
        <div class="flex items-center justify-between border-t py-4 px-3">
            <Button severity="danger" icon="pi pi-arrow-left" label="Sebelumnya" iconPos="left" />
            <Button severity="warning">Ragu Ragu</Button>
        <Button severity="danger" icon="pi pi-arrow-right" label="Selanjutnya" iconPos="right" />
    </div>
</div></template>
