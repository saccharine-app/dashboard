<template>
  <div class="saccharine-dashboard flex flex-col gap-6">
    <header class="flex items-center justify-between pb-4 border-b border-gray-200">
      <div>
        <!--<h1 class="text-xl font-bold leading-7 text-gray-950">Operational Triage Board</h1>-->
        <p class="m-0 text-sm text-gray-500">Live multi-agent operational dispatch.</p>
      </div>
      <button 
        @click="caseStore.toggleSimulation()"
        :class="[
          'px-4 py-2 rounded-md text-sm font-semibold transition-colors', 
          caseStore.isSimulating ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-slate-900 text-white hover:bg-slate-800'
        ]"
      >
        {{ caseStore.isSimulating ? 'Stop Live Traffic' : 'Simulate Live Traffic' }}
      </button>
    </header>

    <Dashboard
      :widgets="widgets"
    />
  </div>
</template>

<script setup lang="ts">
import Dashboard from './components/Dashboard.vue';
import { useCaseStore } from './stores/cases';

const caseStore = useCaseStore();

const widgets = [
  {
    id: "widget_urgent_intake",
    title: "Urgent Intake Pipeline",
    theme: "danger",
    filter_rules: [
      { field: "priority", operator: "equals", value: "urgent" },
      { field: "status", operator: "not_equals", value: "resolved" }
    ],
    display_columns: [
      { label: "Case ID", field: "id" },
      { label: "Client Entity", field: "client" }
    ],
    actions: [
      { label: "Acknowledge", field: "priority", setValue: "high", class: "text-blue-600 hover:underline" }
    ]
  },
  {
    id: "widget_compliance_hold",
    title: "Compliance Hold (Missing Signatures)",
    theme: "warning",
    filter_rules: [
      { field: "status", operator: "equals", value: "compliance_hold" },
      { field: "waivers_signed", operator: "equals", value: false }
    ],
    display_columns: [
      { label: "Client Entity", field: "client" },
      { label: "Target Dispatch", field: "dispatch_date" }
    ],
    actions: [
      { label: "Override & Clear", field: "waivers_signed", setValue: true, class: "text-amber-600 hover:underline" }
    ]
  },
  {
    id: "widget_active_fulfillment",
    title: "Active Fulfillment",
    theme: "info",
    filter_rules: [
      { field: "status", operator: "equals", value: "active" },
    ],
    display_columns: [
      { label: "Case ID", field: "id" },
      { label: "Client Entity", field: "client" }
    ],
    actions: [
      { label: "Send to QA", field: "status", setValue: "qa_review", class: "text-green-600 hover:underline" }
    ]
  }
];
</script>
