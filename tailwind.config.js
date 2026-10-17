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
                primary: '#003366',  
                secondary: '#800020', 
                cream: '#F4F1EA',     
            },
            fontFamily: {
                arabic: ['Cairo', 'Tajawal', 'sans-serif'],
            }
        },
    },
    plugins: [],
}

