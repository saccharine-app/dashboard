<template>
  <section class="saccharine-dashboard__grid">
    <SummaryWidget
      v-for="summaryWidget in summaryWidgets"
      :key="summaryWidget.id"
      :title="summaryWidget.title"
      :value="summaryWidget.value"
      :tone="summaryWidget.tone"
    />
  </section>
  <section>
    <Widget v-for="widget in widgets"
      :key="widget.id"
      :title="widget.title"
      :rows="caseStore.filterCases(widget['filter_rules'])"
      :columns="widget['display_columns']"
    />
  </section>
</template>

<script setup lang="ts">
import SummaryWidget from './SummaryWidget.vue';
import { ref } from 'vue';
import Widget from './Widget.vue'
import { useCaseStore } from '../stores/cases';

const props = defineProps<{
  widgets: Record<string, any>[];
}>();

const caseStore = useCaseStore();

setTimeout(() => {
    caseStore.updateWaiverStatus("CASE-101", false);
}, 10000);

interface TriageWidget {
  id: string;
  title: string;
  value: string;
  tone: 'neutral' | 'info' | 'warning' | 'danger' | 'success';
}

const summaryWidgets: TriageWidget[] = [
  { id: 'open', title: 'Open Cases', value: '128', tone: 'info' },
  { id: 'urgent', title: 'Urgent', value: '7', tone: 'danger' },
  { id: 'review', title: 'Awaiting Review', value: '23', tone: 'warning' },
  { id: 'resolved', title: 'Resolved Today', value: '41', tone: 'success' },
];
</script>

