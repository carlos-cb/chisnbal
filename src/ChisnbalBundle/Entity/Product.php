<?php

namespace ChisnbalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 */
class Product
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $productNameEs;

    /**
     * @var string
     */
    private $productNameEn;

    /**
     * @var float
     */
    private $price;

    /**
     * @var string
     */
    private $codigo;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $foto;

    /**
     * @var array
     */
    private $size;

    /**
     * @var bool
     */
    private $isSale;

    /**
     * @var float
     */
    private $discountPrice;

    /**
     * @var bool
     */
    private $isNew;

    /**
     * @var int
     */
    private $unit;

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
     * Set productNameEs
     *
     * @param string $productNameEs
     * @return Product
     */
    public function setProductNameEs($productNameEs)
    {
        $this->productNameEs = $productNameEs;

        return $this;
    }

    /**
     * Get productNameEs
     *
     * @return string 
     */
    public function getProductNameEs()
    {
        return $this->productNameEs;
    }

    /**
     * Set productNameEn
     *
     * @param string $productNameEn
     * @return Product
     */
    public function setProductNameEn($productNameEn)
    {
        $this->productNameEn = $productNameEn;

        return $this;
    }

    /**
     * Get productNameEn
     *
     * @return string 
     */
    public function getProductNameEn()
    {
        return $this->productNameEn;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Product
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set foto
     *
     * @param string $foto
     * @return Product
     */
    public function setFoto($foto)
    {
        if(!empty($foto)){
            $this->foto = $foto;
        }
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
     * Set size
     *
     * @param array $size
     * @return Product
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return array 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set isSale
     *
     * @param boolean $isSale
     * @return Product
     */
    public function setIsSale($isSale)
    {
        $this->isSale = $isSale;

        return $this;
    }

    /**
     * Get isSale
     *
     * @return boolean 
     */
    public function getIsSale()
    {
        return $this->isSale;
    }

    /**
     * Set discountPrice
     *
     * @param float $discountPrice
     * @return Product
     */
    public function setDiscountPrice($discountPrice)
    {
        $this->discountPrice = $discountPrice;

        return $this;
    }

    /**
     * Get discountPrice
     *
     * @return float 
     */
    public function getDiscountPrice()
    {
        return $this->discountPrice;
    }

    /**
     * Set isNew
     *
     * @param boolean $isNew
     * @return Product
     */
    public function setIsNew($isNew)
    {
        $this->isNew = $isNew;

        return $this;
    }

    /**
     * Get isNew
     *
     * @return boolean 
     */
    public function getIsNew()
    {
        return $this->isNew;
    }

    /**
     * Set unit
     *
     * @param integer $unit
     * @return Product
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
     * Set stock
     *
     * @param integer $stock
     * @return Product
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer 
     */
    public function getStock()
    {
        return $this->stock;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $colors;

    /**
     * @var \ChisnbalBundle\Entity\Category
     */
    private $category;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->colors = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add colors
     *
     * @param \ChisnbalBundle\Entity\Color $colors
     * @return Product
     */
    public function addColor(\ChisnbalBundle\Entity\Color $colors)
    {
        $this->colors[] = $colors;

        return $this;
    }

    /**
     * Remove colors
     *
     * @param \ChisnbalBundle\Entity\Color $colors
     */
    public function removeColor(\ChisnbalBundle\Entity\Color $colors)
    {
        $this->colors->removeElement($colors);
    }

    /**
     * Get colors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getColors()
    {
        return $this->colors;
    }

    /**
     * Set category
     *
     * @param \ChisnbalBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\ChisnbalBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \ChisnbalBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function __toString() {
        return strval($this->id);
    }

    /**
     * Get category
     *
     * @return \ChisnbalBundle\Entity\Category
     */
    public function getCategoryName()
    {
        return $this->category->getCategoryNameEs();
    }
    /**
     * @var boolean
     */
    private $isShow;

    /**
     * @var boolean
     */
    private $isHunzhuang;


    /**
     * Set isShow
     *
     * @param boolean $isShow
     * @return Product
     */
    public function setIsShow($isShow)
    {
        $this->isShow = $isShow;

        return $this;
    }

    /**
     * Get isShow
     *
     * @return boolean 
     */
    public function getIsShow()
    {
        return $this->isShow;
    }

    /**
     * Set isHunzhuang
     *
     * @param boolean $isHunzhuang
     * @return Product
     */
    public function setIsHunzhuang($isHunzhuang)
    {
        $this->isHunzhuang = $isHunzhuang;

        return $this;
    }

    /**
     * Get isHunzhuang
     *
     * @return boolean 
     */
    public function getIsHunzhuang()
    {
        return $this->isHunzhuang;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $sizes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $fotodetalles;


    /**
     * Add sizes
     *
     * @param \ChisnbalBundle\Entity\Size $sizes
     * @return Product
     */
    public function addSize(\ChisnbalBundle\Entity\Size $sizes)
    {
        $this->sizes[] = $sizes;

        return $this;
    }

    /**
     * Remove sizes
     *
     * @param \ChisnbalBundle\Entity\Size $sizes
     */
    public function removeSize(\ChisnbalBundle\Entity\Size $sizes)
    {
        $this->sizes->removeElement($sizes);
    }

    /**
     * Get sizes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSizes()
    {
        return $this->sizes;
    }

    /**
     * Add fotodetalles
     *
     * @param \ChisnbalBundle\Entity\Fotodetalle $fotodetalles
     * @return Product
     */
    public function addFotodetalle(\ChisnbalBundle\Entity\Fotodetalle $fotodetalles)
    {
        $this->fotodetalles[] = $fotodetalles;

        return $this;
    }

    /**
     * Remove fotodetalles
     *
     * @param \ChisnbalBundle\Entity\Fotodetalle $fotodetalles
     */
    public function removeFotodetalle(\ChisnbalBundle\Entity\Fotodetalle $fotodetalles)
    {
        $this->fotodetalles->removeElement($fotodetalles);
    }

    /**
     * Get fotodetalles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFotodetalles()
    {
        return $this->fotodetalles;
    }
}
