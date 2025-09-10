<script setup>
import Navbar from '@/components/Navbar.vue';
</script>

<template>
     <Navbar />
    <div class="h-screen w-screen overflow-x-hidden overflow-y-auto bg-gray-50 flex justify-center p-4">
        <slot />
    </div>
</template>
