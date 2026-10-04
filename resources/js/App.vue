<template>
  <div class="saccharine-dashboard">
    <header class="saccharine-dashboard__header">
      <h1>Operational Triage Board</h1>
      <p class="saccharine-dashboard__subtitle">Live snapshot of operational workload.</p>
    </header>

    <Dashboard
      :widgets="widgets"
    />
  </div>
</template>

<script setup lang="ts">
import Dashboard from './components/Dashboard.vue';

const widgets = [
  {
    "id": "widget_compliance_hold",
    "title": "Compliance Hold (Missing Waivers)",
    "theme": "amber",
    "filter_rules": [
      { "field": "status", "operator": "equals", "value": "active" },
      { "field": "missing_waiver", "operator": "equals", "value": true }
    ],
    "display_columns": [
      { "label": "ID", "field": "id" },
      { "label": "Client", "field": "client" }
    ]
  },
  {
    "id": "widget_dispatch_date",
    "title": "Dispatch Date",
    "theme": "amber",
    "filter_rules": [
      { "field": "status", "operator": "equals", "value": "active" },
    ],
    "display_columns": [
      { "label": "Client", "field": "client" },
      { "label": "Dispatch Date", "field": "dispatch_date" }
    ]
  }
]
</script>
