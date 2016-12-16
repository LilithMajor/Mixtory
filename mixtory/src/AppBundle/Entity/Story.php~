<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Story
 *
 * @ORM\Table(name="story")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StoryRepository")
 */
class Story
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var bool
     *
     * @ORM\Column(name="on_going", type="boolean")
     */
    private $onGoing;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_author", type="integer")
     */
    private $nbrAuthor;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Story
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set onGoing
     *
     * @param boolean $onGoing
     *
     * @return Story
     */
    public function setOnGoing($onGoing)
    {
        $this->onGoing = $onGoing;

        return $this;
    }

    /**
     * Get onGoing
     *
     * @return bool
     */
    public function getOnGoing()
    {
        return $this->onGoing;
    }

    /**
     * Set nbrAuthor
     *
     * @param integer $nbrAuthor
     *
     * @return Story
     */
    public function setNbrAuthor($nbrAuthor)
    {
        $this->nbrAuthor = $nbrAuthor;

        return $this;
    }

    /**
     * Get nbrAuthor
     *
     * @return int
     */
    public function getNbrAuthor()
    {
        return $this->nbrAuthor;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * return Story
     */
    public function setImage()
    {
        $this->$image = $image;

        return $this;
    }
}
