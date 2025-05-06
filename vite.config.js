import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import postcssNesting from 'postcss-nesting';
import tailwindcss from 'tailwindcss';
import autoprefixer from 'autoprefixer';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    optimizeDeps: {
        include: ['gsap', 'alpinejs']
    },
    css: {
        postcss: {
            plugins: [
                postcssNesting,
                tailwindcss,
                autoprefixer,
            ],
        },
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    gsap: ['gsap'],
                    alpine: ['alpinejs']
                }
            }
        }
    },
    resolve: {
        alias: {
            '@': '/resources',
        }
    },
});