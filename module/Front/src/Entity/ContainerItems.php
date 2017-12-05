<?php

namespace Front\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContainerItems
 *
 * @ORM\Table(name="container_items", indexes={@ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="modified_by", columns={"modified_by"}), @ORM\Index(name="status_id", columns={"status_id"}), @ORM\Index(name="unit_id", columns={"item_id"})})
 * @ORM\Entity
 */
class ContainerItems
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
     * @return ContainerItems
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
     * @return ContainerItems
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
     * @return ContainerItems
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
     * @return ContainerItems
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
     * @return ContainerItems
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
     * @return ContainerItems
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
