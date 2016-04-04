<?php

namespace First\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * cold_dishes_meat
 */
class cold_dishes_meat
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $portion;

    /**
     * @var string
     */
    private $cost;

    /**
     * @var string
     */
    private $composition;


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
     * Set name
     *
     * @param string $name
     * @return hot_dishes_fish
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
     * Set portion
     *
     * @param array $portion
     * @return hot_dishes_fish
     */
    public function setPortion($portion)
    {
        $this->portion = $portion;

        return $this;
    }

    /**
     * Get portion
     *
     * @return array 
     */
    public function getPortion()
    {
        return $this->portion;
    }

    /**
     * Set cost
     *
     * @param string $cost
     * @return hot_dishes_fish
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
     * Set composition
     *
     * @param string $composition
     * @return hot_dishes_fish
     */
    public function setComposition($composition)
    {
        $this->composition = $composition;

        return $this;
    }

    /**
     * Get composition
     *
     * @return string 
     */
    public function getComposition()
    {
        return $this->composition;
    }
}
