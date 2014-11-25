<?php

namespace devgroup\ace;

use yii\base\Widget;

class Ace extends Widget
{
    public $mode = 'php';
    public $name = '';
    public $options = [];
    public $theme = 'github';
    public $value = '';

    public function run()
    {
        $view = $this->getView();
        AceAsset::register($view);
        $view->registerJs(
            "$('textarea[name={$this->name}]').each(function(index, element) {
                var textarea = $(this);

                var editDiv = $('<div>', {
                    width: textarea.width(),
                    height: textarea.height(),
                    class: textarea.attr('class')
                }).insertBefore(textarea);

                textarea.addClass('hidden');

                var editor = ace.edit(editDiv[0]);
                var mode = ('{$this->mode}').trim();
                var theme = ('{$this->theme}').trim();
                editor.getSession().setValue(textarea.val());
                if (mode.length !== 0) {
                    editor.getSession().setMode('ace/mode/' + mode);
                }
                if (theme.length !== 0) {
                    editor.setTheme('ace/theme/' + theme);
                }

                editor.getSession().on('change', function() {
                    textarea.val(editor.getSession().getValue());
                });
            });"
        );
        return $this->render('ace', ['name' => $this->name, 'value' => $this->value, 'options' => $this->options]);
    }
}
