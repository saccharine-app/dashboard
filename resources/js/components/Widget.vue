<script setup lang="ts">
import { computed } from 'vue';
import { useCaseStore } from '../stores/cases';

const props = defineProps<{
  title?: string;
  rows: Record<string, any>[];
  columns: Record<string, any>[];
  actions?: Record<string, any>[]; // New prop for interactive buttons
}>();

const caseStore = useCaseStore();
const isEmpty = computed(() => props.rows.length === 0);

function handleAction(rowId: string, field: string, value: any) {
    caseStore.updateCaseField(rowId, field, value);
}
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
                        <td v-if="actions && actions.length > 0" class="px-4 py-2.5 text-right whitespace-nowrap">
                            <button 
                                v-for="action in actions" 
                                :key="action.label"
                                @click="handleAction(row.id, action.field, action.setValue)"
                                :class="['text-xs font-medium transition-colors', action.class]"
                            >
                                {{ action.label }}
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>