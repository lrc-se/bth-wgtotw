<?php

namespace WGTOTW\Services;

/**
 * Service for file-based content.
 */
class ContentService extends BaseService
{
    /**
     * Get file-based content by path.
     *
     * @param string $path
     *
     * @return array|null
     */
    public function get($path)
    {
        // Get the current route and see if it matches a content/file
        $file1 = ANAX_INSTALL_PATH . "/content/$path.md";
        $file2 = ANAX_INSTALL_PATH . "/content/$path/index.md";
        $file = (is_file($file2) ? $file2 : (is_file($file1) ? $file1 : null));
        if (!$file) {
            return null;
        }
        
        // Check that file is really in the right place
        $real = realpath($file);
        $base = realpath(ANAX_INSTALL_PATH . '/content/');
        if (strncmp($base, $real, strlen($base))) {
            return null;
        }
        
        // Get content from markdown file
        return $this->di->textfilter->parse(file_get_contents($file), ['yamlfrontmatter', 'shortcode', 'markdown', 'titlefromheader']);
    }
}
