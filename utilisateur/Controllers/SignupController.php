<?php
class SignupController extends AdminPageController
{
    public function index(): void
    {
        $this->renderPage('signup');
    }
}
