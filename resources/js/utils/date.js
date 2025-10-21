import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";
import timezone from "dayjs/plugin/timezone";

dayjs.extend(utc);
dayjs.extend(timezone);

// "Thursday, October 16, 2025"
export function formatDate(value) {
    if (!value) return "";
    const d = new Date(value);
    return d.toLocaleDateString("en-US", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    });
}

export function formatPastTime(timestamp) {
    if (!timestamp) return "";

    const userTz = dayjs.tz.guess();

    const time = dayjs.utc(timestamp).tz(userTz);
    const now = dayjs().tz(userTz);

    const diffSeconds = now.diff(time, "second");
    const diffMinutes = now.diff(time, "minute");
    const diffHours = now.diff(time, "hour");
    const diffDays = now.diff(time, "day");
    const diffYears = now.diff(time, "year");

    if (diffSeconds < 60) return "now";
    if (diffMinutes < 60) return diffMinutes + "m";
    if (diffHours < 24) return diffHours + "h";
    if (diffDays < 7) return diffDays + "d";
    if (diffYears < 1) return time.format("MMM D"); // Oct 20
    return time.format("MMM D, YYYY"); // Oct 20, 2025
}
