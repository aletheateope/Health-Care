<script setup>
import BaseLayout from '@/layout/BaseLayout.vue';
</script>


<template>
    <BaseLayout>
        <div class="w-full flex items-center justify-center">
            <slot />
        </div>
    </BaseLayout>
</template>
