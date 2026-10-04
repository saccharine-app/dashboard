import { ref } from 'vue';
import { defineStore } from 'pinia';

export const useCaseStore = defineStore('cases', () => {
    const cases = ref([
        { "id": "CASE-101", "client": "Apex Corp", "status": "active", "missing_waiver": true, "dispatch_date": "2026-09-03" },
        { "id": "CASE-102", "client": "Liminal LLC", "status": "active", "missing_waiver": false, "dispatch_date": "2026-09-02" }
    ]);

    function filterCases(
        filterRules: ({ field: string; operator: string; value: string | boolean; })[]
    ) {
        return cases.value.filter((c: Record<string, any>) => {
            return filterRules.every(rule => {
                const fieldName: string = rule["field"]
                return c[fieldName] == rule["value"]
            });
        })
    }

    function updateWaiverStatus(id: string, missing_waiver: boolean) {
        const c = cases.value.find(item => item.id === id)
        if (c) {
            c.missing_waiver = missing_waiver
        }
    }

    return { cases, filterCases, updateWaiverStatus };
});