ACE Editor Extension for Yii 2
==============================

This extension provides the [ACE](http://ace.c9.io/) integration for the Yii2 framework.


Installation
------------

This extension requires [ace-builds](https://github.com/ajaxorg/ace-builds/)

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist devgroup/yii2-ace-widget "*"
```

or add

```
"devgroup/yii2-ace-widget": "*"
```

to the require section of your composer.json.


General Usage
-------------

```php
use devgroup\ace\Ace;

Ace::widget([
    'mode' => 'php', // editor mode
    'name' => '', // editor name
    'options' => [], // html options
    'theme' => 'github', // editor theme
    'value' => '', // editor default value
]);
```

or

in view file

```php
<?= yii\helpers\Html::textarea('', '', ['data-editor' => 'html', 'data-read-only' => false]) ?>
```
and your controller

```php
use devgroup\ace\AceHelper

...
AceHelper::setAceScript(controller, theme);
...
```
