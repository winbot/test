<?php

namespace First\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * main_menu
 */
class main_menu
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $namePage;

    /**
     * @var string
     */
    private $nameTab;


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
     * Set namePage
     *
     * @param string $namePage
     * @return main_menu
     */
    public function setNamePage($namePage)
    {
        $this->namePage = $namePage;

        return $this;
    }

    /**
     * Get namePage
     *
     * @return string 
     */
    public function getNamePage()
    {
        return $this->namePage;
    }

    /**
     * Set nameTab
     *
     * @param string $nameTab
     * @return main_menu
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
}
