<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/11/30
 * Time: 16:32
 */
return [
    'zf-mvc-auth' => [
        'authentication' => [
            'map' => [
                'ApigilityFeedback\\V1' => 'apigilityoauth2adapter',
            ],
        ],
    ],
];