<?php
class ButtonsController extends AdminPageController
{
    public function index(): void
    {
        $this->renderPage('buttons');
    }
}
