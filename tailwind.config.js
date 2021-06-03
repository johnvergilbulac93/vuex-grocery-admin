module.exports = {
  // purge: [],
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    // './resources/views/**/*.blade.php',
    // './resources/views/layouts/**/*.blade.php',
    // './resources/js/components/admin/pages/*.'
  ],
  darkMode: 'media', // or 'media' or 'class'
  theme: {
    container: {
      center: true,
    },
    screens: {
      'sm': '500px',
      // => @media (min-width: 500px) { ... }

      'md': '756px',
      // => @media (min-width: 768px) { ... }

      'lg': '1024px',
      // => @media (min-width: 1024px) { ... }

      'xl': '1280px',
      // => @media (min-width: 1280px) { ... }

      '2xl': '1536px',
      // => @media (min-width: 1536px) { ... }
    },
    extend: {
      outline: {
        blue: '2px solid #0000ff',
      },
      fontFamily: {
        poppins: ['Poppins','sans-serif']
      }
    },
  },
  variants: {
    extend: {
      opacity: ['disabled'],
      backgroundColor: ['checked'],
      borderColor: ['checked'],
    },
  },
  plugins: [],
}
