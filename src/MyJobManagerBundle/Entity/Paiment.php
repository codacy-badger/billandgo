<?php

namespace MyJobManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paiment
 *
 * @ORM\Table(name="paiment", indexes={@ORM\Index(name="idx_paiment", columns={"ref_user"})})
 * @ORM\Entity
 */
class Paiment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_paiment", type="date", nullable=true)
     */
    private $datePaiment;

    /**
     * @var string
     *
     * @ORM\Column(name="mode", type="string", nullable=false)
     */
    private $mode;

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
     * @var \MyJobManagerBundle\Entity\Document
     *
     * @ORM\ManyToMany(targetEntity="MyJobManagerBundle\Entity\Document", mappedBy="refPaiment")
     * @ORM\JoinTable(name="bill_paiment",
     *		joinColumns={@ORM\JoinColumn(name="bill_id", referencedColumnName="id")},
     *		inverseJoinColumns={@ORM\JoinColumn(name="paiment_id", referencedColumnName="id")}
     *		)
     */
    private $refBill;





    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return Paiment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set datePaiment
     *
     * @param \DateTime $datePaiment
     *
     * @return Paiment
     */
    public function setDatePaiment($datePaiment)
    {
        $this->datePaiment = $datePaiment;

        return $this;
    }

    /**
     * Get datePaiment
     *
     * @return \DateTime
     */
    public function getDatePaiment()
    {
        return $this->datePaiment;
    }

    /**
     * Set mode
     *
     * @param string $mode
     *
     * @return Paiment
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Get mode
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
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
     * Set refUser
     *
     * @param \MyJobManagerBundle\Entity\User $refUser
     *
     * @return Paiment
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
     * Constructor
     */
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->refBill = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add refBill
     *
     * @param \MyJobManagerBundle\Entity\Document $refBill
     *
     * @return Paiment
     */
    public function addRefBill(\MyJobManagerBundle\Entity\Document $refBill)
    {
        $this->refBill[] = $refBill;

        return $this;
    }

    /**
     * alias of addrefBill
     *
     * @param \MyJobManagerBundle\Entity\Document $refBill
     *
     * @return Paiment
     */
    public function setRefBill(\MyJobManagerBundle\Entity\Document $refBill)
    {
        $this->refBill[] = $refBill;

        return $this;
    }

    /**
     * Remove refBill
     *
     * @param \MyJobManagerBundle\Entity\Document $refBill
     */
    public function removeRefBill(\MyJobManagerBundle\Entity\Document $refBill)
    {
        $this->refBill->removeElement($refBill);
    }

    /**
     * Get refBill
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRefBill()
    {
        return $this->refBill;
    }
}
