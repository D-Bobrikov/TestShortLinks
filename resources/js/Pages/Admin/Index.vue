<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, Link } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";

defineProps({
    sources: {
        type: Object,
    },
});

const destroySource = async (id) => {
    if (confirm("Вы точно хотите удалить источник ?")) {
        await router.delete(`/dashboard/delete/${id}`);
    }
};

const sourceName = ref("");
const sourceStore = async () => {
    await router.post(`/dashboard/store`, {
        name: sourceName.value,
    });
    sourceName.value = "";
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sources
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div>
                    <div class="mb-3">
                        <input
                            type="text"
                            placeholder="Enter the source name"
                            v-model="sourceName"
                        />
                    </div>
                    <PrimaryButton @click="sourceStore" class="my-1"
                        >Create source
                    </PrimaryButton>
                </div>
                <!-- Table -->
                <table
                    v-if="sources.data.length > 0"
                    class="min-w-full border-collapse block md:table"
                >
                    <thead class="block md:table-header-group">
                        <tr
                            class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto md:relative"
                        >
                            <th
                                class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell"
                            >
                                ID
                            </th>
                            <th
                                class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell"
                            >
                                Name
                            </th>
                            <th
                                class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell"
                            >
                                Token
                            </th>
                            <th
                                class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="block md:table-row-group">
                        <tr
                            v-for="source in sources.data"
                            :key="source.id"
                            class="bg-gray-300 border border-grey-500 md:border-none block md:table-row"
                        >
                            <td
                                class="p-2 md:border md:border-grey-500 text-left block md:table-cell"
                            >
                                {{ source.id }}
                            </td>
                            <td
                                class="p-2 md:border md:border-grey-500 text-left block md:table-cell"
                            >
                                {{ source.name }}
                            </td>
                            <td
                                class="p-2 md:border md:border-grey-500 text-left block md:table-cell"
                            >
                                {{ source.token }}
                            </td>
                            <td
                                class="p-2 md:border md:border-grey-500 text-left block md:table-cell"
                            >
                                <Link
                                    :href="route('dashboard.edit')"
                                    method="get"
                                    :data="{ id: source.id }"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded mx-1"
                                >
                                    Edit
                                </Link>
                                <button
                                    @click="destroySource(source.id)"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded mx-1"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <h2 v-else>Sources have not yet been created</h2>

                <!-- Paginate -->
                <Pagination :links="sources.links" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
