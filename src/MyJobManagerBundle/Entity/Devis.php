<?php

namespace MyJobManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Devis
 *
 * @ORM\Table(name="devis")
 * @ORM\Entity
 */
class Devis
{
    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=20, nullable=false)
     */
    private $number;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation", type="datetime", nullable=false)
     */
    private $creation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validity", type="datetime", nullable=false)
     */
    private $validity;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \MyJobManagerBundle\Entity\Client
     *
     * @ORM\ManyToOne(targetEntity="MyJobManagerBundle\Entity\Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client", referencedColumnName="id")
     * })
     */
    private $client;

    /**
     * @var \MyJobManagerBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="MyJobManagerBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ref_user", referencedColumnName="id")
     * })
     */
    private $refUser;

    /**
     * @ORM\ManyToMany(targetEntity="DevisLine", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinTable(name="devis_devisline",
     *		joinColumns={@ORM\JoinColumn(name="devis_id", referencedColumnName="id")},
     *		inverseJoinColumns={@ORM\JoinColumn(name="devisline_id", referencedColumnName="id", unique=true)}
     *		)
     */
    private $lines;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=false)
     */
    private $status = 'draft';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sendTime", type="datetime", nullable=true)
     */
    private $sendTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="responseTime", type="datetime", nullable=true)
     */
    private $responseTime;

    /**
     * @var \MyJobManagerBundle\Entity\Bill
     *
     * @ORM\ManyToMany(targetEntity="MyJobManagerBundle\Entity\Bill", mappedBy="refEstimate")
     * @ORM\JoinTable(name="estimate_bill",
     *		joinColumns={@ORM\JoinColumn(name="bill_id", referencedColumnName="id")},
     *		inverseJoinColumns={@ORM\JoinColumn(name="estimate_id", referencedColumnName="id")}
     *		)
     */
    private $refBill;

    /**
     * @var \MyJobManagerBundle\Entity\Project
     *
     * @ORM\ManyToMany(targetEntity="MyJobManagerBundle\Entity\Project", mappedBy="refEstimate")
     * @ORM\JoinTable(name="estimate_project",
     *		joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id")},
     *		inverseJoinColumns={@ORM\JoinColumn(name="estimate_id", referencedColumnName="id")}
     *		)
     */
    private $refProject;


    /**
     * Set number
     *
     * @param string $number
     *
     * @return Devis
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set creation
     *
     * @param \DateTime $creation
     *
     * @return Devis
     */
    public function setCreation($creation)
    {
        $this->creation = $creation;

        return $this;
    }

    /**
     * Get creation
     *
     * @return \DateTime
     */
    public function getCreation()
    {
        return $this->creation;
    }

    /**
     * Set validity
     *
     * @param \DateTime $validity
     *
     * @return Devis
     */
    public function setValidity($validity)
    {
        $this->validity = $validity;

        return $this;
    }

    /**
     * Get validity
     *
     * @return \DateTime
     */
    public function getValidity()
    {
        return $this->validity;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Devis
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * Set client
     *
     * @param \MyJobManagerBundle\Entity\Client $clicli
     *
     * @return Devis
     */
    public function setClient(\MyJobManagerBundle\Entity\Client $clicli = null)
    {
        $this->client = $clicli;

        return $this;
    }

    /**
     * Get client
     *
     * @return \MyJobManagerBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set refUser
     *
     * @param \MyJobManagerBundle\Entity\User $refUser
     *
     * @return Devis
     */
    public function setRefUser(\MyJobManagerBundle\Entity\User $refUser = null)
    {
        $this->refUser = $refUser;

        return $this;
    }

    /**
     * Get refUser
     *
     * @return \MyJobManagerBundle\Entity\User
     */
    public function getRefUser()
    {
        return $this->refUser;
    }

    /**
     * @param DevisLine $line
     *
     * @return Devis
     */
    public function addLine(DevisLine $line)
    {
        $this->lines[] = $line;
    }

    /**
     * @param DevisLine $line
     *
     * @return Devis
     */
    public function removeLine(DevisLine $line)
    {
        $this->lines->removeElement($line);
    }

    /**
     * @return ArrayCollection
     */
    public function getLines()
    {
        return $this->lines;
    }

    public function __construct()
    {
        $this->lines = new ArrayCollection();
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Devis
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set sendTime
     *
     * @param \DateTime $sendTime
     *
     * @return Devis
     */
    public function setSendTime($sendTime)
    {
        $this->sendTime = $sendTime;

        return $this;
    }

    /**
     * Get sendTime
     *
     * @return \DateTime
     */
    public function getSendTime()
    {
        return $this->sendTime;
    }

    /**
     * Set responseTime
     *
     * @param \DateTime $responseTime
     *
     * @return Devis
     */
    public function setResponseTime($responseTime)
    {
        $this->responseTime = $responseTime;

        return $this;
    }

    /**
     * Get responseTime
     *
     * @return \DateTime
     */
    public function getResponseTime()
    {
        return $this->responseTime;
    }

    /**
     * Add refBill
     *
     * @param \MyJobManagerBundle\Entity\Bill $refBill
     *
     * @return Devis
     */
    public function addRefBill(\MyJobManagerBundle\Entity\Bill $refBill)
    {
        $this->refBill[] = $refBill;

        return $this;
    }

    /**
     * Remove refBill
     *
     * @param \MyJobManagerBundle\Entity\Bill $refBill
     */
    public function removeRefBill(\MyJobManagerBundle\Entity\Bill $refBill)
    {
        $this->refBill->removeElement($refBill);
    }

    /**
     * Get refBill
     *
     * @return ArrayCollection
     */
    public function getRefBill()
    {
        return $this->refBill;
    }

    /**
     * Add refProject
     *
     * @param \MyJobManagerBundle\Entity\Project $refProject
     *
     * @return Devis
     */
    public function addRefProject(\MyJobManagerBundle\Entity\Project $refProject)
    {
        $this->refProject[] = $refProject;

        return $this;
    }

    /**
     * Remove refProject
     *
     * @param \MyJobManagerBundle\Entity\Project $refProject
     */
    public function removeRefProject(\MyJobManagerBundle\Entity\Project $refProject)
    {
        $this->refProject->removeElement($refProject);
    }

    /**
     * Get refProject
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRefProject()
    {
        return $this->refProject;
    }
}