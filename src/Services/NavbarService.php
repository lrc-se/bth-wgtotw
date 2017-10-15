<?php

namespace WGTOTW\Services;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;

/**
 * Navbar class.
 */
class NavbarService extends BaseService implements ConfigureInterface
{
    use ConfigureTrait;
    
    
    /**
     * Returns the rendered HTML for the navbar items.
     *
     * @return  string  Nested lists as HTML.
     */
    public function renderItems()
    {
        return $this->renderLevel($this->config['items']);
    }
    
    
    /**
     * Checks whether the specified route is active.
     *
     * @param   string  $route  The route to check.
     * @return  bool            True if the route is considered active, false otherwise.
     */
    private function isActiveRoute($route)
    {
        $current = $this->di->request->getRoute();
        if (empty($route)) {
            return ($current === $route);
        }
        return (substr($current . '/', 0, strlen($route) + 1) === $route . '/');
    }
    
    
    /**
     * Checks whether the specified nav item is active.
     *
     * @param   array   $item   The navbar item to check.
     * @return  bool            True if the item is considered active, false otherwise.
     */
    private function isActiveItem($item)
    {
        // check subitems, if any
        if (isset($item['items']) && is_array($item['items'])) {
            foreach ($item['items'] as $subitem) {
                if ($this->isActiveItem($subitem)) {
                    return true;
                }
            }
        }
        
        return $this->isActiveRoute($item['route']);
    }
    
    
    /**
     * Recursively renders a list of navbar items.
     *
     * @param   array   $items  Array of navbar items.
     * @param   int     $level  Current recursion depth.
     * @return  string          The current list level as HTML.
     */
    private function renderLevel($items, $level = 1)
    {
        $list = "<ul>\n";
        foreach ($items as $item) {
            // set style classes
            $hasChildren = (isset($item['items']) && is_array($item['items']));
            $classes = [];
            if ($this->isActiveItem($item)) {
                $classes[] = 'active';
            }
            if ($hasChildren) {
                $classes[] = 'sub';
            }
            $list .= '<li' . (count($classes) > 0 ? ' class="' . implode(' ', $classes) . '"' : '') . ' data-level="' . $level . '">';
            
            // render link, if any
            $list .= '<a href="' . (!is_null($item['route']) ? $this->di->url->create($item['route']) : '#!') . '">' . $item['title']  . '</a>';
            
            // render subitems, if any
            if ($hasChildren) {
                $list .= "\n" . $this->renderLevel($item['items'], $level + 1);
            }
            
            $list .= "</li>\n";
        }
        return "$list</ul>\n";
    }
}
