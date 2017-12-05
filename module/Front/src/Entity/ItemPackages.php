<?php

namespace Front\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ItemPackages
 *
 * @ORM\Table(name="item_packages", indexes={@ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="modified_by", columns={"modified_by"}), @ORM\Index(name="unit_id", columns={"item_id"}), @ORM\Index(name="unit_id_2", columns={"unit_id"}), @ORM\Index(name="status_id", columns={"status_id"})})
 * @ORM\Entity
 */
class ItemPackages
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_of_object", type="integer", nullable=true)
     */
    private $numberOfObject;

    /**
     * @var string
     *
     * @ORM\Column(name="registration_number", type="string", length=50, nullable=true)
     */
    private $registrationNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     */
    private $createdOn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_on", type="datetime", nullable=true)
     */
    private $modifiedOn;

    /**
     * @var \Front\Entity\Items
     *
     * @ORM\ManyToOne(targetEntity="Front\Entity\Items")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     * })
     */
    private $item;

    /**
     * @var \Front\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="Front\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     * })
     */
    private $createdBy;

    /**
     * @var \Front\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="Front\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="modified_by", referencedColumnName="id")
     * })
     */
    private $modifiedBy;

    /**
     * @var \Front\Entity\Units
     *
     * @ORM\ManyToOne(targetEntity="Front\Entity\Units")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unit_id", referencedColumnName="id")
     * })
     */
    private $unit;

    /**
     * @var \Front\Entity\GlobalStatus
     *
     * @ORM\ManyToOne(targetEntity="Front\Entity\GlobalStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * })
     */
    private $status;



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
     * Set numberOfObject
     *
     * @param integer $numberOfObject
     *
     * @return ItemPackages
     */
    public function setNumberOfObject($numberOfObject)
    {
        $this->numberOfObject = $numberOfObject;

        return $this;
    }

    /**
     * Get numberOfObject
     *
     * @return integer
     */
    public function getNumberOfObject()
    {
        return $this->numberOfObject;
    }

    /**
     * Set registrationNumber
     *
     * @param string $registrationNumber
     *
     * @return ItemPackages
     */
    public function setRegistrationNumber($registrationNumber)
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    /**
     * Get registrationNumber
     *
     * @return string
     */
    public function getRegistrationNumber()
    {
        return $this->registrationNumber;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ItemPackages
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return ItemPackages
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set modifiedOn
     *
     * @param \DateTime $modifiedOn
     *
     * @return ItemPackages
     */
    public function setModifiedOn($modifiedOn)
    {
        $this->modifiedOn = $modifiedOn;

        return $this;
    }

    /**
     * Get modifiedOn
     *
     * @return \DateTime
     */
    public function getModifiedOn()
    {
        return $this->modifiedOn;
    }

    /**
     * Set item
     *
     * @param \Front\Entity\Items $item
     *
     * @return ItemPackages
     */
    public function setItem(\Front\Entity\Items $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \Front\Entity\Items
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set createdBy
     *
     * @param \Front\Entity\Users $createdBy
     *
     * @return ItemPackages
     */
    public function setCreatedBy(\Front\Entity\Users $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Front\Entity\Users
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set modifiedBy
     *
     * @param \Front\Entity\Users $modifiedBy
     *
     * @return ItemPackages
     */
    public function setModifiedBy(\Front\Entity\Users $modifiedBy = null)
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

    /**
     * Get modifiedBy
     *
     * @return \Front\Entity\Users
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     * Set unit
     *
     * @param \Front\Entity\Units $unit
     *
     * @return ItemPackages
     */
    public function setUnit(\Front\Entity\Units $unit = null)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return \Front\Entity\Units
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set status
     *
     * @param \Front\Entity\GlobalStatus $status
     *
     * @return ItemPackages
     */
    public function setStatus(\Front\Entity\GlobalStatus $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \Front\Entity\GlobalStatus
     */
    public function getStatus()
    {
        return $this->status;
    }
}
