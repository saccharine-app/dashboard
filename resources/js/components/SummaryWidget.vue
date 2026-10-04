<template>
  <article
    class="saccharine-widget flex flex-col gap-1 border-l-4 p-4"
    :class="TONE_CLASSES[tone]"
  >
    <span class="text-xs font-semibold tracking-wider text-gray-500 uppercase">{{ title }}</span>
    <span class="text-3xl leading-none font-bold text-gray-950">{{ value }}</span>
  </article>
</template>

<script setup lang="ts">
type Tone = 'neutral' | 'info' | 'warning' | 'danger' | 'success';

withDefaults(
  defineProps<{
    title: string;
    value: string | number;
    tone?: Tone;
  }>(),
  {
    tone: 'neutral',
  },
);

// These class names MUST be written out in full: Tailwind scans source files as
// text, so an interpolated `border-${tone}-500` would match nothing and silently
// emit no CSS at all. Keying off a static map keeps every variant discoverable.
const TONE_CLASSES: Record<Tone, string> = {
  neutral: 'border-l-gray-200',
  info: 'border-l-info-500',
  warning: 'border-l-warning-500',
  danger: 'border-l-danger-500',
  success: 'border-l-success-500',
};
</script>

