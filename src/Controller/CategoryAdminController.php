<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Entity\CategoryUser;
use App\Entity\User;
use App\Repository\CategoryUserRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CategoryAdminController extends AbstractController
{
    #[Route('/category/{category}/admin', name: 'category_admin')]
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

    #[Route('/category/{category}/admin/user/add', name: 'category_admin_form_user')]
    #[IsGranted('admin', 'category')]
    public function addUser(Category $category, UserRepository $userRepository): Response
    {
        return $this->render(
            'category/add_user.html.twig',
            [
                'users' => $userRepository->findAll(),
                'category' => $category,
            ]
        );
    }

    #[Route('/category/{category}/admin/user/add/{user}', name: 'category_admin_new_user', methods: ['POST'])]
    #[IsGranted('admin', 'category')]
    public function newUser(Category $category, User $user, CategoryUserRepository $categoryUserRepository): Response
    {
        $categoryUserRepository->save($category, $user);

        return $this->redirectToRoute(
            'category_admin_form_user',
            [
                'category' => (string) $category->id(),
            ]
        );
    }

    #[Route('/category/admin/user/remove/{categoryUser}', name: 'category_admin_remove_user', methods: ['POST'])]
    #[IsGranted('admin', 'categoryUser')]
    public function removeUser(CategoryUser $categoryUser, CategoryUserRepository $categoryUserRepository): Response
    {
        $categoryUserRepository->remove($categoryUser);

        return $this->redirectToRoute(
            'category_admin_form_user',
            [
                'category' => (string) $categoryUser->getCategory()->id(),
            ]
        );
    }
}
