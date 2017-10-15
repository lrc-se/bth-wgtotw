<?php

/**
 * View container config.
 */
 
return [

    // Paths to look for views, without ending slash.
    'path' => [
        ANAX_APP_PATH . '/view',
        ANAX_INSTALL_PATH . '/view',
        ANAX_INSTALL_PATH . '/vendor/anax/view/view',
    ],

    // File suffix for template files
    'suffix' => '.php',

    // Include files before including the view template file.
    // Use this to expose helper functions for the view.
    'include' => [
        ANAX_APP_PATH . '/view/functions.php',
        ANAX_INSTALL_PATH . '/vendor/anax/view/src/View/ViewHelperFunctions.php',
    ]
    
];
