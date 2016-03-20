<?php

namespace First\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * zakaz
 */
class zakaz
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $idZak;

    /**
     * @var \DateTime
     */
    private $dateT;

    /**
     * @var string
     */
    private $portion;

    /**
     * @var int
     */
    private $idDishes;

    /**
     * @var string
     */
    private $cost;

    /**
     * @var string
     */
    private $nameTab;

    /**
     * @var boolean
     */
    private $accept;


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
     * Set idZak
     *
     * @param string $idZak
     * @return zakaz
     */
    public function setIdZak($idZak)
    {
        $this->idZak = $idZak;

        return $this;
    }

    /**
     * Get idZak
     *
     * @return string 
     */
    public function getIdZak()
    {
        return $this->idZak;
    }

    /**
     * Set dateT
     *
     * @param \DateTime $dateT
     * @return zakaz
     */
    public function setDateT($dateT)
    {
        $this->dateT = $dateT;

        return $this;
    }

    /**
     * Get dateT
     *
     * @return \DateTime 
     */
    public function getDateT()
    {
        return $this->dateT;
    }

    /**
     * Set portion
     *
     * @param string $portion
     * @return zakaz
     */
    public function setPortion($portion)
    {
        $this->portion = $portion;

        return $this;
    }

    /**
     * Get portion
     *
     * @return string 
     */
    public function getPortion()
    {
        return $this->portion;
    }

    /**
     * Set idDishes
     *
     * @param integer $idDishes
     * @return zakaz
     */
    public function setIdDishes($idDishes)
    {
        $this->idDishes = $idDishes;

        return $this;
    }

    /**
     * Get idDishes
     *
     * @return integer 
     */
    public function getIdDishes()
    {
        return $this->idDishes;
    }

    /**
     * Set cost
     *
     * @param string $cost
     * @return zakaz
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return string 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set nameTab
     *
     * @param string $nameTab
     * @return zakaz
     */
    public function setNameTab($nameTab)
    {
        $this->nameTab = $nameTab;

        return $this;
    }

    /**
     * Get nameTab
     *
     * @return string 
     */
    public function getNameTab()
    {
        return $this->nameTab;
    }

    /**
     * Set accept
     *
     * @param boolean $accept
     * @return zakaz
     */
    public function setAccept($accept)
    {
        $this->accept = $accept;

        return $this;
    }

    /**
     * Get accept
     *
     * @return boolean 
     */
    public function getAccept()
    {
        return $this->accept;
    }
}
