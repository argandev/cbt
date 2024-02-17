import { $api } from '@/api'
import { defineStore } from 'pinia'
import { ref } from 'vue'
export const useAuthStore = defineStore('auth', () => {
  function getAkunSiswa() {
    return $api.get('/siswa/me')
  }
  const user_token = ref(localStorage.getItem('api_token_'))
  const doLogin = async function (user) {
    return await $api.post('/siswa/login', user)
  }
  function setApiToken(api_token) {
    user_token.value = api_token
    localStorage.setItem('api_token_', api_token)
  }

  return {
    user_token,
    doLogin,
    setApiToken,
    getAkunSiswa
  }
})
