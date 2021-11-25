# Live 5 : Introduction à Twig et Bootstrap 5

## Mise en place de Bootstrap 5

* `composer require symfony/webpack-encore-bundle`
* `npm install bootstrap --save-dev`
* `npm install @popperjs/core --save-dev`
* `npm install sass-loader@^12.0.0 sass --save-dev`
* `npm install`

Puis dans `assets/styles/app.scss` :

```css
@import "~bootstrap/scss/bootstrap";
```

## Mise à jour de la configuration WebPack

```javascript
const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.js')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    .enableSassLoader()
;

module.exports = Encore.getWebpackConfig();
```

## Mise à jour du Form Theme de Symfony

Dans le fichier ``config/packages/twig.yaml`` :

```yaml
twig:
    default_path: '%kernel.project_dir%/templates'
    form_themes: ['bootstrap_5_layout.html.twig']
```
## Activer le chargement des assets

Dans `templates/base.html.twig`, décommentez les fonctions `encore_entry_link_tags` et `encore_entry_script_tags`.

## Démarrer le serveur front (Encore)

* `npm run watch`
* `npm run build` (pour les assets compilés en production)

## Documentation

* [https://symfony.com/doc/current/frontend/encore/simple-example.html](https://symfony.com/doc/current/frontend/encore/simple-example.html)
* [https://symfony.com/doc/current/form/bootstrap5.html](https://symfony.com/doc/current/form/bootstrap5.html)
* [https://getbootstrap.com/docs/5.1/getting-started/introduction/](https://getbootstrap.com/docs/5.1/getting-started/introduction/)