/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'sidebar': {
          'dark': '#1a2e1a',
          'darker': '#142114',
          'light': '#2d4a2d',
          'hover': '#3d5a3d',
          'active': '#4d6a4d',
        },
        'primary': {
          DEFAULT: '#2e7d32',
          'dark': '#1b5e20',
          'light': '#4caf50',
        },
      },
    },
  },
  plugins: [],
}
