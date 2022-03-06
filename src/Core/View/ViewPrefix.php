<?php

namespace Pars\Core\View;

class ViewPrefix
{
    public function addData(string $html, array $data = []): string
    {
        $script = "<script ";
        foreach ($data as $key => $value) {
            $script .= "data-$key='$value' ";
        }
        $script .= '></script>';
        return $script . $html;
    }
}