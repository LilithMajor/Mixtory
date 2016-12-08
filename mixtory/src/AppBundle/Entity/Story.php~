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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var bool
     *
     * @ORM\Column(name="en_cours", type="boolean")
     */
    private $enCours;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_auteurs", type="integer")
     */
    private $nbrAuteurs;


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
     * Set titre
     *
     * @param string $titre
     *
     * @return Story
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set enCours
     *
     * @param boolean $enCours
     *
     * @return Story
     */
    public function setEnCours($enCours)
    {
        $this->enCours = $enCours;

        return $this;
    }

    /**
     * Get enCours
     *
     * @return bool
     */
    public function getEnCours()
    {
        return $this->enCours;
    }

    /**
     * Set nbrAuteurs
     *
     * @param integer $nbrAuteurs
     *
     * @return Story
     */
    public function setNbrAuteurs($nbrAuteurs)
    {
        $this->nbrAuteurs = $nbrAuteurs;

        return $this;
    }

    /**
     * Get nbrAuteurs
     *
     * @return int
     */
    public function getNbrAuteurs()
    {
        return $this->nbrAuteurs;
    }
}
