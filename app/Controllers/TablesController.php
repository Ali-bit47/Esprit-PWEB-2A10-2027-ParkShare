<?php
class TablesController extends AdminPageController
{
    public function index(): void
    {
        $this->renderPage('tables');
    }
}
