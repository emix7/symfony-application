<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Bundle\SearchBundle\Controller;

use Elastica\Filter\BoolAnd;
use Elastica\Filter\BoolOr;
use Elastica\Filter\Missing;
use Elastica\Filter\Terms;
use Elastica\Query;
use Elastica\Query\QueryString;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $search = $request->query->get('q');
        $finder = $this->get('fos_elastica.finder.'.$this->container->getParameter('search_index'));

        $queryString = new QueryString();
        $queryString->setQuery('*'.$search.'*');

        // Published is true or missing
        $publishedFilter = new Terms();
        $publishedFilter->setTerms('published', array('true'));

        $publishedMissingFilter = new Missing();
        $publishedMissingFilter->setField('published');

        $publishedOrFilter = new BoolOr();
        $publishedOrFilter->addFilter($publishedFilter);
        $publishedOrFilter->addFilter($publishedMissingFilter);

        // Locale is current locale or missing
        $localeFilter = new Terms();
        $localeFilter->setTerms('locale', array($this->getRequest()->getLocale()));

        $localeMissingFilter = new Missing();
        $localeMissingFilter->setField('locale');

        $localeOrFilter = new BoolOr();
        $localeOrFilter->addFilter($localeFilter);
        $localeOrFilter->addFilter($localeMissingFilter);

        // Combine filters
        $filter = new BoolAnd();
        $filter->addFilter($publishedOrFilter);
        $filter->addFilter($localeOrFilter);

        $query = new Query();
        $query->setQuery($queryString);
        $query->setFilter($filter);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $finder->createPaginatorAdapter($query),
            $this->get('request')->query->get('page', 1),
            5
        );

        return array(
            'query' => $search,
            'pagination' => $pagination
        );
    }
}
