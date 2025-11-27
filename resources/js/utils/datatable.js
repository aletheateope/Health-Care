import { ref, onMounted } from "vue";
import axios from "axios";

export function usePaginatedData(fetchUrl, defaultRows = 10) {
    const data = ref([]);
    const total = ref(0);
    const rows = ref(defaultRows);
    const currentPage = ref(0);
    const loading = ref(false);

    async function fetchData(page = 0, perPage = defaultRows) {
        loading.value = true;
        try {
            const response = await axios.get(fetchUrl, {
                params: { page: page + 1, per_page: perPage },
            });
            data.value = response.data.data;
            total.value = response.data.meta.total;
        } catch (err) {
            console.error(err);
        } finally {
            loading.value = false;
        }
    }

    function onPage(event) {
        currentPage.value = event.page;
        rows.value = event.rows;
        fetchData(event.page, event.rows);
    }

    onMounted(() => {
        fetchData(currentPage.value, rows.value);
    });

    return {
        data,
        total,
        rows,
        currentPage,
        loading,
        fetchData,
        onPage,
    };
}
