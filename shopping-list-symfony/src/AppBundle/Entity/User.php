<?php
// src/AppBundle/Entity/User.php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Event", inversedBy="users")
     * @ORM\JoinTable(name="users_events")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="user")
     */
    private $products;


    public function __construct()
    {
        parent::__construct();
        $this->events = new ArrayCollection();
        $this->products = new ArrayCollection();

        // your own logic
    }
    /**
     * @param Event $event
     */
    public function addUserEvent(Event $event)
    {
        if ($this->events->contains($event)) {
            return;
        }
        $this->events->add($event);
        $event->addEvent($this);
    }
    /**
     * @param Event $event
     */
    public function removeUserEvent(Event $event)
    {
        if (!$this->events->contains($event)) {
            return;
        }
        $this->events->removeElement($event);
        $event->removeEvent($this);
    }
    /**
     * @return mixed
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param mixed $events
     * @return User
     */
    public function setEvents($events)
    {
        $this->events = $events;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     * @return User
     */
    public function setProducts($products)
    {
        $this->products = $products;
        return $this;
    }

}