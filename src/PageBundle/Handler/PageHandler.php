<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PageBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use PageBundle\Model\PageInterface;

class PageHandler implements PageHandlerInterface
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
     * Get a Page.
     *
     * @param mixed $id
     *
     * @return PageInterface
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }
}
