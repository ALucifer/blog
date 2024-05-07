<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CategoryController extends AbstractController
{
    #[Route('/category/add', name: 'category_add')]
    #[IsGranted('ROLE_ADMIN_CATEGORY')]
    public function add(Request $request, CategoryRepository $repository): Response
    {
        $form = $this->createForm(CategoryType::class, new Category());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Category $data */
            $data = $form->getData();
            $repository->save($data);

            return $this->redirectToRoute('home');
        }

        return $this->render(
            'category/add.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/category/{category}', name: 'category_view')]
    public function view(Category $category): Response
    {
        return $this->render(
            'category/view.html.twig',
            [
                'category' => $category
            ]
        );
    }
}
