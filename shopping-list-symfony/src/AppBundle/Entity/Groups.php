<?php
namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * Groups
 *
 * @ORM\Table(name="groups")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GroupsRepository")
 */
class Groups
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
     * @ORM\Column(name="group_name", type="string", length=255)
     */
    private $groupName;
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
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
    }
    /**
     * @param string $groupName
     * @return Groups
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
        return $this;
    }
    /**
     * @var User[]
     * @ORM\ManyToMany(targetEntity="User", mappedBy="groups")
     */
    private $users;
    /**
     * @return User[]
     */
    public function getUsers()
    {
        return $this->users;
    }
    /**
     * @param mixed $users
     * @return Groups
     */
    public function setUsers($users)
    {
        $this->users = $users;
        return $this;
    }
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }
    /**
     * @param User $users
     */
    public function addUser(User $user)
    {
        if ($this->users->contains($user)) {
            return;
        }
        $this->users->add($user);
        $user->addUserGroup($this);
    }
    /**
     * @param User $users
     */
    public function removeUser(User $user)
    {
        if (!$this->users->contains($user)) {
            return;
        }
        $this->users->removeElement($user);
        $user->removeUserGroup($this);
    }
}