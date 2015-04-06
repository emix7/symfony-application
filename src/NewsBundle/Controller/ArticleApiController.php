<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace NewsBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use NewsBundle\Form\Type\ArticleType;
use NewsBundle\Entity\Article;
use NewsBundle\Handler\ArticleHandler;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ArticleApiController extends FOSRestController
{
    /**
     * Lists all articles.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Security("has_role('ROLE_API_USER')")
     *
     * @Annotations\QueryParam(
     *   name="offset",
     *   requirements="\d+",
     *   nullable=true,
     *   description="Offset from which to start listing articles."
     * )
     * @Annotations\QueryParam(
     *   name="limit",
     *   requirements="\d+",
     *   default="5",
     *   description="How many articles to return."
     * )
     *
     * @Annotations\View(statusCode=200)
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return array
     */
    public function getArticlesAction(ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');

        return $this->getArticleHandler()->getAll($limit, $offset);
    }

    /**
     * Returns an article.
     *
     * @Security("has_role('ROLE_API_USER')")
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "NewsBundle\Entity\Article",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the article is not found"
     *   }
     * )
     *
     * @Annotations\View(statusCode=200)
     *
     * @param int $id
     *
     * @return Article
     */
    public function getArticleAction($id)
    {
        $article = $this->getArticleHandler()->get($id);

        return $article;
    }

    /**
     * Creates an article.
     *
     * @Security("has_role('ROLE_API_ADMIN')")
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "NewsBundle\Form\Type\ArticleType",
     *   output = "NewsBundle\Entity\Article",
     *   statusCodes = {
     *     201 = "Returned when the article is created",
     *     400 = "Returned when the request is invalid"
     *   }
     * )
     *
     * @Annotations\View(statusCode=201)
     *
     * @param Request $request
     *
     * @return Article
     */
    public function postArticleAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(new ArticleType(), $article);

        $form->handleRequest($request);

        if (!$form->isValid()) {
            return View::create($form->getErrors(true, false), 400);
        }

        $article = $form->getData();
        $this->getArticleHandler()->save($article);

        return $article;
    }

    /**
     * Updates an article.
     *
     * @Security("has_role('ROLE_API_ADMIN')")
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "NewsBundle\Form\Type\ArticleType",
     *   output = "NewsBundle\Entity\Article",
     *   statusCodes = {
     *     201 = "Returned when the article is updated",
     *     400 = "Returned when the request is invalid",
     *     404 = "Returned when the article is not found"
     *   }
     * )
     *
     * @Annotations\View(statusCode=201)
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Article
     */
    public function putArticleAction(Request $request, $id)
    {
        $article = $this->getArticleHandler()->get($id);

        $form = $this->createForm(new ArticleType(), $article, array('method' => 'PUT'));

        $form->handleRequest($request);

        if (!$form->isValid()) {
            return View::create($form->getErrors(true, false), 400);
        }

        $article = $form->getData();
        $this->getArticleHandler()->save($article);

        return $article;
    }

    /**
     * Deletes all articles.
     *
     * @Security("has_role('ROLE_API_ADMIN')")
     *
     * @ApiDoc(
     *   statusCodes = {
     *     204 = "Returned when the articles are removed",
     *     400 = "Returned when the request is invalid"
     *   }
     * )
     *
     * @Annotations\View(statusCode=204)
     */
    public function deleteArticlesAction()
    {
        $this->getArticleHandler()->deleteAll();
    }

    /**
     * Deletes an article.
     *
     * @Security("has_role('ROLE_API_ADMIN')")
     *
     * @ApiDoc(
     *   statusCodes = {
     *     204 = "Returned when the article is removed",
     *     400 = "Returned when the request is invalid",
     *     404 = "Returned when the article is not found"
     *   }
     * )
     *
     * @Annotations\View(statusCode=204)
     *
     * @param $id
     */
    public function deleteArticleAction($id)
    {
        $article = $this->getArticleHandler()->get($id);

        $this->getArticleHandler()->delete($article);
    }

    /**
     * Returns the article handler.
     *
     * @return ArticleHandler
     */
    public function getArticleHandler()
    {
        return $this->get('news.article.handler');
    }
}
