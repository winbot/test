<?php

namespace First\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AllOrder
 *
 * @ORM\Table(name="all_order")
 * @ORM\Entity
 */
class all_order
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $idOrder;

    /**
     * @var \DateTime
     */
    private $dateT;

    /**
     * @var string
     */
    private $portion;

    /**
     * @var integer
     */
    private $idDishes;

    /**
     * @var string
     */
    private $nameDishes;

    /**
     * @var string
     */
    private $cost;

    /**
     * @var string
     */
    private $nameTab;

    /**
     * @var string
     */
    private $ownerOrder;

    /**
     * @var string
     */
    private $groupOrder;

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
     * Set idOrder
     *
     * @param integer $idOrder
     * @return AllOrder
     */
    public function setIdOrder($idOrder)
    {
        $this->idOrder = $idOrder;

        return $this;
    }

    /**
     * Get idOrder
     *
     * @return integer 
     */
    public function getIdOrder()
    {
        return $this->idOrder;
    }

    /**
     * Set dateT
     *
     * @param \DateTime $dateT
     * @return AllOrder
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
     * @return AllOrder
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
     * @return AllOrder
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
     * Set nameDishes
     *
     * @param string $nameDishes
     * @return AllOrder
     */
    public function setNameDishes($nameDishes)
    {
        $this->nameDishes = $nameDishes;

        return $this;
    }

    /**
     * Get nameDishes
     *
     * @return string 
     */
    public function getNameDishes()
    {
        return $this->nameDishes;
    }

    /**
     * Set cost
     *
     * @param string $cost
     * @return AllOrder
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
     * @return AllOrder
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
     * Set ownerOrder
     *
     * @param string $ownerOrder
     * @return AllOrder
     */
    public function setOwnerOrder($ownerOrder)
    {
        $this->ownerOrder = $ownerOrder;

        return $this;
    }

    /**
     * Get ownerOrder
     *
     * @return string 
     */
    public function getOwnerOrder()
    {
        return $this->ownerOrder;
    }

    /**
     * Set groupOrder
     *
     * @param string $groupOrder
     * @return AllOrder
     */
    public function setGroupOrder($groupOrder)
    {
        $this->groupOrder = $groupOrder;

        return $this;
    }

    /**
     * Get groupOrder
     *
     * @return string 
     */
    public function getGroupOrder()
    {
        return $this->groupOrder;
    }

    /**
     * Set accept
     *
     * @param boolean $accept
     * @return AllOrder
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
