<?php
class SigninController extends AdminPageController
{
    public function index(): void
    {
        $this->renderPage('signin');
    }
}
