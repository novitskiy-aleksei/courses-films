<?php

namespace Films\CatalogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Film
 *
 * @ORM\Entity(repositoryClass="FilmRepository")
 * @ORM\Table("film")
 * @ORM\Entity
 */
class Film
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\NotBlank(groups={"film"})
     * @Assert\Length(min=7, groups={"film"})
     * @ORM\Column(name="title", type="string")
     * @var
     */
    private $title;

    /**
     * @ORM\Column(name="picture", type="string")
     * @var
     */
    private $picture;

    /**
     * @Assert\NotBlank(groups={"film"})
     * @Assert\Length(min=7, groups={"film"})
     * @ORM\Column(name="description", type="string")
     * @var
     */
    private $description;

    /**
     * @ORM\Column(name="date", type="date")
     * @var
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity="Category", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="film_categories",
     *        joinColumns={@ORM\JoinColumn(name="film_id", referencedColumnName="id")},
     *        inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity="Director", inversedBy="films", cascade={"persist", "remove", "merge"})
     */
    private $director;

    /**
     * @ORM\ManyToMany(targetEntity="Actor", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="film_actors",
     *        joinColumns={@ORM\JoinColumn(name="film_id", referencedColumnName="id")},
     *        inverseJoinColumns={@ORM\JoinColumn(name="actor_id", referencedColumnName="id")}
     * )
     */
    private $actors;

    /**
     * @ORM\Column(name="rating", type="integer", options={"default"="0"})
     * @var
     */
    private $rating = 0;

    /**
     * @ORM\Column(name="active", type="boolean", options={"default"="1"})
     * @var
     */
    private $active = true;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    public function __construct()
    {
        $this->actors = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function populate($data = array())
    {
        foreach ($data as $field => $value) {
            if(property_exists($this, $field))
                $this->$field = $value;
        }
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function addActor($actor)
    {
        $this->actors[] = $actor;

        return $this;
    }

    public function addCategory($category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * @param mixed $actors
     */
    public function setActors($actors)
    {
        $this->actors = $actors;
    }

    /**
     * @return mixed
     */
    public function getActors()
    {
        return $this->actors;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $director
     */
    public function setDirector($director)
    {
        $this->director = $director;
    }

    /**
     * @return mixed
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }
}
