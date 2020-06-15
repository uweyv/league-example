const path = require('path');
const { exit } = require('process');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');

module.exports = {
	entry: {
		vendor: {
			import: path.join(__dirname, 'res', 'assets', 'js', 'vendor.js'),
		},
		app: {
			import: path.join(__dirname, 'res', 'assets', 'js', 'app.js'),
			dependOn: 'vendor'
		}
	},

	output: {
		filename: '[name].js',
		path: path.join(__dirname, 'public', 'assets', 'js'),
		publicPath: path.join(__dirname, 'public'),
	},

	watchOptions: {
		aggregateTimeout: 200,
		poll: 1000,
		ignored: [
			'/node_modules/**'
		],
	},

	module: {
		rules: [
			{
				test: /\.s[ac]ss$/i,
				use: [
					{
						loader: MiniCssExtractPlugin.loader,
						options: {
							publicPath: path.join(__dirname, 'public'),
						},
					},
					'css-loader',
					'sass-loader',
				],
			},
		],
	},

	plugins: [
		new MiniCssExtractPlugin({
			filename: path.join('..', 'css', '[name].css'),
		}),
	],
};
