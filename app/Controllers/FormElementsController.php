<?php
class FormElementsController extends AdminPageController
{
    public function index(): void
    {
        $this->renderPage('form-elements');
    }
}
