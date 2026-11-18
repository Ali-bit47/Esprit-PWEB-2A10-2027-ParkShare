<?php
class AlertsController extends AdminPageController
{
    public function index(): void
    {
        $this->renderPage('alerts');
    }
}
