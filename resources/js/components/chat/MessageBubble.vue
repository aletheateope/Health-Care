<script setup>
const props = defineProps({
    message: Object,
    recipient: Object,
});
</script>
<template>
    <div v-if="message.sender === 'me'" class="flex flex-col py-2 gap-1">
        <div class="flex flex-row">
            <div class="flex-grow p-4"></div>
            <div class="bg-accent-color text-white p-2 rounded-md max-w-[80%]">
                <p>{{ message.message }}</p>
            </div>
        </div>
    </div>

    <div v-else class="flex flex-col py-2 gap-1">
        <div class="flex flex-row">
            <div class="flex flex-row max-w-[80%] gap-2 items-end">
                <div
                    class="shrink-0 size-8 rounded-full overflow-hidden border border-color"
                >
                    <img
                        src="https://cdn.pixabay.com/photo/2023/02/18/11/00/icon-7797704_1280.png"
                        alt=""
                        class="h-full w-full object-cover"
                    />
                </div>
                <div class="flex flex-col gap-1 items-start">
                    <div
                        class="bg-gray-100 dark:bg-gray-600 text-color p-2 rounded-md"
                    >
                        <p>{{ message.message }}</p>
                    </div>
                </div>
            </div>
            <div class="flex-grow p-4"></div>
        </div>
    </div>
</template>
