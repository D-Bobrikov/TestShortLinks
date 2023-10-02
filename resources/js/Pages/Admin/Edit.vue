<script setup>
import SecondaryButton from "@/Components/SecondaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
    source: {
        type: Object,
    },
});

const gToken = ref(false);
const page = usePage();

const updateSource = async () => {
    await router.put(`/dashboard/update`, {
        id: page.props.source.id,
        name: page.props.source.name,
        token: page.props.source.token,
        gToken: gToken.value,
    });
};
</script>

<template>
    <Head title="Edit source" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit source
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form class="w-full max-w-lg">
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label
                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            >
                                Name
                            </label>
                            <input
                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                type="text"
                                v-model="source.name"
                            />
                            <p class="text-gray-600 text-xs italic">
                                <!-- После можно использовать для валидации -->
                            </p>
                        </div>

                        <div class="w-full px-3">
                            <label
                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            >
                                Token
                            </label>
                            <input
                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                type="text"
                                :disabled="true"
                                v-model="source.token"
                            />
                            <p class="text-gray-600 text-xs italic">
                                <!-- После можно использовать для валидации -->
                            </p>
                        </div>

                        <div class="w-full px-3">
                            <label
                                class="md:w-2/3 block text-gray-500 font-bold"
                            >
                                <input
                                    class="mr-2 leading-tight"
                                    type="checkbox"
                                    v-model="gToken"
                                />
                                <span class="text-sm"
                                    >Generate a new token</span
                                >
                            </label>
                        </div>
                        <SecondaryButton
                            class="w-3/12 my-2"
                            @click="updateSource"
                            >Edit</SecondaryButton
                        >
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
