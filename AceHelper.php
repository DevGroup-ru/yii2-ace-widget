<?php

namespace devgroup\ace;

use yii\web\Controller;

class AceHelper
{
    /**
     * converts all textarea with attribute 'data-editor'
     * in the ace text editor
     * @param Controller $controller
     * @param string $theme
     */
    public static function setAceScript(Controller $controller, $theme = 'chrome')
    {
        /* @var \yii\web\View $view */
        $view = $controller->getView();

        AceAsset::register($view);

        $view->registerJs(
            "$('textarea[data-editor]').each(function(index, element) {
                var textarea = $(this);

                var editDiv = $('<div>', {
                    width: textarea.width(),
                    height: textarea.height(),
                    class: textarea.attr('class')
                }).insertBefore(textarea);

                textarea.addClass('hidden');

                var editor = ace.edit(editDiv[0]);
                var mode = (textarea.data('editor')).trim();
                var theme = ('{$theme}').trim();
                editor.setReadOnly(textarea.data('read-only'));
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
    }
}
