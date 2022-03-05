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
      fontFamily: {

        'sans': ['Be Vietnam Pro'],
 
        // 'serif': ['ui-serif', 'Georgia', ...],
 
        // 'mono': ['ui-monospace', 'SFMono-Regular', ...],
 
        // 'display': ['Be Vietnam Pro'],
 
        // 'body': ['"Be Vietnam Pro"'],
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
        'blue-light': '#8ae2fe',
        'default': 'var(--text-default-color)',
        'accent': 'var(--text-accent-color)',
        'accent-light': 'var(--text-accent-light-color)',
        'muted': 'var(--text-muted-color)',
        'muted-light': 'var(--text-muted-light-color)',
        'page': 'var(--page-background-color)',
        'card': 'var(--card-background-color)',
        'button': 'var(--button-background-color)',
        'header': 'var(--header-background-color)',
        'page': 'var(--page-background-color)',
        'error': 'var(--text-error-color)',




      },
    },
  },
  plugins: [],
}

