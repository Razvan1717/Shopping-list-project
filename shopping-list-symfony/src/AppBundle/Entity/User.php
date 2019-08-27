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
    public function __construct()
    {
        parent::__construct();
        $this->groups = new ArrayCollection();
        // your own logic
    }
    /**
     * @ORM\ManyToMany(targetEntity="Groups", inversedBy="users")
     * @ORM\JoinTable(name="users_groups")
     */
    protected $groups;
    /**
     * @return mixed
     */
    public function getGroups()
    {
        return $this->groups;
    }
    /**
     * @param mixed $groups
     * @return User
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
        return $this;
    }
    /**
     * @param Groups $group
     */
    public function addUserGroup(Groups $group)
    {
        if ($this->groups->contains($group)) {
            return;
        }
        $this->groups->add($group);
        $group->addUser($this);
    }
    /**
     * @param Groups $group
     */
    public function removeUserGroup(Groups $group)
    {
        if (!$this->groups->contains($group)) {
            return;
        }
        $this->groups->removeElement($group);
        $group->removeUser($this);
    }
}