import {
  createRouter,
  createWebHistory
} from 'vue-router'
import BaseAuthViewVue from '@/views/BaseAuthView.vue'
import LoginView from '@/views/Auth/LoginView.vue'
import AuthenticateLayoutVue from '@/views/AuthenticateLayout.vue'
import IndexViewVue from '@/views/Home/IndexView.vue'
import KonfirmasiViewVue from '@/views/Home/KonfirmasiView.vue'
import NotFound from '@/views/NotFoundView.vue'
import {
  useAuthStore
} from '@/stores/auth'
import HomeViewVue from '@/views/HomeView.vue'


const router = createRouter({
  scrollBehavior: function () {
    return {
      scrolTo: 0,
      behavior: "smooth"
    }
  },
  history: createWebHistory(
    import.meta.env.BASE_URL),
  routes: [
  
    {
      path: '/',
      component: BaseAuthViewVue,
      children: [
        {
          path : '/',
          component : LoginView,
        },
        {
        path: "/login",
        name: 'login',
        component: LoginView
      }],
      beforeEnter: function () {
        if (useAuthStore().user_token) {
          router.push({
            name: "home"
          });
        }
      }
    },
    {
      path: '/home',
      component: AuthenticateLayoutVue,
      meta: {
        must_login: true,
      },
      children: [{
        path: "/home",
        name: 'home',
        component: IndexViewVue,

      }, {
        path: '/konfirmasi/:jadwal_id',
        component: KonfirmasiViewVue,
      }]
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'NotFound',
      component: NotFound
    },
  ]
})

router.beforeEach(function (to, from, next) {
  if (to.meta.must_login === true) {
    if (!useAuthStore().user_token) {
      router.push({
        name: "login"
      });
    } else {
      next();
    }
  } else {
    next();
  }
})

export default router