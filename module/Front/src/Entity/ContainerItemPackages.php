<?php

namespace Front\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContainerItemPackages
 *
 * @ORM\Table(name="container_item_packages", indexes={@ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="modified_by", columns={"modified_by"}), @ORM\Index(name="status_id", columns={"status_id"}), @ORM\Index(name="unit_id", columns={"item_package_id"})})
 * @ORM\Entity
 */
class ContainerItemPackages
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
     * @var \Front\Entity\ItemPackages
     *
     * @ORM\ManyToOne(targetEntity="Front\Entity\ItemPackages")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="item_package_id", referencedColumnName="id")
     * })
     */
    private $itemPackage;

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
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return ContainerItemPackages
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
     * @return ContainerItemPackages
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
     * Set itemPackage
     *
     * @param \Front\Entity\ItemPackages $itemPackage
     *
     * @return ContainerItemPackages
     */
    public function setItemPackage(\Front\Entity\ItemPackages $itemPackage = null)
    {
        $this->itemPackage = $itemPackage;

        return $this;
    }

    /**
     * Get itemPackage
     *
     * @return \Front\Entity\ItemPackages
     */
    public function getItemPackage()
    {
        return $this->itemPackage;
    }

    /**
     * Set createdBy
     *
     * @param \Front\Entity\Users $createdBy
     *
     * @return ContainerItemPackages
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
     * @return ContainerItemPackages
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
     * Set status
     *
     * @param \Front\Entity\GlobalStatus $status
     *
     * @return ContainerItemPackages
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
