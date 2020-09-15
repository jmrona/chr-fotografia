module.exports = {
    devServer: {
      proxy: 'http://laravel.test'
    },

     // output built static files to Laravel's public dir.
     // note the "build" script in package.json needs to be modified as well.
     outputDir: '../../../public/assets/app',

     publicPath: process.env.NODE_ENV === 'production'
      ? '/chr-fotografia/' //nombre de tu proyecto GitHub
      : '/',

     // modify the location of the generated HTML file.
     indexPath: process.env.NODE_ENV === 'production'
       ? '../../../views/layouts/app.blade.php'
       : 'index.html'
   }
