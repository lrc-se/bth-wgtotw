<?php

/**
 * Config for development mode with error reporting.
 */


/**
 * Set the error reporting.
 */
error_reporting(-1);              // Report all type of errors
ini_set('display_errors', 1);     // Display all errors



/**
 * Default exception handler.
 */
set_exception_handler(function ($e) {
    @ob_clean();
    require ANAX_APP_PATH . '/view/default/exception.php';
});
