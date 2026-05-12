<?php

namespace Cloudteam\CoreV2\Utils;

class HtmlAction
{
    public static function generateButtonChangeState(array $params, ?string $btnClass = null): string
    {
        $btnClass ??= config('core.button.action.change_state.class');

        [$state, $message, $title, $url, $elementTitle, $icon] = $params;

        return sprintf(' <button type="button" class="btn btn-sm btn-icon btn-action-change-state %s" data-state="%s" data-message="%s" data-title="%s" data-url="%s" title="%s"><i class="%s"></i></button>',
            $btnClass, $state, $message, $title, $url, $elementTitle, $icon);
    }

    public static function generateButtonDelete(string $deleteLink, string $dataTitle, ?string $btnClass = null, $icon = null): string
    {
        $btnClass ??= config('core.button.action.delete.class');
        $icon     ??= config('core.button.action.delete.icon');

        return sprintf(" <button type='button' class='btn btn-sm btn-icon btn-action-delete %s' data-title='%s' data-url='%s' title='%s'><i class='%s'></i></button>",
            $btnClass, $dataTitle, $deleteLink, __('Delete'), $icon);
    }

    public static function generateButtonEdit(string $editLink, ?string $btnClass = null, $icon = null, $target = '_self'): string
    {
        $btnClass ??= config('core.button.action.edit.class');
        $icon     ??= config('core.button.action.edit.icon');

        return sprintf(" <a href='%s' class='btn btn-sm btn-icon btn-action-edit %s' title='%s' target='%s'><i class='%s'></i></a>", $editLink, $btnClass, __('Edit'), $target, $icon);
    }

    public static function generateButtonView(string $viewLink, ?string $btnClass = null, $icon = null, $target = '_self'): string
    {
        $btnClass ??= config('core.button.action.view.class');
        $icon     ??= config('core.button.action.view.icon');

        return sprintf(' <a href="%s" class="btn btn-sm btn-icon btn-action-view %s" title="%s" target="%s"><i class="%s"></i></a>', $viewLink, $btnClass, __('View'), $target, $icon);
    }

    public static function generateDropdownButton(array $buttons, ?string $btnClass = null): string
    {
        $btnClass ??= config('core.button.action.dropdown.class');
        $icon     ??= config('core.button.action.dropdown.icon');

        $buttonHtml = implode(' ', $buttons);

        return " <div class=\"dropdown dropdown-inline\">
                            <button type=\"button\" class=\"btn-action $btnClass\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                <i class=\"$icon\"></i>
                            </button>
                               <div class=\"form-group dropdown-menu dropdown-menu-right row text-center\">$buttonHtml</div>
                        </div>";
    }

    public static function generateCustomButton(array $params): string
    {
        [$cssClass, $dataTitle, $link, $title, $icon] = $params;

        return sprintf(' <button type="button" class="btn btn-sm btn-icon btn-action %s" data-title="%s" data-url="%s" title="%s"><i class="%s"></i></button>'
            , $cssClass, $dataTitle, $link, $title, $icon);
    }
}
