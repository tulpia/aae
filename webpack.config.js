const path = require('path');

const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CleanWebpackPlugin = require('clean-webpack-plugin');

module.exports = {
    output: {
      path: path.resolve(__dirname, 'public/view/dist')
    },
    resolve: {
      alias: {
        '@font': path.resolve(__dirname, 'src/fonts'),
        '@img': path.resolve(__dirname, 'src/images'),
        '@svg': path.resolve(__dirname, 'src/svg'),
        '@js': path.resolve(__dirname, 'src/js')
      }
    },
    devServer: {
      contentBase: path.resolve(__dirname, 'public')
    },
    module: {
      rules: [
        {
          test: /\.js$/,
          exclude: /node_modules/,
          use: {
            loader: "babel-loader"
          }
        },
        {
          test: /\.scss$/,
          use: [
            MiniCssExtractPlugin.loader,
            "css-loader",
            "postcss-loader",
            "sass-loader"
          ]
        },
        {
          test: /\.(woff(2)?|ttf|eot)(\?v=\d+\.\d+\.\d+)?$/,
          use: [{
              loader: 'file-loader',
              options: {
                  name: '[name].[ext]',
                  outputPath: 'fonts/'
              }
          }]
        },
        {
          test: /\.(png|jpg|gif)$/,
          use: [
            {
              loader: 'file-loader',
              options: {
                name: '[name].[ext]',
                outputPath: 'images/'
            }
            },
          ],
        },
        {
          test: /\.svg$/,
          use: [{
            loader: 'file-loader',
            options: {
                name: '[name].[ext]',
                outputPath: 'svg/'
            }
          }]
        }
      ]
    },
    plugins: [
      new CleanWebpackPlugin('dist', {
        exclude: ['images']
      }),
      new MiniCssExtractPlugin({
        filename: './styles.css',
      })
    ]
  };