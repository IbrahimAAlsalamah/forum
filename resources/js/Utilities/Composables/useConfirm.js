import {reactive, readonly} from "vue";

const globalState = reactive({
    show: false,
    message: '',
    resolver: null,
})

export function useConfirm () {

    const resetModel = () => {
        globalState.show = false;
        globalState.message = '';
        globalState.resolver = null;
    }

    return {
        state: readonly(globalState),
        confirmation: (message) => {
            globalState.message = message;
            globalState.show = true;

            return new Promise((resolver) => globalState.resolver = resolver);
        },
        confirm: () => {
            if (globalState.resolver) {
                globalState.resolver(true);
            }
            resetModel();
        },
        cancel: () => {
            if (globalState.resolver) {
                globalState.resolver(false);
            }
            resetModel();
        },
    };
}
