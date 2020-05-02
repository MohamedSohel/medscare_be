<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MedsUser
 *
 * @ORM\Table(name="meds_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MedsUserRepository")
 * @ORM\HasLifecycleCallbacks
 */
class MedsUser
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
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=12, unique=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="is_admin", type="boolean", nullable=false, options={"default"="0"})
     */
    private $isAdmin = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="otp", type="integer", length=6, unique=false, nullable= true)
     */
    private $oTP;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="otp_generated_at", type="datetime", nullable= true)
     */
    private $otp_generated_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date_time", type="datetime", nullable=true)
     */
    private $created_date_time;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update_date_time", type="datetime", nullable=true)
     */
    private $last_update_date_time;


    /**
     * Auto set the updated date.
     *
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->setLastUpdateDateTime(new \DateTime());
        $this->setOTPGeneratedAT(new \DateTime());
    }

    /**
     * Set initial value for created/updated values.
     *
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $now = new \DateTime();
        $this->setCreatedDateTime($now);
        $this->setLastUpdateDateTime($now);
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return MedsUser
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return MedsUser
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
     * Set phone
     *
     * @param string $phone
     *
     * @return MedsUser
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set oTP
     *
     * @param integer $oTP
     *
     * @return MedsUser
     */
    public function setOTP($oTP)
    {
        $this->oTP = $oTP;

        return $this;
    }

    /**
     * Get oTP
     *
     * @return int
     */
    public function getOTP()
    {
        return $this->oTP;
    }

    /**
     * Set admin.
     *
     * @param bool $monthly
     *
     * @return MedsUser
     */
    public function setIsAdmin($isAdmin)
    {
        $this->monthly = $isAdmin;

        return $this;
    }

    /**
     * Get monthly.
     *
     * @return bool
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Set last_update_date_time.
     * @param \DateTime $lastUpdateDateTime
     * @return MedsUser
     */
    public function setLastUpdateDateTime($lastUpdateDateTime)
    {
        $this->last_update_date_time = $lastUpdateDateTime;

        return $this;
    }

    /**
     * Get last_update_date_time.
     *
     * @return \DateTime
     */
    public function getLastUpdateDateTime()
    {
        return $this->last_update_date_time;
    }

    /**
     * Set last_update_date_time.
     * @param \DateTime $lastUpdateDateTime
     * @return MedsUser
     */
    public function setCreatedDateTime($lastUpdateDateTime)
    {
        $this->created_date_time = $lastUpdateDateTime;

        return $this;
    }

    /**
     * Get last_update_date_time.
     *
     * @return \DateTime
     */
    public function getCreatedDateTime()
    {
        return $this->created_date_time;
    }

    /**
     * Set last_update_date_time.
     * @param \DateTime $lastUpdateDateTime
     * @return MedsUser
     */
    public function setOTPGeneratedAT($otpGeneratedAt)
    {
        $this->otp_generated_at = $otpGeneratedAt;

        return $this;
    }

    /**
     * Get last_update_date_time.
     *
     * @return \DateTime
     */
    public function getOTPGenratedAt()
    {
        return $this->otp_generated_at;
    }

}

