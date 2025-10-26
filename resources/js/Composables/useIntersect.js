import { onMounted, onUnmounted } from "vue";

export function useIntersect(ref, callback) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                callback();
            }
        });
    });

    onMounted(() => {
        observer.observe(ref.value);
    });

    onUnmounted(() => observer.disconnect());
}
