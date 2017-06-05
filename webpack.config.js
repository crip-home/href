const ExtractTextPlugin = require('extract-text-webpack-plugin')
const path = require('path')
const webpack = require('webpack')

module.exports = {
  devtool: '#source-map',
  context: path.join(__dirname, 'resources/assets'),
  entry: {
    app: ['babel-polyfill', './js/app.js'],
    vendor: ['babel-polyfill', 'vue', 'axios', 'vue-router']
  },
  output: {
    path: path.join(__dirname, './public/assets'),
    filename: '[name].js'
  },
  module: {
    loaders: [
      {enforce: 'pre', test: /\.js$|\.vue$/, loader: 'eslint-loader', exclude: /node_modules/, query: {fix: true}},
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
      {test: /\.woff($|\?)|\.woff2($|\?)|\.ttf($|\?)|\.eot($|\?)|\.svg($|\?)/, loader: 'url-loader'},
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
    new ExtractTextPlugin('styles.css'),
    new webpack.optimize.CommonsChunkPlugin({name: 'vendor', filename: 'vendor.js'})
  ]
}

if (process.env.NODE_ENV === 'production') {
  module.exports.plugins.push(
    new webpack.DefinePlugin({'process.env': {NODE_ENV: '"production"'}}),
    new webpack.optimize.UglifyJsPlugin({compress: {warnings: false}})
  )
}