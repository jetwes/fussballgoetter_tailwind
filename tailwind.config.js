module.exports = {
    purge: {
        content: [
            './resources/views/*.php',
            './resources/views/**/*.php',
        ],
    },
  theme: {},
  variants: {},
  plugins: [ require('@tailwindcss/ui'),],
}
