import {defineConfig} from 'vite';

export default defineConfig({
    root: './public',
    build: {
        outDir: './dist',
        emptyOutDir: true,
        rollupOptions: {
            input: [
                './assets/js/app.js',
                './assets/css/styles.css'
            ]
        },
        assetsDir: "",
        sourcemap: true,
        output: {
            manualChunks: undefined,
        },
        cssCodeSplit: false,
    }
});
