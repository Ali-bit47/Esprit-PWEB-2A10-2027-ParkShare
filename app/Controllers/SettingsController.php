<?php
class SettingsController extends AdminPageController
{
    public function index(): void
    {
        $this->renderPage('settings');
    }
}
