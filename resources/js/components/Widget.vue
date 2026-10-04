<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
  title?: string; // use lowercase string for TS types
  rows: Record<string, any>[];
  columns: Record<string, any>[];
}>();

// Empty states matter on a triage board: a widget can legitimately filter to
// zero cases, and an empty <table> renders as a blank card with no explanation.
const isEmpty = computed(() => props.rows.length === 0);
</script>

<template>
    <section class="saccharine-table overflow-hidden">
        <header
            v-if="title"
            class="border-b border-gray-200 px-4 py-3"
        >
            <h3 class="text-sm font-semibold text-gray-950">
                {{ title }}
            </h3>
        </header>

        <p
            v-if="isEmpty"
            class="px-4 py-6 text-sm text-gray-500"
        >
            No matching cases.
        </p>

        <div
            v-else
            class="overflow-x-auto"
        >
            <table class="w-full border-collapse text-left text-sm">
                <caption class="sr-only">
                    {{ title ?? 'Case list' }}
                </caption>
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            v-for="column in columns"
                            :key="column.field"
                            scope="col"
                            class="px-4 py-2 text-xs font-semibold tracking-wider text-gray-500 uppercase whitespace-nowrap"
                        >
                            {{ column.label }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr
                        v-for="row in rows"
                        :key="row.id"
                        class="transition-colors hover:bg-gray-50"
                    >
                        <td
                            v-for="column in columns"
                            :key="column.field"
                            class="px-4 py-2.5 text-gray-950 whitespace-nowrap"
                        >
                            {{ row[column.field] }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>