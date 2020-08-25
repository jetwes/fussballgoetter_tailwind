const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    purge: {
        content: [
            './resources/views/*.php',
            './resources/views/**/*.php',
        ],
    },
  theme: {
      extend: {
          fontFamily: {
              sans: ['Inter var', ...defaultTheme.fontFamily.sans],
          },
      },
  },
  variants: {},
  plugins: [ require('@tailwindcss/ui'),],
}
