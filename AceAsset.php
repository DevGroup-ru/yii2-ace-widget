<?php

namespace devgroup\ace;

use yii\web\AssetBundle;

class AceAsset extends AssetBundle
{
    public $sourcePath = '@bower/ace-builds';
    public $js = [
        'src-min/ace.js'
    ];
    public $depends = [
    ];
}
