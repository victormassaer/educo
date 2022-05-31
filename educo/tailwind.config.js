const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "#325299",
                "primary-blue": "#325299",
                secondary: "#FF8979",
                tertiary: "#69B3DB",
            },
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
