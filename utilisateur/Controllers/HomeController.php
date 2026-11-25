<?php


class HomeController extends Controller
{
    protected string $page = 'home';

    
    public function index(): void
    {
        $this->render('front/home', [
            'title'        => 'Trouvez une place de parking à Tunis',
            
        ]);
    }
}
