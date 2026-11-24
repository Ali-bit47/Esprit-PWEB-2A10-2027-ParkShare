<?php
class InvoiceController extends AdminPageController
{
    public function index(): void
    {
        $this->renderPage('invoice');
    }
}
