const ExtractTextPlugin = require('extract-text-webpack-plugin')
const path = require('path')
const webpack = require('webpack')
const version = process.env.VERSION || require('./package.json').version

module.exports = {
  devtool: '#eval-source-map',
  context: path.join(__dirname, 'resources/assets'),
  entry: {
    app: './js/app.js',
    navbar: './js/navbar.js',
    vendor: ['vue', 'axios', 'vue-router', 'crip-vue-bootstrap-modal', 'jquery',
      'bootstrap-sass']
  },
  output: {
    path: path.join(__dirname, './public/assets'),
    filename: '[name].js'
  },
  module: {
    loaders: [
      {
        enforce: 'pre',
        test: /\.js$|\.vue$/,
        loader: 'eslint-loader',
        exclude: /node_modules/,
        query: {fix: true}
      },
      {
        test: /\.vue$/,
        loader: 'vue-loader',
        exclude: /node_modules/,
        options: {
          loaders: {
            js: 'babel-loader',
            i18n: '@kazupon/vue-i18n-loader'
          }
        }
      },
      {test: /\.js$/, loader: 'babel-loader', exclude: /node_modules/},
      {
        test: /\.woff($|\?)|\.woff2($|\?)|\.ttf($|\?)|\.eot($|\?)|\.svg($|\?)/,
        loader: 'url-loader'
      },
      {
        test: /\.scss$|\.css$/,
        exclude: /node_modules/,
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader',
          use: ['css-loader', 'sass-loader']
        })
      }
    ]
  },
  plugins: [
    new webpack.LoaderOptionsPlugin({
      minimize: true,
      progress: true,
      hide_modules: true
    }),
    new webpack.DefinePlugin({
      'process.env.NODE_ENV': JSON.stringify(process.env.NODE_ENV || 'development')
    }),
    new webpack.BannerPlugin({
      banner: `/*!
* Crip hrefs v${version}
* Forged by Igors Krasjukovs <tahq69@gmail.com>
* Released under the MIT License.
*/   `,
      raw: true,
      entryOnly: true
    }),
    new ExtractTextPlugin('styles.css'),
    new webpack.optimize.CommonsChunkPlugin({
      name: 'vendor',
      filename: 'vendor.js'
    }),
    new webpack.ProvidePlugin({jQuery: 'jquery', $: 'jquery', jquery: 'jquery'})
  ]
}

if (process.env.NODE_ENV === 'production') {
  module.exports.devtool = '#source-map'
  module.exports.plugins.push(
    new webpack.DefinePlugin({'process.env': {NODE_ENV: '"production"'}}),
    new webpack.optimize.UglifyJsPlugin({compress: {warnings: false}})
  )
}