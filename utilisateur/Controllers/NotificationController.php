<?php
class NotificationController extends AdminPageController
{
    public function index(): void
    {
        $this->renderPage('notification');
    }
}
