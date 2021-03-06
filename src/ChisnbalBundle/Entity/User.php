<?php

namespace ChisnbalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 */
class User extends BaseUser
{
    /**
     * @var int
     */
    protected $id;

    protected $liciencia;

    protected $tel;


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
        parent::__construct();
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

    public function __toString() {
        return strval($this->id);
    }

    /**
     * Set liciencia
     *
     * @param string $liciencia
     * @return User
     */
    public function setLiciencia($liciencia)
    {
        $this->liciencia = $liciencia;

        return $this;
    }

    /**
     * Get liciencia
     *
     * @return string 
     */
    public function getLiciencia()
    {
        return $this->liciencia;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return User
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }
}
