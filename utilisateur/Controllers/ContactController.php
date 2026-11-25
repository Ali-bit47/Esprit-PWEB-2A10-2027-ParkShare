<?php
class ContactController extends FrontPageController
{
    public function index(): void
    {
        $this->renderPage('contact');
    }
}
