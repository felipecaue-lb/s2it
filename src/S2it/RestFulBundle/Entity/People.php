<?php

namespace S2it\RestFulBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * People
 *
 * @ORM\Table(name="people")
 * @ORM\Entity(repositoryClass="S2it\RestFulBundle\Repository\PeopleRepository")
 */
class People
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
     * @var int
     *
     * @ORM\Column(name="personid", type="integer")
     */
    private $personid;

    /**
     * @var string
     *
     * @ORM\Column(name="personname", type="string", length=150)
     */
    private $personname;

    /**
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="people")
     */
    protected $phones;
    
    
    public function __construct()
    {
        $this->phones = new ArrayCollection();
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
     * Set personid
     *
     * @param integer $personid
     * @return People
     */
    public function setPersonid($personid)
    {
        $this->personid = $personid;

        return $this;
    }

    /**
     * Get personid
     *
     * @return integer 
     */
    public function getPersonid()
    {
        return $this->personid;
    }

    /**
     * Set personname
     *
     * @param string $personname
     * @return People
     */
    public function setPersonname($personname)
    {
        $this->personname = $personname;

        return $this;
    }

    /**
     * Get personname
     *
     * @return string 
     */
    public function getPersonname()
    {
        return $this->personname;
    }
    
    /**
     * Get phones
     *
     * @return string 
     */
    public function getPhones()
    {
        return $this->cidades;
    }
     
    public function setPhones(ArrayCollection $phones)
    {
        foreach ($phones as $phone) {
            $phone->setPeople($this);
        }
        $this->phones = $phones;
        return $this;
    }
}
