const dotenv = require('dotenv')
const path = require('path')
const { WebpackManifestPlugin } = require('webpack-manifest-plugin')
const WebpackNotifierPlugin = require('webpack-notifier')
const { CleanWebpackPlugin } = require('clean-webpack-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const RemoveEmptyScripts = require('webpack-remove-empty-scripts')
const CssMinimizerWebpackPlugin = require('css-minimizer-webpack-plugin')
const autoprefixer = require('autoprefixer')
const { getIfUtils, removeEmpty } = require('webpack-config-utils')
const HtmlWebpackPlugin = require('html-webpack-plugin')
const { ifProduction, ifDevelopment } = getIfUtils(process.env.NODE_ENV)
dotenv.config()

module.exports = {
  mode: ifProduction('production', 'development'),
  /**
   * Add your entry files here
   */
  entry: {
    'js/volunteer-form': './source/js/module/VolunteerForm/index.tsx',
    'js/assignment-form': './source/js/module/AssignmentForm/index.tsx',
  },

  /**
   * Output settings
   */
  output: {
    filename: '[name].[contenthash].js',
    path: path.resolve(__dirname, 'dist'),
    publicPath: '',
  },
  /**
   * Define external dependencies here
   */
  externals: {},
  module: {
    rules: [
      /**
       * Styles
       */
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader',
            options: {
              importLoaders: 3, // 0 => no loaders (default); 1 => postcss-loader; 2 => sass-loader
            },
          },
          {
            loader: 'postcss-loader',
            options: {
              postcssOptions: {
                plugins: [autoprefixer],
              },
            },
          },
          {
            loader: 'sass-loader',
            options: {},
          },
          'import-glob-loader',
        ],
      },
      {
        exclude: /node_modules\/(?!(@helsingborg-stad\/municipio-react-ui\/src)\/).*/,
        test: /\.tsx?$/,
        use: [
          {
            loader: 'babel-loader',
          },
          {
            loader: 'ts-loader',
            options: { allowTsInNodeModules: true },
          },
        ],
      },
    ],
  },
  resolve: {
    extensions: ['.tsx', '.ts', '.js'],
  },
  plugins: removeEmpty([
    /**
     * Fix CSS entry chunks generating js file
     */
    new RemoveEmptyScripts(),

    /**
     * Clean dist folder
     */
    new CleanWebpackPlugin(),
    /**
     * Output CSS files
     */
    new MiniCssExtractPlugin({
      filename: '[name].[contenthash].css',
    }),

    /**
     * Output manifest.json for cache busting
     */
    new WebpackManifestPlugin({
      // Don't include source maps
      filter: (file) => !file.path.match(/\.(map)$/),
      // Custom mapping of manifest item goes here
      map: function (file) {
        // Fix incorrect key for fonts
        if (file.isAsset && file.isModuleAsset && file.path.match(/\.(woff|woff2|eot|ttf|otf)$/)) {
          const pathParts = file.path.split('.')
          const nameParts = file.name.split('.')

          // Compare extensions
          if (pathParts[pathParts.length - 1] !== nameParts[nameParts.length - 1]) {
            file.name = pathParts[0].concat('.', pathParts[pathParts.length - 1])
          }
        }

        return file
      },
    }),

    /**
     * Enable build OS notifications (when using watch command)
     */
    new WebpackNotifierPlugin({ alwaysNotify: true, skipFirstNotification: true }),

    /**
     * Minimize CSS assets
     */
    ifProduction(
      new CssMinimizerWebpackPlugin({
        minimizerOptions: {
          preset: [
            'default',
            {
              discardComments: { removeAll: true },
            },
          ],
        },
      }),
    ),
    /*    /!**
         * HTML used by webpack dev server
         *!/
        ifDevelopment(
          new HtmlWebpackPlugin({
            template: './source/js/template.html.ejs',
            env: process.env,
          }),
        ),*/
  ]).filter(Boolean),
  devtool: 'source-map',
  stats: { children: false },
}
