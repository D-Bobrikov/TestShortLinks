<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    links: {
        type: Array,
    },
});
</script>

<template>
    <nav v-if="links.length > 3" class="py-2 flex items-center justify-center">
        <Link
            v-for="(link, k) in links"
            v-html="link.label"
            :key="k"
            :href="link.url ? link.url : ''"
            :disabled="link.url === null"
            :class="{ 'text-red-500 font-bold': link.active }"
            class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
        ></Link>
    </nav>
</template>
