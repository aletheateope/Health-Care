<script setup>
import { ref } from "vue";

import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import InputText from "primevue/inputtext";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import TieredMenu from "primevue/tieredmenu";

import DataTableContainer from "@/components/datatable/Container.vue";
import PaginatedDatatable from "@/components/datatable/PaginatedDatatable.vue";

import { usePaginatedData } from "@/utils/datatable";

const {
    data: prescriptions,
    total,
    rows,
    currentPage,
    loading,
    onPage,
    fetchData,
} = usePaginatedData("/my-prescriptions", 20);

const menu = ref([]);

const menuItems = ref([
    { label: "Edit", icon: "pi pi-pen-to-square" },
    { label: "Delete", icon: "pi pi-trash" },
]);

const toggleMenu = (event, i) => {
    menu.value[i].toggle(event);
};
</script>

<template>
    <section class="flex flex-col gap-8 h-full" id="prescriptions-section">
        <header
            class="flex flex-col sm:flex-row justify-between gap-6 sm:gap-8"
        >
            <IconField class="flex-grow">
                <InputIcon class="pi pi-search" />
                <InputText placeholder="Search" fluid />
            </IconField>
            <RouterLink :to="{ name: 'prescription-new' }">
                <Button label="Write Prescription" icon="pi pi-plus" />
            </RouterLink>
        </header>
        <DataTableContainer>
            <PaginatedDatatable
                :value="prescriptions"
                :totalRecords="total"
                :rows="rows"
                :page="onPage"
            >
                <Column field="patientName" header="Patient Name">
                    <template #body="{ data }">
                        {{ data.patient_name }}
                    </template>
                </Column>
                <Column field="date" header="Date">
                    <template #body="{ data }">
                        {{ data.date_issued }}
                    </template>
                </Column>
                <Column field="validUntil" header="Valid Until">
                    <template #body="{ data }">
                        {{ data.valid_until }}
                    </template>
                </Column>
                <Column field="prescribed" header="Prescribed">
                    <template #body="{ data }">
                        <ul>
                            <li v-for="item in data.items" :key="item.id">
                                {{ item.item }}
                            </li>
                        </ul>
                    </template>
                </Column>
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
                                v-for="(item, i) in prescriptions"
                                :key="i"
                                ref="menu"
                                id="more"
                                :model="menuItems"
                                popup
                                appendTo="#prescriptions-section"
                            />
                        </div>
                    </template>
                </Column>
            </PaginatedDatatable>
        </DataTableContainer>
    </section>
</template>
