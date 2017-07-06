const path = require('path');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports  = {
    entry: {
        app: path.resolve(__dirname, './web/js/app.js'),
        style: path.resolve(__dirname, './web/css/style.less'),
    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, './web/bundle'),
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: [/node_modules/],
                use: [
                    {
                        loader: 'babel-loader',
                        options: { presets: ['latest'] }
                    }
                ]
            },
            {
                test: /\.less$/,
                use: ExtractTextPlugin.extract({
                    use: [
                        {
                            loader: "raw-loader",
                            options: {
                                sourceMap: true
                            }
                        },
                        {
                            loader: "less-loader",
                            options: {
                                sourceMap: true
                            }
                        }
                    ]
                })
            }
        ]
    },
    plugins: [
        new ExtractTextPlugin({
            filename: "style.css",
            allChunks: true
        })
    ],
    devtool: 'source-map'
};
