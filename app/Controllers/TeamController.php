<?php
class TeamController extends FrontPageController
{
    public function index(): void
    {
        $this->renderPage('team');
    }
}
