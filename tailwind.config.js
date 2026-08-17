module.exports = {
  content: [
    './*.php',      // All PHP files
    './**/*.php',      // All PHP files
    './**/**/*.php',      // All PHP files
    './**/**/**/*.php',      // All PHP files
    './**/**/**/**/*.php',      // All PHP files
    './assets/js/**/*.js' // Optional JS if you use scripts
  ],
  theme: {
    extend: {
      colors: {
        primary: '#F2ECE2',       // sand
        secondary: '#ff6600',     // accent orange
        accent: '#e5f4ff',        // light highlight
        lightsand: '#EBE2D4',
        black: '#000000',
        white: '#ffffff',
        red: '#CB0513',           // E10010
        darkgreen: '#2B4D18',
        lightgreen: '#347A28',
        neutral: {
          100: '#f5f5f5',
          200: '#e5e5e5',
          300: '#d4d4d4',
          400: '#a3a3a3',
          500: '#737373',
        },
      },
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
      },
    },
  },
  plugins: [],
};
