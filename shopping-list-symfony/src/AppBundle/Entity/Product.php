<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;



/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 *
 */

class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="item", type="string", length=255)
     */
    private $item;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="ShoppingList", inversedBy="products")
     * @ORM\JoinTable(name="products_lists")
     */
    private $shoppingLists;

    /**
     * @return mixed
     */
    public function getShoppingLists()
    {
        return $this->shoppingLists;
    }

    /**
     * @param mixed $shoppingLists
     */
    public function setShoppingLists($shoppingLists)
    {
        $this->shoppingLists = $shoppingLists;
    }

    public function __construct()
    {
        $this->shoppingLists = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set item.
     *
     * @param string $item
     *
     * @return Product
     */
    public function setItem($item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item.
     *
     * @return string
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set quantity.
     *
     * @param int $quantity
     *
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set price.
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
    /**
     * @param ShoppingList $shoppingList
     */
    public function addShoppingList(ShoppingList $shoppingList)
    {
        if ($this->shoppingLists->contains($shoppingList)) {
            return;
        }
        $this->shoppingLists->add($shoppingList);
        $shoppingList->addProduct($this);
    }
    /**
     * @param ShoppingList $shoppingList
     */
    public function removeShoppingList(ShoppingList $shoppingList)
    {
        if (!$this->shoppingLists->contains($shoppingList)) {
            return;
        }
        $this->shoppingLists->removeElement($shoppingList);
        $shoppingList->removeProduct($this);
    }
    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function __toString()
    {
        return $this->item;
    }
}
