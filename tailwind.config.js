/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
  safelist: [
    'bg-red-400', 'bg-red-100', 'border-red-400', 'text-red-700', 'text-red-500',
    'bg-green-400', 'bg-green-100', 'border-green-400', 'text-green-700', 'text-green-500',
    'bg-yellow-400', 'font-xs'
  ],
}

