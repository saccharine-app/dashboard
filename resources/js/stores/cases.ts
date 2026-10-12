// resources/js/stores/cases.ts
import { ref } from 'vue';
import { defineStore } from 'pinia';

export const useCaseStore = defineStore('cases', () => {
    // 1. Richer Dataset simulating complex operations
    const cases = ref([
        { id: "CASE-101", client: "Apex Corp", status: "compliance_hold", priority: "high", waivers_signed: false, dispatch_date: "2026-10-06" },
        { id: "CASE-102", client: "Liminal LLC", status: "active", priority: "normal", waivers_signed: true, dispatch_date: "2026-10-07" },
        { id: "CASE-103", client: "Aegis Logistics", status: "intake", priority: "urgent", waivers_signed: false, dispatch_date: "2026-10-06" },
        { id: "CASE-104", client: "Stratos Inc", status: "active", priority: "normal", waivers_signed: true, dispatch_date: "2026-10-06" },
        { id: "CASE-105", client: "Vanguard Ops", status: "qa_review", priority: "high", waivers_signed: true, dispatch_date: "2026-10-05" },
        { id: "CASE-106", client: "Meridian Flow", status: "compliance_hold", priority: "normal", waivers_signed: false, dispatch_date: "2026-10-08" },
    ]);

    const isSimulating = ref(false);
    let simulationInterval: number | null = null;

    // 2. Dynamic Filtering Logic
    function filterCases(filterRules: any[]) {
        return cases.value.filter((c: Record<string, any>) => {
            return filterRules.every(rule => {
                if (rule.operator === 'equals') return c[rule.field] === rule.value;
                if (rule.operator === 'not_equals') return c[rule.field] !== rule.value;
                return true;
            });
        });
    }

    // 3. User Interaction Actions
    function updateCaseField(id: string, field: string, value: any) {
        const target = cases.value.find(c => c.id === id);
        if (target) {
            (target as Record<string, any>)[field] = value;
            
            // Auto-resolve compliance holds if waivers are signed
            if (field === 'waivers_signed' && value === true && target.status === 'compliance_hold') {
                target.status = 'active';
            }
        }
    }

    // 4. Live Traffic Simulator (Mimics other users/systems)
    function toggleSimulation() {
        if (isSimulating.value) {
            clearInterval(simulationInterval!);
            isSimulating.value = false;
        } else {
            isSimulating.value = true;
            simulationInterval = setInterval(() => {
                // Pick a random case and randomly advance its state or priority
                const randomIndex = Math.floor(Math.random() * cases.value.length);
                const randomCase = cases.value[randomIndex];
                const actions = ['escalate', 'sign_waiver', 'complete_review'];
                const randomAction = actions[Math.floor(Math.random() * actions.length)];

                if (randomAction === 'escalate' && randomCase?.priority === 'normal') {
                    randomCase.priority = 'urgent';
                } else if (randomAction === 'sign_waiver' && !randomCase?.waivers_signed) {
                    if (randomCase?.id) {
                        updateCaseField(randomCase.id, 'waivers_signed', true);
                    }
                } else if (randomAction === 'complete_review' && randomCase?.status === 'qa_review') {
                    randomCase.status = 'resolved';
                }
            }, 3500) as unknown as number; // Fires every 3.5 seconds
        }
    }

    return { cases, isSimulating, filterCases, updateCaseField, toggleSimulation };
});