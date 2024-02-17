<script setup>
import { RouterView } from 'vue-router'
import BgHeader from '@/views/images/header-bg.png'
</script>

<template>
    <div class="bg-gray-50">
        <header class="relative overflow-hidden w-full h-60 bg-red-50">
            <img class="absolute object-fill h-60 w-full pointer-events-none" :src="BgHeader" alt="">
        </header>
        <RouterView />
    </div>
</template>