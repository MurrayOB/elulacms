let mix = require("laravel-mix");

mix.browserSync("127.0.0.1:8000");

mix
  .js("resources/assets/js/app.js", "public/assets/js")
  .vue({ version: 2 })
  .sass("resources/assets/scss/app.scss", "public/assets/css");
