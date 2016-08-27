<?php

namespace ChisnbalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fotodetalle
 */
class Fotodetalle
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $fotodetalle;

    /**
     * @var string
     */
    private $descriptionEs;

    /**
     * @var string
     */
    private $descriptionEn;


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
     * Set fotodetalle
     *
     * @param string $fotodetalle
     * @return Fotodetalle
     */
    public function setFotodetalle($fotodetalle)
    {
        if(!empty($fotodetalle)) {
            $this->fotodetalle = $fotodetalle;
        }
        return $this;
    }

    /**
     * Get fotodetalle
     *
     * @return string 
     */
    public function getFotodetalle()
    {
        return $this->fotodetalle;
    }

    /**
     * Set descriptionEs
     *
     * @param string $descriptionEs
     * @return Fotodetalle
     */
    public function setDescriptionEs($descriptionEs)
    {
        $this->descriptionEs = $descriptionEs;

        return $this;
    }

    /**
     * Get descriptionEs
     *
     * @return string 
     */
    public function getDescriptionEs()
    {
        return $this->descriptionEs;
    }

    /**
     * Set descriptionEn
     *
     * @param string $descriptionEn
     * @return Fotodetalle
     */
    public function setDescriptionEn($descriptionEn)
    {
        $this->descriptionEn = $descriptionEn;

        return $this;
    }

    /**
     * Get descriptionEn
     *
     * @return string 
     */
    public function getDescriptionEn()
    {
        return $this->descriptionEn;
    }
    /**
     * @var \ChisnbalBundle\Entity\Product
     */
    private $product;


    /**
     * Set product
     *
     * @param \ChisnbalBundle\Entity\Product $product
     * @return Fotodetalle
     */
    public function setProduct(\ChisnbalBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \ChisnbalBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    public function __toString() {
        return strval($this->id);
    }
}
