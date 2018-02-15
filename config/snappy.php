<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary'  => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf'),
        'timeout' => false,
        'options' => array(
            'page-size' => 'A4',
            'footer-center' => 'Page [page] of [toPage]',
            'footer-font-size' => 8,
            'footer-left' => 'Confidential',
        ),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltoimage'),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);
