// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';

// export default defineConfig({
//     plugins: [
//         laravel({
//             input: ['resources/css/app.css', 'resources/js/app.js'],
//             refresh: true,
//         }),
//     ],
// });

import { defineConfig } from 'vite';

// Dynamically import the laravel-vite-plugin as an ES Module
const laravel = await import('laravel-vite-plugin');

export default defineConfig({
  plugins: [
    laravel.default(), // or laravel() depending on how it's exported
  ],
});
