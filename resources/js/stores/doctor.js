import { defineStore } from "pinia";
import { ref } from "vue";

export const useDoctorStore = defineStore("doctor", () => {
    // State
    const doctors = ref([]);
    const availabilities = ref({});
    const doctorSpecialties = ref([]);

    const loading = ref(false);
    const page = ref(1);
    const lastPage = ref(null);

    async function fetchDoctors(reset = false) {
        if (loading.value) return;
        if (lastPage.value && page.value > lastPage.value) return;

        if (reset) {
            doctors.value = [];
            page.value = 1;
            lastPage.value = null;
        }

        loading.value = true;
        try {
            const response = await axios.get("/api/doctors", {
                params: { page: page.value, limit: 10 },
            });
            const data = response.data.data;
            const meta = response.data.meta;

            console.log(response.data);

            if (data.length > 0) {
                doctors.value.push(...data.filter((d) => d.specialty));
                lastPage.value = meta.last_page;
                page.value++;
            }
        } catch (error) {
            console.error("Failed to fetch doctors", error);
        } finally {
            loading.value = false;
        }
    }

    async function fetchAvailability(doctorId) {
        if (availabilities.value[doctorId]) return;
        try {
            const response = await axios.get(
                `/api/doctor/${doctorId}/availabilities`
            );
            const data = response.data.data;
            availabilities.value[doctorId] = groupAvailability(data);
        } catch (error) {
            console.error(
                `Failed to fetch availability for doctor ${doctorId}`,
                error
            );
        }
    }

    function groupAvailability(availability) {
        if (!availability?.length) return [];

        const byDay = {};
        for (const item of availability) {
            const day = capitalize(item.day_of_week);
            if (!byDay[day]) byDay[day] = [];
            byDay[day].push({
                start_time: item.start_time,
                end_time: item.end_time,
            });
        }

        const mergedByDay = {};
        for (const [day, times] of Object.entries(byDay)) {
            const sorted = times.sort((a, b) =>
                compareTime(a.start_time, b.start_time)
            );
            const merged = [];
            let current = sorted[0];

            for (let i = 1; i < sorted.length; i++) {
                const next = sorted[i];
                if (
                    normalizeTime(current.end_time) ===
                    normalizeTime(next.start_time)
                ) {
                    current.end_time = next.end_time;
                } else {
                    merged.push(current);
                    current = next;
                }
            }
            merged.push(current);
            mergedByDay[day] = merged;
        }

        const map = new Map();
        for (const [day, times] of Object.entries(mergedByDay)) {
            for (const t of times) {
                const key = `${t.start_time}-${t.end_time}`;
                if (!map.has(key)) {
                    map.set(key, {
                        days: [day],
                        start_time: t.start_time,
                        end_time: t.end_time,
                    });
                } else {
                    map.get(key).days.push(day);
                }
            }
        }
        return Array.from(map.values());
    }

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function normalizeTime(timeStr) {
        const [time, modifier] = timeStr.split(" ");
        let [hours, minutes] = time.split(":").map(Number);
        if (modifier.toLowerCase() === "pm" && hours !== 12) hours += 12;
        if (modifier.toLowerCase() === "am" && hours === 12) hours = 0;
        return hours * 60 + (minutes || 0);
    }

    function compareTime(a, b) {
        return normalizeTime(a) - normalizeTime(b);
    }

    async function fetchDoctorSpecialties() {
        try {
            const response = await axios.get("/api/doctor/specialties");

            doctorSpecialties.value = response.data.data.map((item) => ({
                label: item.name,
                value: item.id,
            }));
        } catch (err) {
            console.error(err);
        }
    }

    return {
        // state
        doctors,
        availabilities,
        doctorSpecialties,
        loading,
        page,
        lastPage,
        // actions
        fetchDoctors,
        fetchAvailability,
        fetchDoctorSpecialties,
    };
});
