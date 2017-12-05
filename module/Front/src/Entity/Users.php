<?php

namespace Front\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users", indexes={@ORM\Index(name="created_by", columns={"created_by"}), @ORM\Index(name="modified_by", columns={"modified_by"}), @ORM\Index(name="status_id", columns={"status_id"}), @ORM\Index(name="level_id", columns={"level_id"})})
 * @ORM\Entity
 */
class Users
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
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=20, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="text", length=65535, nullable=true)
     */
    private $password;

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
     * @var \Front\Entity\UserLevels
     *
     * @ORM\ManyToOne(targetEntity="Front\Entity\UserLevels")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="level_id", referencedColumnName="id")
     * })
     */
    private $level;



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
     * Set username
     *
     * @param string $username
     *
     * @return Users
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return Users
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
     * @return Users
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
     * Set createdBy
     *
     * @param \Front\Entity\Users $createdBy
     *
     * @return Users
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
     * @return Users
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
     * @return Users
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

    /**
     * Set level
     *
     * @param \Front\Entity\UserLevels $level
     *
     * @return Users
     */
    public function setLevel(\Front\Entity\UserLevels $level = null)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return \Front\Entity\UserLevels
     */
    public function getLevel()
    {
        return $this->level;
    }
}
