<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'home')]
final class HomeController extends AbstractController
{
    public function __invoke(CategoryRepository $repository)
    {
        return $this->render(
            'home/index.html.twig',
            [
                'categories' => $repository->findAll()
            ]
        );
    }
}
