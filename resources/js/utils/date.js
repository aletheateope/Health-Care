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
