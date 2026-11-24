<?php
class AboutController extends FrontPageController
{
    public function index(): void
    {
        $this->renderPage('about');
    }
}
