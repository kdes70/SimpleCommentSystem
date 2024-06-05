import {defineConfig} from 'vite';

export default defineConfig({
    root: 'app/assets',
    build: {
        outDir: './app/public/build',
        emptyOutDir: true,
        // rollupOptions: {
        //     input: {
        //         main: './app/app.js'
        //     }
        // }
    }
});
