<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use App\Repository\PostRepository;
use Assert\Assertion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class PostController extends AbstractController
{
    #[Route('/posts', name: 'posts')]
    public function list(PostRepository $repository): Response
    {
        return $this->render(
            'post/list.html.twig',
            [
                'posts' => $repository->findAll()
            ]
        );
    }

    #[Route('/post/add', name: 'post_add')]
    #[IsGranted('ROLE_USER')]
    public function add(Request $request, PostRepository $repository, Security $security): Response
    {
        $form = $this->createForm(PostType::class, new Post());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Post $data */
            $data = $form->getData();
            Assertion::isInstanceOf($data, Post::class);

            /** @var User $user */
            $user = $security->getUser();

            $data->setOwner($user);
            $repository->save($data);

            return $this->redirectToRoute('posts');
        }

        return $this->render(
            'post/add.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    #[Route('/post/{id}/edit', name: 'post_edit')]
    #[IsGranted('edit', 'post')]
    public function edit(Post $post, Request $request, Security $security): Response
    {
        return $this->render('post/edit.html.twig', []);
    }

    #[Route('/post/{id}', name: 'post_view')]
    public function get(Post $post): Response
    {
        return $this->render(
            'post/view.html.twig',
            [
                'post' => $post
            ]
        );
    }
}
