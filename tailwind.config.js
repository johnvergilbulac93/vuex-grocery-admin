module.exports = {
    // purge: [],
    purge: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue"
        // './resources/views/**/*.blade.php',
        // './resources/views/layouts/**/*.blade.php',
        // './resources/js/components/admin/pages/*.'
    ],
    darkMode: "media", // or 'media' or 'class'
    theme: {
        container: {
            center: true
        },
        screens: {
            sm: "320px",
            md: "480px",
            lg: "768px",
            xl: "1050px",
            xxl: "1680px", 
        },
        extend: {
            outline: {
                blue: "2px solid #0000ff"
            },
            fontFamily: {
                rubik: ["Rubik", "sans-serif"],
                helve: ["Helvetica"],
                inter: ['Inter','sans-serif'],
            }
        }
    },
    variants: {
        extend: {
            opacity: ["disabled"],
            backgroundColor: ["checked"],
            borderColor: ["checked"]
        }
    },
    plugins: [require("@tailwindcss/forms")]
};
