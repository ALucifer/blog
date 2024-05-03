<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CategoryAdminController extends AbstractController
{
    #[Route('/category/{category}/admin')]
    #[IsGranted('admin', 'category')]
    public function admin(Category $category): Response
    {
        return $this->render(
            'category/admin.html.twig',
            [
                'category' => $category
            ]
        );
    }
}
