<script setup></script>

<template>
    <router-view v-slot="{ Component, route }">
        <transition name="fade" mode="out-in" :key="route.name">
            <component :is="Component" />
        </transition>
    </router-view>
</template>
