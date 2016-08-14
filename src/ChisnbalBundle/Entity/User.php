<?php

namespace ChisnbalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User
{
    /**
     * @var int
     */
    private $id;


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
     * @var \ChisnbalBundle\Entity\Cart
     */
    private $cart;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $orderInfos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orderInfos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set cart
     *
     * @param \ChisnbalBundle\Entity\Cart $cart
     * @return User
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
     * Add orderInfos
     *
     * @param \ChisnbalBundle\Entity\OrderInfo $orderInfos
     * @return User
     */
    public function addOrderInfo(\ChisnbalBundle\Entity\OrderInfo $orderInfos)
    {
        $this->orderInfos[] = $orderInfos;

        return $this;
    }

    /**
     * Remove orderInfos
     *
     * @param \ChisnbalBundle\Entity\OrderInfo $orderInfos
     */
    public function removeOrderInfo(\ChisnbalBundle\Entity\OrderInfo $orderInfos)
    {
        $this->orderInfos->removeElement($orderInfos);
    }

    /**
     * Get orderInfos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrderInfos()
    {
        return $this->orderInfos;
    }
}
