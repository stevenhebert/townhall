var webpack = require("webpack");
var HtmlWebpackPlugin = require("html-webpack-plugin");
var ExtractTextPlugin = require("extract-text-webpack-plugin");
var helpers = require("./helpers");

module.exports = {
	entry: {
		"polyfills": helpers.root("src") + "/polyfills.ts",
		"vendor": helpers.root("src") + "/vendor.ts",
		"app": helpers.root("src") + "/main.ts",
		"css": helpers.root("src") + "/app.css"
	},

	resolve: {
		extensions: [".ts", ".js"]
	},

	module: {
		rules: [
			{
				test: /\.(html|php)$/,
				use: "html-loader"
			},
			{
				test: /\.(png|jpe?g|gif|svg|woff|woff2|ttf|eot|ico)$/,
				use: "url-loader?limit=100000"
			},
			{
				test: /\.css$/,
				use: ExtractTextPlugin.extract({ fallback: "style-loader", use: "css-loader?minimize=true" })
			},
			{
				test: /\.ts$/,
				use: ["awesome-typescript-loader"]
			}
		],
		loaders: [
			{
				test: /\.css$/,
				loaders: [ 'style-loader', 'css-loader' ]
			}
		]
	},


	plugins: [
		new webpack.optimize.CommonsChunkPlugin({
			name: ["app", "vendor", "polyfills"]
		}),

		new webpack.ProvidePlugin({
			$: "jquery",
			jQuery: "jquery",
			"window.jQuery": "jquery"
		}),

		new HtmlWebpackPlugin({
			inject: "head",
			filename: helpers.root("public_html") + "/index.html",
			template: helpers.root("webpack") + "/index.html"
		})
	]
};