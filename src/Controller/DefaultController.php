<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return new Response('Welcome to the To-Do API! Visit <a href="/api/doc">API Documentation</a> for more info.');
    }
}
