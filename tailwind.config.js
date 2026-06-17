/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './views/**/*.php',
        './public/**/*.php',
        './app/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                base: '#06060f',
                card: 'rgba(255,255,255,0.03)',
                accent: '#00f5d4',
                violet: '#7b61ff',
                rose: '#ff6b9d',
            },
            fontFamily: {
                display: ['"Space Grotesk"', 'sans-serif'],
                body: ['Inter', 'sans-serif'],
            },
        },
    },
    plugins: [],
};
