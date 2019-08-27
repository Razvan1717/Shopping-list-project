<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ShoppingList
 *
 * @ORM\Table(name="shopping_list")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ShoppingListRepository")
 */
class ShoppingList
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
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ShoppingList
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
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
     * @ORM\OneToMany(targetEntity="Event", mappedBy="shoppingList")
     */
    private $events;

    /**
     * @return mixed
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param mixed $events
     * @return ShoppingList
     */
    public function setEvents($events)
    {
        $this->events = $events;
        return $this;
    }

    /**
     * @var Product[]
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="shoppingLists")
     */
    private $products;

    /**
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param Product[] $products
     * @return ShoppingList
     */
    public function setProducts($products)
    {
        $this->products = $products;
        return $this;
    }
    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->events = new ArrayCollection();
    }
    /**
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        if ($this->products->contains($product)) {
            return;
        }
        $this->products->add($product);
        $product->addShoppingList($this);
    }
    /**
     * @param Product $product
     */
    public function removeProduct(Product $product)
    {
        if (!$this->products->contains($product)) {
            return;
        }
        $this->products->removeElement($product);
        $product->removeShoppingList($this);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
