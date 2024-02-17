<script setup>
    import {RouterView} from 'vue-router';
    import AuthenticatedHeader from '@/components/AuthenticatedHeader.vue';
</script>
<template>
    <AuthenticatedHeader/>
    <div class="container mx-auto sm:p-0 p-3">
        <RouterView/>
    </div>
</template>