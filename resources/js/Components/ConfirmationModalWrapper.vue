<script setup>

import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useConfirm} from "@/Utilities/Composables/useConfirm.js";

const {state, confirm, cancel} = useConfirm();

</script>

<template>
    <ConfirmationModal :show="state.show">
        <template #title>
            {{ state.message }}
        </template>
        <template #footer>
            <SecondaryButton @click="cancel">Cancel</SecondaryButton>
            <PrimaryButton @click="confirm" class="ml-3">Confirm</PrimaryButton>
        </template>
    </ConfirmationModal>
</template>
