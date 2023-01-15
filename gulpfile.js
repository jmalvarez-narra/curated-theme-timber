const gulp = require('gulp')
const config = require('./build-config').gulp

function revAssets (config) {
  // 1) Add md5 hashes to assets referenced by CSS and JS files
  gulp.task('revAssets', function () {
    const path = require('path')
    const rev = require('gulp-rev')
    const revNapkin = require('gulp-rev-napkin')
    // Ignore files that may reference assets. We'll rev them next.
    return gulp.src(config.rev.assetSrc)
      .pipe(rev())
      .pipe(gulp.dest(config.dest))
      .pipe(revNapkin({ verbose: false }))
      .pipe(rev.manifest(path.join(config.dest, 'rev-manifest.json'), { merge: true, base: config.dest }))
      .pipe(gulp.dest(config.dest))
  })
}

function revRevvedFiles (config) {
  // 3) Rev and compress CSS and JS files (this is done after assets, so that if a
  //    referenced asset hash changes, the parent hash will change as well
  gulp.task('revRevvedFiles', function () {
    const path = require('path')
    const rev = require('gulp-rev')
    const revNapkin = require('gulp-rev-napkin')
    return gulp.src(config.rev.srcRevved)
      .pipe(rev({
        replaceInExtensions: config.rev.revvedFileExtensions
      }))
      .pipe(gulp.dest(config.dest))
      .pipe(revNapkin({ verbose: false }))
      .pipe(rev.manifest(path.join(config.dest, 'rev-manifest.json'), { merge: true, base: config.dest }))
      .pipe(gulp.dest(config.dest))
  })
}

function revUpdateReferences (config) {
  // 2) Update asset references with reved filenames in compiled css + js
  gulp.task('revUpdateReferences', function () {
    const path = require('path')
    const rewrite = require('gulp-rev-rewrite')
    var manifest = gulp.src(path.join(config.dest, 'rev-manifest.json'), {"allowEmpty": true})

    return gulp.src(config.rev.srcRevved)
      .pipe(rewrite({ manifest: manifest }))
      .pipe(gulp.dest(config.dest))
  })
}

function rev () {
  gulp.task('rev', gulp.series([
    // 1) Add md5 hashes to assets referenced by CSS and JS files
    'revAssets',
    // 2) Update asset references (images, fonts, etc) with reved filenames in compiled css + js
    'revUpdateReferences',
    // 3) Rev and compress CSS and JS files (this is done after assets, so that if a referenced asset hash changes, the parent hash will change as well
    'revRevvedFiles',
  ]))
}

revAssets(config)
revUpdateReferences(config)
revRevvedFiles(config)
rev()
