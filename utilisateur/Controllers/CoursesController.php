<?php
class CoursesController extends FrontPageController
{
    public function index(): void
    {
        $this->renderPage('courses');
    }
}
