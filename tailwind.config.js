module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      boxShadow: {
        // '3xl': '0 35px 60px -15px rgba(0, 0, 0, 0.3)',
      },
      colors: {
        // transparent: 'transparent',
        // current: 'currentColor',
        // 'white': '#ffffff',
        // 'purple': '#3f3cbb',
        // 'midnight': '#121063',
        // 'metal': '#565584',
        // 'tahiti': '#3ab7bf',
        // 'silver': '#ecebff',
        // 'bubble-gum': '#ff77e9',
        // 'bermuda': '#78dcca',
        'grey-light': '#F5F6F9',
        'grey': 'rgba(0,0,0,0.4)',
        'blue': '#47cdff',
        'blue-light': '#8ae2fe'


      },
    },
  },
  plugins: [],
}

