<?php

/**
 * View helper functions.
 */


/**
 * Escape output.
 *
 * @param string $str   Text to escape.
 *
 * @return string       Escaped text.
 */
function esc($str)
{
    return htmlspecialchars($str);
}
