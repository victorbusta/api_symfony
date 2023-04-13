<?php

namespace App\DataFixtures;

use App\Entity\ArticleType;
use App\Entity\DocumentType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // defining article types
        $articles = [
            'User',
            'Machine',
            'Component',
            'Repair',
            'Project',
        ];

        foreach ($articles as $article) {
            $articleType = new ArticleType();
            $articleType->setType($article);
            $manager->persist($articleType);
        }

        // defining documents types
        $documents = [
            'Document',
            'Picture',
            'Video',
        ];

        foreach ($documents as $document) {
            $documentType = new DocumentType();
            $documentType->setType($document);
            $manager->persist($documentType);
        }

        $manager->flush();

    }
}
