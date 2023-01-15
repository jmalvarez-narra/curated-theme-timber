const dest = './dist'

function getCopyConfig (source) {
  return {
    from: source,
    to: './',
    noErrorOnMissing: true,
    globOptions: {
      ignore: [
        '**/*.js',
        '**/*.scss',
        '**/*.php',
        '**/*.twig',
        '**/screenshot.png',
        '**/README.md'
      ]
    }
  }
}

module.exports = {
  webpack: {
    entry: {
      'assets/main': './assets/main.js',
    },
    copy: {
      patterns: [
        getCopyConfig('./assets/**/*')
      ]
    }
  },
  browserSync: {
    ghostMode: false,
    open: false,
    watchOptions: {
      ignoreInitial: true
    },
    injectChanges: true,
    reloadDebounce: 1000,
    ui: false,
    files: [
      '*.php',
      'templates/**/*'
    ],
    watch: true,
    https: true
  },
  webpackDevMiddleware: {
    stats: false,
    writeToDisk: true
  },
  gulp: {
    dest: dest,
    rev: {
      src: dest + '/**/*',
      srcRevved: [dest + '/**/*.{js,css}'],
      srcStatic: dest + '/**/*.{html,php,twig}',
      assetSrc: [
        dest + '/*.css',
        '!' + dest + '/**/*+(css|js)'
      ],
      revvedFileExtensions: ['.js', '.css'],
      staticFileExtensions: ['.html', '.php', '.twig']
    },
    replaceVersion: {
      wordpress: {
        files: './style.css',
        from: /Version: (.*)/gi,
        to: 'Version: '
      },
      php: {
        files: '!(node_modules|dist)/**/*.php',
        from: '%%NEXT_VERSION%%'
      },
      js: {
        files: '!(node_modules|dist)/**/*.js',
        from: '%%NEXT_VERSION%%'
      }
    }
  }
}
