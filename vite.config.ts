import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vite.dev/config/
export default defineConfig({
  plugins: [vue()],
  // Statically replace Node globals for browser runtime
  define: {
    'process.env.NODE_ENV': JSON.stringify(process.env.NODE_ENV || 'production'),
    'process.env': {},
  },
  resolve: {
    alias: {
      // Source lives in resources/js, not the PHP src/ directory.
      '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
    },
  },
  build: {
    // Built assets live in the package's public/ dir and are served by
    // DashboardServiceProvider via the named "saccharine-dashboard.asset"
    // route. This mirrors the sibling saccharine/bpmn-engine package.
    outDir: 'public',
    emptyOutDir: true,
    cssCodeSplit: false, // Emit a single dashboard.css alongside dashboard.js
    lib: {
      entry: 'resources/js/main.ts',
      name: 'SaccharineDashboard',
      fileName: () => 'dashboard.js',
      formats: ['iife'], // IIFE runs immediately when loaded via <script>
    },
    rollupOptions: {
      output: {
        assetFileNames: (assetInfo) => {
          if (assetInfo.name?.endsWith('.css')) return 'dashboard.css';
          return assetInfo.name || '';
        },
      },
    },
  },
})
