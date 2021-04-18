import Vue from 'vue'
import axios from 'axios'
import { Cookies } from 'quasar'

const api = axios.create({
  baseURL: process.env.API_URL
})

if (Cookies.get('bearer')) {
  api.defaults.headers.common.Authorization = Cookies.get('bearer')
}

Vue.prototype.$get = function (url, params) {
  return new Promise((resolve, reject) => {
    api.get(url, {
      params: {
        params
      }
    })
      .then(function (response) {
        resolve(response)
      })
      .catch(function (error) {
        if (error.response && error.response.status === 401) {
          Cookies.remove('bearer')
          Cookies.remove('me')
          window.location.href = '/login'
        }

        reject(error)
      })
  })
}

Vue.prototype.$post = function (url, data, options) {
  return new Promise((resolve, reject) => {
    api.post(url, data, options)
      .then((response) => {
        resolve(response)
      })
      .catch(function (error) {
        let isLoginUrl = false
        if (error.response && error.response.config && error.response.config.url) {
          const lastSegment = error.response.config.url.split('/').pop()
          isLoginUrl = lastSegment === 'login'
        }

        if (error.response && error.response.status === 401 && !isLoginUrl) {
          Cookies.remove('bearer')
          Cookies.remove('me')
          window.location.href = '/login'
        }

        reject(error)
      })
  })
}

Vue.prototype.$redirect = function (url) {
  window.location.href = url
}

export { api }
