import { ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { useIntersect } from "@/Composables/useIntersect.js";

export function useInfiniteScroll(propName, landmark = null) {
    const value = () => usePage().props[propName];
    console.log(value().data);
    const items = ref(value().data);

    const initialUrl = usePage().url;
    console.log(initialUrl);

    const loadMoreItems = () => {
        if (!value().links.next) return;

        router.get(
            value().links.next,
            {},
            {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    window.history.replaceState({}, "", initialUrl);
                    items.value = [...items.value, ...value().data];
                },
            },
        );
    };

    if (landmark !== null) {
        useIntersect(landmark, loadMoreItems);
    }

    return {
        items,
        loadMoreItems,
    };
}
