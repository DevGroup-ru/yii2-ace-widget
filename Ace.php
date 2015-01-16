<?php

namespace devgroup\ace;

use yii\helpers\BaseInflector;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class Ace extends InputWidget
{
    public $mode = 'php';
    public $theme = 'github';

    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->id;
        } else {
            $this->id = $this->options['id'];
        }

        if (is_object($this->model)) {
            $this->value = $this->model->{$this->attribute};
            $this->name = Html::getInputName($this->model, $this->attribute);
        }
        $this->options['id'] .= '-ace';
    }

    public function run()
    {
        $view = $this->getView();
        AceAsset::register($view);
        $editorName = BaseInflector::camelize($this->id) . 'Editor';
        $view->registerJs(
            "var textarea = $('#{$this->options['id']}');

            var editDiv = $('<div>', {
                width: textarea.width(),
                height: textarea.height(),
                class: textarea.attr('class')
            }).insertBefore(textarea);

            textarea.addClass('hidden');

            var {$editorName} = ace.edit(editDiv[0]);
            var mode = ('{$this->mode}').trim();
            var theme = ('{$this->theme}').trim();
            {$editorName}.getSession().setValue(textarea.val());
            if (mode.length !== 0) {
                {$editorName}.getSession().setMode('ace/mode/' + mode);
            }
            if (theme.length !== 0) {
                {$editorName}.setTheme('ace/theme/' + theme);
            }

            {$editorName}.getSession().on('change', function() {
                textarea.val({$editorName}.getSession().getValue());
            });"
        );
        echo Html::textarea($this->name, $this->value, $this->options);
    }
}
