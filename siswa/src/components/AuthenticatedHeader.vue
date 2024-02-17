<script setup>
import Avatar from 'primevue/avatar'
import Menu from 'primevue/menu'
import MenuBar from "primevue/menubar"
import { ref } from 'vue'


const menuItems = ref([
    {
        label: 'Hasil Ujian Saya',
        icon: 'pi pi-file',
        command: () => {
            alert("WELLCOME")
        }
    },
    {
        label: 'Akun SAya',
        icon: 'pi pi-user',
        command: () => {
            alert("WELLCOME")
        },

    },

]);

const items = ref([
    {
        label: 'MENU',
        items: [
            {
                label: 'Refresh',
                icon: 'pi pi-refresh'
            },
            {
                label: 'Keluar',
                icon: 'pi pi-sign-out',
                route: 'login'
            }
        ]
    }
])

const menu = ref()

const toggle = (event) => {
    menu.value.toggle(event)
}
</script>

<template>
    <!-- header -->
    <header class="bg-red-500">
        <MenuBar class="shadow-sm rounded-none border-0" :model="menuItems">
            <template  #start>
                <span class="text-lg font-bold">Argan CBT</span>
            </template>
            <template #end>
                <div class="relative">
                    <Avatar :aria-haspopup="true" @click="toggle" aria-controls="show_menu" label="D" class="cursor-pointer"
                        shape="circle" />
                    <Menu ref="menu" :model="items" id="show_menu" :popup="true">
                        <template #item="{ item, props }">
                            <router-link v-if="item.route" v-slot="{ href, navigate }" :to="item.route" custom>
                                <a class="text-sm" :href="href" v-bind="props.action" @click="navigate">
                                    <span :class="item.icon" />
                                    <span class="ml-2">{{ item.label }}</span>
                                </a>
                            </router-link>
                            <a class="text-sm" v-else :href="item.url" :target="item.target" v-bind="props.action">
                                <span :class="item.icon" />
                                <span class="ml-2">{{ item.label }}</span>
                            </a>
                        </template>
                    </Menu>
                </div>
            </template>

        </MenuBar>
    </header>
    <!-- end:header -->
</template>
