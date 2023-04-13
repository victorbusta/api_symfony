<?php

namespace App\Controller\CreateController;

use DateTimeImmutable;
use App\Entity\Article;
use App\Entity\Comment;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Controller\CreateController\AbstractCreateController;

#[AsController]
class CreateCommentController extends AbstractCreateController
{
    public function createEntity($data): Comment
    {
        // get article with/out commented comment
        preg_match('/articles\/(?<article_id>\d+)\/comment\/{comment_id}/', $this->getRequest()->getPathInfo(), $match);

        $article = $this->articleRepository->find($match['article_id'] ?? throw new HttpException(400, 'missing article id'));
        $commented = $this->commentRepository->find($match['comment_id']);

        // create comment
        $comment = new Comment();

        $comment->setContent($data->content ?? throw new HttpException(400, 'missing content'));

        // setting creation date
        $comment->setCreatedAt(new DateTimeImmutable());

        // adding relations 
        $comment->setArticle($article);
        $comment->setUser($this->getUser());

        if (isset($commented)) {
            $comment->setComment($commented);
        }

        // saving document
        $this->commentRepository->save($comment, true);

        // returning the comment
        return $comment;
    }
}
