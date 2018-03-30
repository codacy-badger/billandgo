<?php

namespace MyJobManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Client
 *
 * @ORM\Table(name="client", indexes={@ORM\Index(name="idx_client", columns={"user_ref"})})
 * @ORM\Entity
 */
class Client
{
    /**
     * @var string
     *
     * @ORM\Column(name="company_name", type="string", length=255, nullable=true)
     */
    private $companyName;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="text", length=65535, nullable=true)
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="zipcode", type="text", nullable=true)
     */
    private $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="text", length=65535, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="text", length=65535, nullable=true)
     */
    private $country;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \MyJobManagerBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="MyJobManagerBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_ref", referencedColumnName="id")
     * })
     */
    private $userRef;

    /**
     * @ORM\ManyToMany(targetEntity="ClientContact", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinTable(name="client_clientcontact",
     *		joinColumns={@ORM\JoinColumn(name="client_id", referencedColumnName="id")},
     *		inverseJoinColumns={@ORM\JoinColumn(name="contact_id", referencedColumnName="id", unique=true)}
     *		)
     */
    private $contactRef;



    /**
     * Set companyName
     *
     * @param string $companyName
     *
     * @return Client
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return Client
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set zipcode
     *
     * @param boolean $zipcode
     *
     * @return Client
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return boolean
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Client
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Client
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
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
     * Set userRef
     *
     * @param \MyJobManagerBundle\Entity\User $userRef
     *
     * @return Client
     */
    public function setUserRef(\MyJobManagerBundle\Entity\User $userRef = null)
    {
        $this->userRef = $userRef;

        return $this;
    }

    /**
     * Get userRef
     *
     * @return \MyJobManagerBundle\Entity\User
     */
    public function getUserRef()
    {
        return $this->userRef;
    }
    
    /**
     * @param ClientContact $contact
     *
     * @return Client
     */
    public function addContact(ClientContact $contact)
    {
    	$this->contactRef[] = $contact;
    }
    
    /**
     * @param ClientContact $contact
     *
     * @return Client
     */
    public function removeContact(ClientContact $contact)
    {
    	$this->contactRef->removeElement($contact);
    }
    
    /**
     * @return ArrayCollection
     */
    public function getContacts()
    {
    	return $this->contactRef;
    }
    
    public function __construct()
    {
    	$this->contactRef = new ArrayCollection();
    }
}
