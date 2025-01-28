<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final readonly class DefaultController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return new Response('Welcome to the To-Do API! Visit <a href="/api/doc">API Documentation</a> for more info.');
    }
}
