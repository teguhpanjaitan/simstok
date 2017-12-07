<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

use Zend\Session\Storage\SessionArrayStorage;
use Zend\Session\Validator\RemoteAddr;
use Zend\Session\Validator\HttpUserAgent;

return [
    // Session configuration.
    'session_config' => [
        'cookie_lifetime'     => 60*60*5, // Session cookie will expire in 5 hours.
        'gc_maxlifetime'      => 60*60*24*7, // How long to store session data on server (for 1 week).
    ],

    // Session manager configuration.
    'session_manager' => [
        // Session validators (used for security).
        'validators' => [
            RemoteAddr::class,
        ]
    ],

    // Session storage configuration.
    'session_storage' => [
        'type' => SessionArrayStorage::class
    ],

    //user access config
    'access_filter' => [
        'options' => [
            // The access filter can work in 'restrictive' (recommended) or 'permissive'
            // mode. In restrictive mode all controller actions must be explicitly listed
            // under the 'access_filter' config key, and access is denied to any not listed
            // action for not logged in users. In permissive mode, if an action is not listed
            // under the 'access_filter' key, access to it is permitted to anyone (even for
            // not logged in users. Restrictive mode is more secure and recommended to use.
            'mode' => 'restrictive'
        ],
        // 'controllers' => [
        //         \Front\Controller\IndexController::class => [
        //             ['actions' => ['index'], 'allow' => '*'],
        //         ],
        // ]
        'default_page' => [
            'admin' => 'home'
        ]
    ]
];
