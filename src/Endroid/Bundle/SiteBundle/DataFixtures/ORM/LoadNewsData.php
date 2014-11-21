<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Bundle\SiteBundle\DataFixtures\ORM;

use DateInterval;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Endroid\Bundle\NewsBundle\Entity\Article;
use Endroid\Bundle\NewsBundle\Entity\ArticleTranslatable;

class LoadNewsData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $date = new DateTime('now');
        $interval = new DateInterval('P1D');

        for ($n = 1; $n <= 10; $n++) {
            $articleTranslatable = new ArticleTranslatable();
            $articleTranslatable->setDate($date);

            $article = new Article();
            $article->setTitle('Nieuwsartikel '.$n);
            $article->setContent('<p>Inhoud bij nieuwsartikel '.$n.'</p>');
            $article->setLocale('nl');
            $articleTranslatable->addTranslation($article);

            $article = new Article();
            $article->setTitle('News article '.$n);
            $article->setContent('<p>News article '.$n.' content</p>');
            $article->setLocale('en');
            $articleTranslatable->addTranslation($article);

            $manager->persist($article);
            $manager->flush();

            $date->add($interval);
            $date = clone $date;
        }
    }
}
