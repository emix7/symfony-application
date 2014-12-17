<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace NewsBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use NewsBundle\Model\ArticleInterface;

class ArticleHandler implements ArticleHandlerInterface
{
    protected $om;
    protected $entityClass;
    protected $repository;

    public function __construct(ObjectManager $om, $entityClass)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
    }

    /**
     * Get an Article.
     *
     * @param mixed $id
     *
     * @return ArticleInterface
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }
}
