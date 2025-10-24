<script setup>
defineProps({
    name: {
        type: String,
        required: true,
    },
    specialty: {
        type: [String, Object],
        default: null,
    },
    showSpecialty: {
        type: Boolean,
        default: false,
    },
    img_profile: {
        type: String,
        default:
            "https://cdn.pixabay.com/photo/2023/02/18/11/00/icon-7797704_1280.png",
    },
});
</script>

<template>
    <Button
        severity="contrast"
        variant="text"
        fluid
        class="flex flex-row shrink-0 justify-start! p-0! px-2! py-2! gap-3!"
    >
        <div
            class="size-14 shrink-0 border border-color rounded-full overflow-hidden"
        >
            <img
                :src="img_profile"
                alt="Doctor Profile"
                class="h-full w-full object-cover"
            />
        </div>
        <div class="flex flex-col items-start">
            <h6 class="font-medium">{{ name }}</h6>
            <p v-if="showSpecialty && specialty" class="text-gray-500">
                {{ typeof specialty === "object" ? specialty.name : specialty }}
            </p>
        </div>
    </Button>
</template>
