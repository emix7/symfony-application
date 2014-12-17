<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AdminBundle\Controller;

use BehaviorBundle\Model\TraversableInterface;
use Sonata\AdminBundle\Controller\CRUDController as Controller;

class BaseAdminController extends Controller
{
    const MOVE_DIRECTION_UP = 0;
    const MOVE_DIRECTION_DOWN = 1;

    public function upAction($id)
    {
        return $this->move($id, self::MOVE_DIRECTION_UP);
    }

    public function downAction($id)
    {
        return $this->move($id, self::MOVE_DIRECTION_DOWN);
    }

    protected function move($id, $direction)
    {
        $manager = $this->getDoctrine()->getManager();
        $repository = $manager->getRepository($this->admin->getClass());

        $entity = $repository->findOneById($id);
        $position = $entity->getPosition();

        $queryBuilder = $repository->createQueryBuilder('e')
            ->andWhere('e.position '.(($direction == self::MOVE_DIRECTION_UP) ? '<' : '>').' :position')
            ->setParameter('position', $position)
            ->orderBy('e.position', ($direction == self::MOVE_DIRECTION_UP) ? 'DESC' : 'ASC')
            ->setMaxResults(1);

        if ($entity instanceof TraversableInterface) {
            $queryBuilder
                ->andWhere('e.parent = :parent')
                ->setParameter('parent', $this->getRequest()->query->get('parent'));
        }

        $query = $queryBuilder
            ->getQuery();

        $results = $query->execute();

        if (count($results) == 1) {
            $otherEntity = $results[0];
            $entity->setPosition($otherEntity->getPosition());
            $otherEntity->setPosition($position);
            $manager->persist($entity);
            $manager->persist($otherEntity);
            $manager->flush();
        }

        return $this->redirect($this->getRequest()->headers->get('referer'));
    }
}
