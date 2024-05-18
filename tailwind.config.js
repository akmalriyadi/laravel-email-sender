/** @type {import('tailwindcss').Config} */

export default {
  content: [
    './resources/js/**/*.vue',
    'node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx}'
  ],
  corePlugins: {
    container: false
  },
  theme: {
    extend: {
      colors: {
        // primary: style.primary,
      }
    },
  },
  plugins: [],
}

