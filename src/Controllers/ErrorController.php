<?php

namespace WGTOTW\Controllers;

/**
 * Error controller.
 */
class ErrorController extends BaseController
{
    /**
     * @var array   Default error definitions.
     */
    private $defaultErrors = [
        403 => [
            'title' => 'Förbjuden åtgärd',
            'message' => 'Du har inte behörighet att göra det du försökte göra.'
        ],
        404 => [
            'title' => 'Sidan kunde inte hittas',
            'message' => 'Sidan du letar efter finns inte här.'
        ],
        500 => [
            'title' => 'Serverfel',
            'message' => 'Ett oväntat problem har uppstått.'
        ]
    ];
    
    
    /**
     * Render a default error message.
     *
     * @param int   $code   Status code.
     */
    public function defaultError($code)
    {
        if (array_key_exists($code, $this->defaultErrors)) {
            $error = $this->defaultErrors[$code];
            $title = $error['title'];
            $message = $error['message'];
        } else {
            $title = 'Okänt fel';
            $message = 'Ett okänt fel har inträffat.';
        }
        $this->di->common->renderPage($title, $message, ['title' => $title], $code);
        return true;
    }
}
