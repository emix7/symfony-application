<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace NewsBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use NewsBundle\Entity\Article;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleHandler
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * Class constructor.
     *
     * @param ObjectManager $objectManager
     * @param $entityClass
     */
    public function __construct(ObjectManager $objectManager, $entityClass)
    {
        $this->objectManager = $objectManager;
        $this->entityClass = $entityClass;
        $this->repository = $this->objectManager->getRepository($this->entityClass);
    }

    /**
     * Get an article.
     *
     * @param int $id
     *
     * @return Article
     *
     * @throws NotFoundHttpException
     */
    public function get($id)
    {
        $article = $this->repository->findOneById($id);

        if (!$article) {
            throw new NotFoundHttpException();
        }

        return $article;
    }

    /**
     * Get all articles.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->repository->findAll();
    }

    /**
     * Adds an article.
     *
     * @param Article $article
     */
    public function save(Article $article)
    {
        $this->objectManager->persist($article);
        $this->objectManager->flush();
    }

    /**
     * Deletes an article.
     *
     * @param Article $article
     */
    public function delete(Article $article)
    {
        $this->objectManager->remove($article);
        $this->objectManager->flush();
    }

    /**
     * Deletes all articles.
     */
    public function deleteAll()
    {
        $articles = $this->getAll();

        foreach ($articles as $article) {
            $this->delete($article);
        }
    }
}
