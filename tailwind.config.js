/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.jsx",
    "./src/**/*.{js,jsx}" // Por si acaso sí creaste la carpeta src
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
