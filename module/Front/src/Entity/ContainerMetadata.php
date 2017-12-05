<?php

namespace Front\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContainerMetadata
 *
 * @ORM\Table(name="container_metadata", indexes={@ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="modified_by", columns={"modified_by"}), @ORM\Index(name="status_id", columns={"status_id"}), @ORM\Index(name="unit_id", columns={"container_id"})})
 * @ORM\Entity
 */
class ContainerMetadata
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
     * @var \Front\Entity\Containers
     *
     * @ORM\ManyToOne(targetEntity="Front\Entity\Containers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="container_id", referencedColumnName="id")
     * })
     */
    private $container;

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
     * @return ContainerMetadata
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
     * @return ContainerMetadata
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
     * Set container
     *
     * @param \Front\Entity\Containers $container
     *
     * @return ContainerMetadata
     */
    public function setContainer(\Front\Entity\Containers $container = null)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Get container
     *
     * @return \Front\Entity\Containers
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Set createdBy
     *
     * @param \Front\Entity\Users $createdBy
     *
     * @return ContainerMetadata
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
     * @return ContainerMetadata
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
     * @return ContainerMetadata
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
