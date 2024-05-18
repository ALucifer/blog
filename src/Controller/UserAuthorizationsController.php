<?php

namespace App\Controller;

use App\Entity\CategoryUser;
use App\Repository\CategoryUserRepository;
use App\ValuesObject\CategoryUserState;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Workflow\WorkflowInterface;

class UserAuthorizationsController extends AbstractController
{
    #[Route('/category/{categoryUser}/{state}', name: 'user_response_access')]
    #[IsGranted('user', 'categoryUser')]
    public function approveAccessToCategory(
        CategoryUser $categoryUser,
        CategoryUserState $state,
        WorkflowInterface $addUserRoleToCategoryStateMachine,
        CategoryUserRepository $categoryUserRepository,
    ): Response {
        try {
            $addUserRoleToCategoryStateMachine->apply($categoryUser, $state->toTransition());
            $categoryUserRepository->save($categoryUser);
        } catch (\LogicException $e) {
            $this->addFlash('error', 'Une erreur est survenu lors de votre accord.');
        }

        return $this->redirectToRoute('app_user_profile');
    }
}