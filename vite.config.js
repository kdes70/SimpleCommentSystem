import {defineConfig} from 'vite';

export default defineConfig({
    root: './app/public',
    build: {
        outDir: './dist',
        emptyOutDir: true,
        rollupOptions: {
            input: [
                './app/assets/js/app.js',
                './app/assets/css/styles.css'
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
