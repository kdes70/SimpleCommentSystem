import {defineConfig} from 'vite';

export default defineConfig({
    root: 'src/assets',
    build: {
        outDir: 'src/app/public/dist'
    }
});