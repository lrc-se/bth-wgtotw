<?php

namespace WGTOTW\Controllers;

/**
 * Controller for admin.
 */
class AdminController extends BaseController
{
    /**
     * Admin start page.
     */
    public function index()
    {
        $this->di->common->verifyAdmin();
        return $this->di->common->renderMain('admin/index', [], 'Administration');
    }
}
