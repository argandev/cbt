import axios from 'axios'
import {
  useAuthStore
} from './stores/auth'

import router from './router'

const API_ENDPOINT = 'http://localhost:8000/api'
const $api = axios.create({
  baseURL: API_ENDPOINT + '/v2',
  headers: {
    Accept: 'application/json'
  }
})

$api.interceptors.request.use(
  function (config) {
    if (config) {
      config.headers.set('Authorization', 'Bearer ' + useAuthStore().user_token)
      return config
    }
  },
  function (error) {
    return Promise.reject(error)
  }
)

$api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response.status == 401) {
      new Promise((resolve) => {
        delete localStorage.removeItem('api_token_')
        resolve()
      }).then(() => {
        useAuthStore().user_token = false;
        router.push({
          name: 'login'
        })
      })
    }
    return Promise.reject(error)
  }
)

export {
  $api
}