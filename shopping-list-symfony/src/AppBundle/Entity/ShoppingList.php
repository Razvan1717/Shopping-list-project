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
     * @var Product[]
     * @ORM\OneToMany(targetEntity="Product", mappedBy="shoppingList")
     */
    private $products;

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
     * @ORM\OneToOne(targetEntity="Event", mappedBy="shoppingList")
     */
    private $event;

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param mixed $event
     * @return ShoppingList
     */
    public function setEvent($event)
    {
        $this->event = $event;
        return $this;
    }

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
    }
//    /**
//     * @param Product $product
//     */
//    public function addProduct(Product $product)
//    {
//        if ($this->products->contains($product)) {
//            return;
//        }
//        $this->products->add($product);
//        $product->addShoppingList($this);
//    }
//    /**
//     * @param Product $product
//     */
//    public function removeProduct(Product $product)
//    {
//        if (!$this->products->contains($product)) {
//            return;
//        }
//        $this->products->removeElement($product);
//        $product->removeShoppingList($this);
//    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
