<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Renderer
    |--------------------------------------------------------------------------
    |
    | The renderer to use for generating QR codes.
    | Available options: 'gd', 'imagick', 'svg'
    |
    */

    'renderer' => 'gd',

    /*
    |--------------------------------------------------------------------------
    | Renderer Options
    |--------------------------------------------------------------------------
    |
    | Options for the renderer.
    |
    */

    'rendererOptions' => [
        'gd' => [
            'imageType' => 'png',
        ],
    ],

];