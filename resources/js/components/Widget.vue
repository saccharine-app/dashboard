<script setup lang="ts">
const props = defineProps<{
  title?: string; // use lowercase string for TS types
  rows: Record<string, any>[];
  columns: Record<string, any>[];
}>();
</script>

<template>
    <table>
        <caption>{{ title }}</caption>
        <thead>
            <tr>
                <td v-for="column in columns" :key="column.field">
                {{ column.label }}
                </td>
            </tr>
        </thead>
        <tbody>
            <tr v-for="row in rows" :key="row.id">
                <td v-for="column in columns" :key="column.field">
                {{ row[column.field] }}
                </td>
            </tr>
        </tbody>
    </table>
</template>