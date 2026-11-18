<?php
class BlankPageController extends AdminPageController
{
    public function index(): void
    {
        $this->renderPage('blank-page');
    }
}
