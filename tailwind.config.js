const { colors } = require('tailwindcss/defaultTheme')
module.exports = {

  theme: {
      colors: {
          black: colors.black,
          white: colors.white,
          red: colors.red,
          green: colors.green,
          indigo: colors.indigo,
      }
  },
  variants: {},
  plugins: [ require('@tailwindcss/ui'),],
}
