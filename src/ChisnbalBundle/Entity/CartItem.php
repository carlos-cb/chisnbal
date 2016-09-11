<?php

namespace ChisnbalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CartItem
 */
class CartItem
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $quantity;


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
     * Set quantity
     *
     * @param integer $quantity
     * @return CartItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    /**
     * @var \ChisnbalBundle\Entity\Cart
     */
    private $cart;

    /**
     * @var \ChisnbalBundle\Entity\Product
     */
    private $product;


    /**
     * Set cart
     *
     * @param \ChisnbalBundle\Entity\Cart $cart
     * @return CartItem
     */
    public function setCart(\ChisnbalBundle\Entity\Cart $cart = null)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get cart
     *
     * @return \ChisnbalBundle\Entity\Cart 
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set product
     *
     * @param \ChisnbalBundle\Entity\Product $product
     * @return CartItem
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
    /**
     * @var integer
     */
    private $unit;

    /**
     * @var string
     */
    private $color;


    /**
     * Set unit
     *
     * @param integer $unit
     * @return CartItem
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return integer 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return CartItem
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @var string
     */
    private $foto;


    /**
     * Set foto
     *
     * @param string $foto
     * @return CartItem
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string 
     */
    public function getFoto()
    {
        return $this->foto;
    }
    /**
     * @var integer
     */
    private $colorId;

    /**
     * @var string
     */
    private $colorName;


    /**
     * Set colorId
     *
     * @param integer $colorId
     * @return CartItem
     */
    public function setColorId($colorId)
    {
        $this->colorId = $colorId;

        return $this;
    }

    /**
     * Get colorId
     *
     * @return integer 
     */
    public function getColorId()
    {
        return $this->colorId;
    }

    /**
     * Set colorName
     *
     * @param string $colorName
     * @return CartItem
     */
    public function setColorName($colorName)
    {
        $this->colorName = $colorName;

        return $this;
    }

    /**
     * Get colorName
     *
     * @return string 
     */
    public function getColorName()
    {
        return $this->colorName;
    }
}
