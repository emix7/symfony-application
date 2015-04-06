<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BehaviorBundle\Model\TranslatableInterface;
use BehaviorBundle\Model\TranslatableTrait;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 * @ORM\Table(name="news_article_translatable")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class ArticleTranslatable implements TranslatableInterface
{
    use TranslatableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="date")
     *
     * @Serializer\Exclude
     */
    protected $date;

    /**
     * @ORM\OneToOne(targetEntity="MediaBundle\Entity\Media")
     */
    protected $image;

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
     * Sets the date.
     *
     * @param $date
     *
     * @return ArticleTranslatable
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Returns the date.
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the image.
     *
     * @param $image
     *
     * @return ArticleTranslatable
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Returns the image.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Returns the string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return strval($this->id);
    }
}
