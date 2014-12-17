<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace NewsBundle\Controller;

use NewsBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('NewsBundle:Article');
        $query = $repository->createQueryBuilder('a')
            ->join('a.translatable', 't')
            ->orderBy('t.date', 'DESC')
            ->getQuery();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1),
            5
        );

        return array(
            'pagination' => $pagination,
        );
    }

    /**
     * @Route("/{slug}")
     * @Template()
     */
    public function showAction(Article $article)
    {
        // Disable filters to allow for language switch
        $this->container->get('doctrine')->getManager()->getFilters()->disable('publishable');
        $this->container->get('doctrine')->getManager()->getFilters()->disable('translation');

        return array(
            'article' => $article,
        );
    }
}
