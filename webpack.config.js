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
      "public/index": "./src/public/index.js", // Custom entry point
      "search/index": "./src/search/index.js", // Custom entry points
      "blocks/hero/index": "./src/blocks/hero/index.js", // Custom entry points
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
  {
    ...moduleConfig,
  },
];
