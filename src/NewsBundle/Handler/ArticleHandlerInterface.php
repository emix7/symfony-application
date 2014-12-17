<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace NewsBundle\Handler;

use NewsBundle\Model\ArticleInterface;

interface ArticleHandlerInterface
{
    /**
     * Get an Article given the identifier
     *
     * @api
     *
     * @param mixed $id
     *
     * @return ArticleInterface
     */
    public function get($id);
}
