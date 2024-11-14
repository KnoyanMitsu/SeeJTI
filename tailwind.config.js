/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  theme: {
    extend: {
      fontFamily: {
        "sans": ['Plus Jakarta Sans', 'sans-serif']
      },
      keyframes: {
        blur: {
          '0%, 100%': { filter: 'blur(63px)' }, // Blur pada 0% dan kembali ke 0px di 100%
          '50%': { filter: 'blur(62px)' },
        },
        move: {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(100px)' },
        }
      },
      animation: {
        blur: 'blur 5s ease-in-out infinite',
        move: 'move 10s ease-in-out infinite',
      }
    },
  },
  plugins: [],
}
