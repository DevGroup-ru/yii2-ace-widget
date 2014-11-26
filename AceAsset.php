<?php

namespace devgroup\ace;

use yii\web\AssetBundle;

class AceAsset extends AssetBundle
{
    public $sourcePath = '@bower/ace-builds/src-min';
    public $js = [
        'ace.js'
    ];
    public $depends = [
    ];
}
