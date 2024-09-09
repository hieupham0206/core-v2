<?php

namespace Cloudteam\CoreV2\Utils;

class HtmlAction
{
    public static function generateButtonChangeState(array $params, string $btnClass = 'btn-light-warning'): string
    {
        [$state, $message, $title, $url, $elementTitle, $icon] = $params;

        return sprintf(' <button type="button" class="btn btn-sm btn-icon btn-action-change-state %s" data-state="%s" data-message="%s" data-title="%s" data-url="%s" title="%s"><i class="%s"></i></button>',
            $btnClass, $state, $message, $title, $url, $elementTitle, $icon);
    }

    public static function generateButtonDelete(string $deleteLink, string $dataTitle, string $btnClass = 'btn-light-danger', $icon = 'fa fa-sm fa-trash'): string
    {
        return sprintf(" <button type='button' class='btn btn-sm btn-icon btn-action-delete %s' data-title='%s' data-url='%s' title='%s'><i class='%s'></i></button>",
            $btnClass, $dataTitle, $deleteLink, __('Delete'), $icon);
    }

    public static function generateButtonEdit(string $editLink, string $btnClass = 'btn-light-primary', $icon = 'fa fa-sm fa-edit', $target = '_self'): string
    {
        return sprintf(" <a href='%s' class='btn btn-sm btn-icon btn-action-edit %s' title='%s' target='%s'><i class='%s'></i></a>", $editLink, $btnClass, __('Edit'), $target, $icon);
    }

    public static function generateButtonView(string $viewLink, string $btnClass = 'btn-light-info', $icon = 'fa fa-sm fa-eye', $target = '_self'): string
    {
        return sprintf(' <a href="%s" class="btn btn-sm btn-icon btn-action-view %s" title="%s" target="%s"><i class="%s"></i></a>', $viewLink, $btnClass, __('View'), $target, $icon);
    }

    public static function generateCustomButton(array $params): string
    {
        [$cssClass, $dataTitle, $link, $title, $icon] = $params;

        return sprintf(' <button type="button" class="btn btn-sm btn-icon btn-action %s" data-title="%s" data-url="%s" title="%s"><i class="%s"></i></button>'
            , $cssClass, $dataTitle, $link, $title, $icon);
    }

    public static function generateDropdownButton(array $buttons, string $btnClass = 'btn-light-gray'): string
    {
        $buttonHtml = implode(' ', $buttons);

        return " <div class=\"dropdown dropdown-inline\">
                            <button type=\"button\" class=\"btn-action $btnClass\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                <i class=\"fa fa-ellipsis-h\"></i>
                            </button>
                               <div class=\"form-group dropdown-menu dropdown-menu-right row text-center\">$buttonHtml</div>
                        </div>";
    }
}
