<template>
  <section class="grid grid-cols-[repeat(auto-fill,minmax(12rem,1fr))] gap-4">
    <SummaryWidget
      v-for="summaryWidget in summaryWidgets"
      :key="summaryWidget.id"
      :title="summaryWidget.title"
      :value="summaryWidget.value"
      :tone="summaryWidget.tone"
    />
  </section>
  <!-- Main Widgets: Updated to a 3-column grid with items-start so they don't vertically stretch to match each other -->
  <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 items-start">
    <Widget v-for="widget in widgets"
      :key="widget.id"
      :title="widget.title"
      :rows="caseStore.filterCases(widget.filter_rules)"
      :columns="widget.display_columns"
      :actions="widget.actions"
    />
  </section>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import SummaryWidget from './SummaryWidget.vue';
import Widget from './Widget.vue'
import { useCaseStore } from '../stores/cases';

const props = defineProps<{
  widgets: Record<string, any>[];
}>();

const caseStore = useCaseStore();

interface SummaryData {
  id: string;
  title: string;
  value: number | string;
  tone: 'neutral' | 'info' | 'warning' | 'danger' | 'success';
}

// Wrap the summary definitions in a computed property so they recalculate 
// automatically whenever the caseStore mutates via the simulator or user clicks.
const summaryWidgets = computed<SummaryData[]>(() => [
  { 
    id: 'urgent', 
    title: 'Urgent Priorities', 
    value: caseStore.filterCases([{ field: 'priority', operator: 'equals', value: 'urgent' }]).length, 
    tone: 'danger' 
  },
  { 
    id: 'holds', 
    title: 'Compliance Holds', 
    value: caseStore.filterCases([{ field: 'status', operator: 'equals', value: 'compliance_hold' }]).length, 
    tone: 'warning' 
  },
  { 
    id: 'active', 
    title: 'Active Fulfillment', 
    value: caseStore.filterCases([{ field: 'status', operator: 'equals', value: 'active' }]).length, 
    tone: 'info' 
  },
  { 
    id: 'resolved', 
    title: 'Resolved Operations', 
    value: caseStore.filterCases([{ field: 'status', operator: 'equals', value: 'resolved' }]).length, 
    tone: 'success' 
  },
]);
</script>

