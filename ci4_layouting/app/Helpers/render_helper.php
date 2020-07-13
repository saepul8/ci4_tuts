<?php

if ( ! function_exists('render'))
{
    function render(string $name, array $data = [], array $options = [])
    {
        return view(
            '_layouts/layout',
            [
                'content' => view($name, $data, $options),
            ],
            $options
        );
    }
}