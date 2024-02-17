<script setup>
import Card from 'primevue/card'
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import InputMask from 'primevue/inputmask'
import { useSiteConfigStore } from '@/stores/siteConfigStore.js'
import { useToast } from 'primevue/usetoast'
import { reactive, ref } from 'vue'
import { useAuthStore } from '@/stores/auth'
import router from '@/router'
const siteConfig = useSiteConfigStore()

const toast = useToast()
const loading = ref(false)
const errors = ref([])
const user = reactive({
    kode_peserta: null,
    password: null
})
function doLogin() {
    loading.value = true
    const doLogin = useAuthStore().doLogin(user)
    doLogin
        .then(function (response) {
            useAuthStore().setAPi
            loading.value = false
            const data = response.data
            if (response.status === 200) {
                useAuthStore().setApiToken(data.data.api_token);
                toast.add({
                    severity:"success",
                    life : 4000,
                    summary : "Login berhasil",
                    detail : "Anda akan di arahkan ke halaman home"
                });
                router.push({
                    name : 'home'
                })
                
            }
        })
        .catch(function (error) {
            loading.value = false

            const response = error.response
            if (response.status == 403 && response.data.error == true) {
                toast.add({
                    severity: 'error',
                    summary: 'Ada Kesalahan',
                    life: 2000,
                    detail: response.data.message
                })
                if (response.data.errors) {
                    errors.value = response.data.errors
                }
            }
        })
}



</script>
<template>
    <div class="relative -top-40">
        <div class="container mx-auto">
            <div class="max-w-sm mx-auto">
                <h1 class="text-center mb-2 -top-5 relative text-lg text-white font-bold">
                    {{ siteConfig.site_name }}
                </h1>
                <form action="" @submit.prevent="doLogin">
                    <Card class="shadow">
                        <template #title>{{ 'LOGIN' }}</template>
                        <template #content>
                            <div class="mb-3">
                                <label class="font-semibold text-gray-600 text-sm">Nomor Peserta</label>
                                <InputMask v-model="user.kode_peserta" mask="99-9999-99" place class="w-full py-2"
                                    autocomplete="none" placeholder="Ketikan nomor peserta ujian" />
                                    <div class="text-xs text-red-500" v-for="(error,i) in errors.kode_peserta" v-bind:key="i">{{ error }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="font-semibold text-gray-600 text-sm">Kata Sandi</label>
                                <InputText v-model="user.password" type="password" autocomplete="none" class="w-full py-2 p-invalid"
                                    placeholder="Ketikan kata sandi anda" />
                                    <div class="text-xs text-red-500" v-for="(error,i) in errors.password" v-bind:key="i">{{ error }}</div>

                            </div>
                            <Button type="submit" label="Login" severity="info" :loading="loading" icon="pi pi-sign-in"
                                iconPos="right" />
                        </template>
                    </Card>
                </form>
                <div class="text-center mt-0 tracking-wide text-sm relative flex flex-col gap-2 -bottom-6">
                    <span>Copyright &copy; {{ siteConfig.site_copyright }}</span>
                    <span class="flex items-center justify-center gap-1 text-xs"><i class="pi pi-code"></i>Developed By
                        Dadan Hidayat</span>
                </div>
            </div>
        </div>
    </div>
</template>
