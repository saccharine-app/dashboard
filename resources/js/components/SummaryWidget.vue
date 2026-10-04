<template>
  <article class="saccharine-widget" :class="`saccharine-widget--${tone}`">
    <span class="saccharine-widget__title">{{ title }}</span>
    <span class="saccharine-widget__value">{{ value }}</span>
  </article>
</template>

<script setup lang="ts">
withDefaults(
  defineProps<{
    title: string;
    value: string | number;
    tone?: 'neutral' | 'info' | 'warning' | 'danger' | 'success';
  }>(),
  {
    tone: 'neutral',
  },
);
</script>

