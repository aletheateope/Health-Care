import { useToast } from "primevue/usetoast";

export function useAppToast() {
    const toast = useToast();

    const notify = (severity, summary, detail, life = 3000) => {
        toast.add({
            severity,
            summary,
            detail,
            life,
        });
    };

    return {
        success: (msg, title = "Success") => notify("success", title, msg),
        info: (msg, title = "Info") => notify("info", title, msg),
        warn: (msg, title = "Warning") => notify("warn", title, msg),
        error: (msg, title = "Error") => notify("error", title, msg),
    };
}
