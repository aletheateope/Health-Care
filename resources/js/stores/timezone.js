import { defineStore } from "pinia";

export const useTimezoneStore = defineStore("timezone", {
    state: () => ({
        timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
    }),
    actions: {
        setTimezone(tz) {
            this.timezone = tz;
        },
    },
});
