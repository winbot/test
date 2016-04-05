<?php

namespace First\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * visitors
 */
class visitors
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nameV;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $groupV;


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
     * Set nameV
     *
     * @param string $nameV
     * @return visitors
     */
    public function setNameV($nameV)
    {
        $this->nameV = $nameV;

        return $this;
    }

    /**
     * Get nameV
     *
     * @return string 
     */
    public function getNameV()
    {
        return $this->nameV;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return visitors
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
     * Set email
     *
     * @param string $email
     * @return visitors
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
     * Set groupV
     *
     * @param string $groupV
     * @return visitors
     */
    public function setGroupV($groupV)
    {
        $this->groupV = $groupV;

        return $this;
    }

    /**
     * Get groupV
     *
     * @return string 
     */
    public function getGroupV()
    {
        return $this->groupV;
    }
}
