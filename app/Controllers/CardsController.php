<?php
class CardsController extends AdminPageController
{
    public function index(): void
    {
        $this->renderPage('cards');
    }
}
