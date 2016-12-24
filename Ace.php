<?php

namespace devgroup\ace;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use yii\widgets\InputWidget;

class Ace extends InputWidget
{
    public $mode = 'php';
    public $theme = 'github';
    public $jsOptions = [];
    public $htmlOptions = [];

    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->id;
        } else {
            $this->id = $this->options['id'];
        }

        if (is_object($this->model)) {
            $this->value = Html::getAttributeValue($this->model, $this->attribute);
            $this->name = Html::getInputName($this->model, $this->attribute);
        }
        $this->options['id'] .= '-ace';
    }

    public function run()
    {
        $view = $this->getView();
        AceAsset::register($view);
        $jsOptions = Json::encode($this->jsOptions);

        $htmlOptions = Json::encode(
            ArrayHelper::merge(
                [
                ],
                $this->htmlOptions
            )
        );
        $aceWidgetJs = <<< JS
    var aceWidget = {
    "idElement" : null,
    "mode" : null,
    "theme" : null,
    "jsOptions" : [],
    "htmlOptions" : [],
    "init" : function(){
        var textarea = $("#" + this.idElement);
        var editDiv = $('<div>', this.htmlOptions).insertBefore(textarea);
        textarea.addClass('hidden');

        var editor = ace.edit(editDiv[0]);
        editor.setOptions(this.jsOptions);
        editor.getSession().setValue(textarea.val());
        if (this.mode.length !== 0) {
                editor.getSession().setMode('ace/mode/' + this.mode);
            }
        if (this.theme.length !== 0) {
                editor.setTheme('ace/theme/' + this.theme);
            }

        editor.getSession().on('change', function() {
                textarea.val(editor.getSession().getValue());
            });
    }

}
JS;
        $view->registerJs($aceWidgetJs, View::POS_READY, 'Yii2AceWidget');

        $elementJs = <<< JS
        aceWidget.idElement = "{$this->options['id']}";
        aceWidget.mode = "{$this->mode}";
        aceWidget.theme = "{$this->theme}";
        aceWidget.jsOptions = {$jsOptions};
        aceWidget.htmlOptions = {$htmlOptions};
        aceWidget.init();
JS;
        $view->registerJs($elementJs);
        echo Html::textarea($this->name, $this->value, $this->options);
    }
}
