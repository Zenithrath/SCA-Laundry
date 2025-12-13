import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            // UBAH: dari 'app.jsx' menjadi 'app.js'
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        // HAPUS: baris 'react(),' dibuang karena kamu tidak pakai React lagi
    ],
});
