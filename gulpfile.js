var elixir = require('laravel-elixir');

elixir.config.publicPath = 'src/Assets/dist/';
elixir.config.assetsPath = 'src/Assets/';

elixir(function(mix) {
    mix.styles([]);
    mix.scripts([]);
});
