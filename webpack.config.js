/**
 * Webpack configuration.
 */

// WordPress dependencies
const [
  scriptConfig,
  moduleConfig,
] = require("@wordpress/scripts/config/webpack.config");

// External dependencies
const RemoveEmptyScriptsPlugin = require("webpack-remove-empty-scripts");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

module.exports = [
  {
    ...scriptConfig,
    entry: {
      ...scriptConfig.entry(),
      "public/index": "./src/public/index.js",
    },
    optimization: {
      ...scriptConfig.optimization,
      minimizer: [
        ...scriptConfig.optimization.minimizer,
        new CssMinimizerPlugin(),
      ],
    },
    plugins: [...scriptConfig.plugins, new RemoveEmptyScriptsPlugin()],
  },
  moduleConfig,
];
