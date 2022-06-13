module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            typography: (theme) => ({
                DEFAULT: {
                    css: {
                        color: theme('colors.gray.900'),
                        a: {
                            'text-decoration': 'none',
                            color: theme('colors.green.500'),
                            'border-bottom': `2px solid ${theme('colors.green.100')}`,
                            'padding-bottom': theme('padding')['0.5'],
                            '&:hover': {
                                color: theme('colors.green.700'),
                            },
                        },
                        'code::before': {
                            content: '""',
                        },
                        'code::after': {
                            content: '""',
                        },
                        code: {
                            color: '#ec4073',
                            'background-color': 'rgba(236, 64, 115, 0.1)',
                            'border-radius': theme('borderRadius.DEFAULT'),
                            padding: `${theme('padding')[0.5]}`,
                        },
                    },
                },
            }),
        },
    },
    darkMode: "class",
    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
}