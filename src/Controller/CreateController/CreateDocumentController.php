<?php

namespace App\Controller\CreateController;

use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Controller\CreateController\AbstractCreateController;
use App\Entity\Article;
use App\Entity\Document;
use Exception;

#[AsController]
class CreateDocumentController extends AbstractCreateController
{
    public function createEntity($data): Document
    {
        // get article
        preg_match('/articles\/(?<id>\d+)\/document/', $this->getRequest()->getPathInfo(), $articleMatch);

        $article = $this->articleRepository->find($articleMatch['id'] ?? throw new HttpException(400, 'missing article id'));

        // authenticating user 
        $this->authUser($article ?? throw new HttpException(400, 'article not found'));

        // create document
        $document = new Document();

        $document->setName($data->document_name ?? throw new HttpException(400, 'missing document name'));
        $document->setContent($data->document_content ?? throw new HttpException(400, 'missing document content'));
        $document->setDescription($data->document_description ?? throw new HttpException(400, 'missing document description'));

        // adding type
        $types = [
            '/\.(?<ext>(jpg)|(jpeg)|(gif))$/i' => 'Picture',
            '/\.(?<ext>(pdf))$/i' => 'Document' 
        ];

        foreach ($types as $regex => $type) {
            if (preg_match($regex, $data->document_name)) {
                $document->setDocumentType($this->documentTypeRepository->findOneBy([ 'type' => $type ]));
            }
        }

        // adding relations 
        $document->setArticle($article);

        // saving document
        $this->documentRepository->save($document, true);

        // returning updated article
        return $document;
    }
}
