const Encore = require('@symfony/webpack-encore')
const fs = require('fs')
if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev')
}
Encore
  .setOutputPath('public/static/')
  .setPublicPath('/static')
  .splitEntryChunks()
  .configureSplitChunks(config => {
    return {
      chunks: 'all',
      minSize: 0
    }
  })
  .enableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .configureBabelPresetEnv((config) => {
    config.useBuiltIns = 'usage'
    config.shippedProposals = true
    config.corejs = '3.22'
    config.targets = 'defaults'
  })
  .enableSassLoader()
  .enablePostCssLoader()
  .enableTypeScriptLoader()
  .enableIntegrityHashes(Encore.isProduction())

if (fs.existsSync('entrypoints.json')) {
  const entrypointsJson = fs.readFileSync('entrypoints.json')
  const entrypoints = JSON.parse(entrypointsJson)
  for (const [key, value] of Object.entries(entrypoints)) {
    Encore.addEntry(key, value)
  }
}

module.exports = Encore.getWebpackConfig()
