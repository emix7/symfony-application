<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;

class Loader extends DataFixtureLoader
{
    /**
     * {@inheritDoc}
     */
    protected function getFixtures()
    {
        return  array(
            __DIR__.'/forms.yml',
            __DIR__.'/pages.yml',
            __DIR__.'/news_articles.yml',
            __DIR__.'/menus.yml',
            __DIR__.'/users.yml',
        );
    }

    /**
     * Returns a route to a page.
     *
     * @param $id
     * @return string
     */
    public function pageRoute($id)
    {
        return 'page_page_show_'.$id;
    }
}
