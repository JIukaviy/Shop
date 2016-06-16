<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 29.05.2016
 * Time: 13:20
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DBUserRepository")
 * @ORM\Table(name="users")
 */
class DBUser implements UserInterface, \Serializable
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=25, unique=true)
	 */
	private $username;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $password;

	/**
	 * @ORM\Column(type="string", length=60, unique=true)
	 */
	private $email;

	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\DBOrder", mappedBy="user")
	 */
	private $orders;

	/**
	 * @ORM\ManyToMany(targetEntity="AppBundle\Entity\DBRole")
	 * @ORM\JoinTable(
	 *     name="user_role_links",
	 *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
	 * )
	 */
	private $roles;

	public function __construct()
	{
		$this->roles = new ArrayCollection();
		$this->orders = new ArrayCollection();
		// may not be needed, see section on salt below
		// $this->salt = md5(uniqid(null, true));
	}

	/**
	 * Get username
	 *
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * Set username
	 *
	 * @param string $username
	 *
	 * @return DBUser
	 */
	public function setUsername($username)
	{
		$this->username = $username;

		return $this;
	}

	/**
	 * Get salt
	 *
	 * @return null
	 */
	public function getSalt()
	{
		// you *may* need a real salt depending on your encoder
		// see section on salt below
		return null;
	}

	/**
	 * Get password
	 *
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Set password
	 *
	 * @param string $password
	 *
	 * @return DBUser
	 */
	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * Get roles
	 *
	 * @return array
	 */
	public function getRoles()
	{
		return $this->roles->toArray();
	}

	/**
	 * Add role
	 *
	 * @param DBRole
	 *
	 * @return DBUser
	 */
	public function addRole($role) {
		$this->roles[] = $role;

		return $this;
	}

	public function eraseCredentials()
	{

	}

	/** @see \Serializable::serialize() */
	public function serialize()
	{
		return serialize(array(
			$this->id,
			$this->username,
			$this->password,
			// see section on salt below
			// $this->salt,
		));
	}

	/** @see \Serializable::unserialize() */
	public function unserialize($serialized)
	{
		list (
			$this->id,
			$this->username,
			$this->password,
			// see section on salt below
			// $this->salt
			) = unserialize($serialized);
	}

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
     * Set email
     *
     * @param string $email
     *
     * @return DBUser
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Add order
     *
     * @param \AppBundle\Entity\DBOrder $order
     *
     * @return DBUser
     */
    public function addOrder(\AppBundle\Entity\DBOrder $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \AppBundle\Entity\DBOrder $order
     */
    public function removeOrder(\AppBundle\Entity\DBOrder $order)
    {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Remove role
     *
     * @param \AppBundle\Entity\DBRole $role
     */
    public function removeRole(\AppBundle\Entity\DBRole $role)
    {
        $this->roles->removeElement($role);
    }
}
