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


/**
 * Render HTML-safe Markdown output.
 *
 * @param string $str   Markdown text to render.
 *
 * @return string       Rendered text.
 */
function markdown($str)
{
    global $di;
    return $di->textfilter->markdown(esc($str));
}
