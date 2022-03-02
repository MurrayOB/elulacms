let mix = require("laravel-mix");

mix.browserSync("127.0.0.1:8000");

mix
  .js("resources/assets/js/app.js", "src/public/js")
  .sass("resources/assets/scss/app.scss", "src/public/css");
