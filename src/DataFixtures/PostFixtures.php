<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $post = new Post();
            $post->setTitle('Title ' . $i);
            $post->setContent('Content ' . $i);
            $post->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($post);
        }

        $manager->flush();
    }
}
