<?php

namespace Films\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * Actor
 *
 * @ORM\Table("actor")
 * @ORM\Entity
 */
class Actor
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
     * @ORM\Column(name="firstname", type="string")
     * @var
     */
    private $firstname;

    /**
     * @ORM\Column(name="lastname", type="string")
     * @var
     */
    private $lastname;

    /**
     * @ORM\Column(name="birthdate", type="date")
     * @var
     */
    private $birthdate;

    /**
     * @ManyToMany(targetEntity="Film", mappedBy="actors")
     */
    private $films;

    public function populate($data = array())
    {
        foreach ($data as $field => $value)
        {
            if(property_exists($this, $field))
                $this->$field = $value;
        }
    }

    public function __toString()
    {
        return $this->firstname . ' ' . $this->lastname;
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

    /**
     * @param mixed $birthdate
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $films
     */
    public function setFilms($films)
    {
        $this->films = $films;
    }

    /**
     * @return mixed
     */
    public function getFilms()
    {
        return $this->films;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }
}
