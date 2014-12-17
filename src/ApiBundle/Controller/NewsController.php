<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ApiBundle\Controller;

use NewsBundle\Model\ArticleInterface;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsController extends FOSRestController
{
    /**
     * Get single Article.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets an Article for a given id",
     *   output = "NewsBundle\Entity\Article",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the article is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="article")
     *
     * @param int $id the article id
     *
     * @return array
     *
     * @throws NotFoundHttpException when article not exist
     */
    public function getArticleAction($id)
    {
        $article = $this->getOr404($id);

        return $article;
    }

    /**
     * Fetch a Article or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return ArticleInterface
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id)
    {
        $article = $this->container->get('news.article.handler')->get($id);

        if (!$article instanceof ArticleInterface) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $article;
    }
}
