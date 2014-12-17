<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BehaviorBundle\Model\PublishableInterface;
use BehaviorBundle\Model\PublishableTrait;
use BehaviorBundle\Model\SluggableInterface;
use BehaviorBundle\Model\SluggableTrait;
use BehaviorBundle\Model\TimestampableInterface;
use BehaviorBundle\Model\TimestampableTrait;
use BehaviorBundle\Model\TranslationInterface;
use BehaviorBundle\Model\TranslationTrait;
use NewsBundle\Model\ArticleInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="news_article")
 */
class Article implements ArticleInterface, PublishableInterface, SluggableInterface, TimestampableInterface, TranslationInterface
{
    use PublishableTrait;
    use SluggableTrait;
    use TimestampableTrait;
    use TranslationTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

    /**
     * Returns the ID.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the title.
     *
     * @param $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Returns the title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the content.
     *
     * @param $content
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Returns the content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Returns the string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return strval($this->title);
    }
}
