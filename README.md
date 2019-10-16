# Underser_TranslationHelper Magento 2 module

This module will allow you to grab translation files with the ability to exclude already translated ones.

### Requirements

**Magento 2 platform:**

Tested on Magento v2.3.3 (note for now require v2.3.* from you)

### How to install

Add to your *composer.json*
```
"repositories": {
    "module-translation-helper": {
        "type": "github",
        "url": "git@github.com:underser/module-translation-helper.git"
    }
}
```

Run
```
composer require underser/module-translation-helper

./bin/magento setup:upgrade
```

### How to use

This module will provide you *i18n:translation-helper* command, run
```
./bin/magento i18n:translation-helper --help
```
to see possible params and their meaning

### Examples of usage

```
./bin/magento i18n:translation-helper --locale fr_FR  --output ./var/fr_FR.csv --all
```
will scan whole magento directory, and create fr_FR.csv file inside *var* folder. This file will contain all phrases that not translated for fr_FR locale

```
./bin/magento i18n:translation-helper --locale fr_FR  --output ./var/fr_FR.csv ./app/code/Vendor/Module
```
will scan only *app/code/Vendor/Module*, and create fr_FR.csv file inside *var* folder. This file will contain all phrases that not translated for fr_FR locale

### License

MIT © 2018 [Roman Sliusar](https://github.com/underser/)
