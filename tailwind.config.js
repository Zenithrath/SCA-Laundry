import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.jsx", // PENTING: Agar file React terbaca
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", "sans-serif"],
            },
            colors: {
                primary: "#1e3a8a",
                secondary: "#eef6ff",
                cardblue: "#dbeafe",
                inputgray: "#f3f4f6",
            },
            boxShadow: {
                soft: "0 10px 40px -10px rgba(0,0,0,0.08)",
                glow: "0 0 20px rgba(59, 130, 246, 0.5)",
            },
        },
    },
    plugins: [],
};
