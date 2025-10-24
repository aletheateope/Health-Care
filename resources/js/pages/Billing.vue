<script setup>
import { ref } from "vue";

import SelectButton from "primevue/selectbutton";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import TieredMenu from "primevue/tieredmenu";

const billingType = ref("1");

const tabItems = [
    { label: "All Payments", value: "1" },
    { label: "Completed", value: "2" },
    { label: "Pending", value: "3" },
];

const billings = ref([
    {
        date: "test",
        service: "test",
        amount: "test",
        balance: "test",
        coverage: "test",
        status: "test",
    },
    {
        date: "test",
        service: "test",
        amount: "test",
        balance: "test",
        coverage: "test",
        status: "test",
    },
]);

const menu = ref([]);

const menuItems = ref([
    { label: "Edit", icon: "pi pi-pen-to-square" },
    { label: "Delete", icon: "pi pi-trash" },
]);

const toggleMenu = (event, i) => {
    menu.value[i].toggle(event);
};
</script>

<style>
@media (min-width: 640px) {
    .billing-tab.p-selectbutton-fluid {
        width: auto;

        .p-togglebutton {
            flex: 0 0 auto;
        }
    }
}
</style>

<template>
    <section class="flex flex-col gap-8 h-full" id="billing-section">
        <header>
            <SelectButton
                v-model="billingType"
                :allowEmpty="false"
                :options="tabItems"
                optionLabel="label"
                optionValue="value"
                class="billing-tab"
                fluid
            />
        </header>
        <div class="flex flex-col flex-grow">
            <DataTable
                :value="billings"
                scrollable
                tableStyle="min-width: 50rem border"
                scrollHeight="100%"
                class="flex-grow h-0"
            >
                <Column field="date" header="Date"></Column>
                <Column field="service" header="Service"></Column>
                <Column field="amount" header="Amount Total"></Column>
                <Column field="balance" header="Balance"></Column>
                <Column field="coverage" header="Coverage"></Column>
                <Column field="status" header="Status"></Column>
                <Column class="w-30">
                    <template #header>
                        <div
                            class="flex-1 text-center p-datatable-column-title"
                        >
                            Action
                        </div>
                    </template>
                    <template #body="{ data, index }">
                        <div class="text-center">
                            <Button
                                icon="pi pi-ellipsis-v"
                                aria-label="More"
                                severity="secondary"
                                variant="text"
                                aria-haspopup="true"
                                aria-controls="more"
                                @click="(e) => toggleMenu(e, index)"
                            />
                            <TieredMenu
                                v-for="(item, i) in billings"
                                :key="i"
                                ref="menu"
                                id="more"
                                :model="menuItems"
                                popup
                                appendTo="#billing-section"
                            />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>
    </section>
</template>
