<script setup>
import DataTable from "primevue/datatable";

const props = defineProps({
    value: Array,
    totalRecords: Number,
    rows: Number,
    page: Function,
});
</script>

<template>
    <DataTable
        :value="value"
        :totalRecords="totalRecords"
        :rows="rows"
        :lazy="true"
        @page="page"
        paginator
        tableStyle="width: 100%"
        scrollHeight="100%"
        class="flex! flex-col flex-grow h-0"
        :pt="{
            tableContainer: {
                class: 'flex-grow',
            },
        }"
    >
        <template #empty>
            <div class="text-center">No records found.</div>
        </template>
        <slot />
    </DataTable>
</template>
