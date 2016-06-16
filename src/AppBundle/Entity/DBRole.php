<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 29.05.2016
 * Time: 13:44
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="role")
 */
/**
 * @ORM\Table(name="roles")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DBRoleRepository")
 */
class DBRole implements RoleInterface
{
	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id()
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=30)
	 */
	private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="role", type="string", length=20, unique=true)
	 */
	private $role;

	public function __construct()
	{
		$this->users = new ArrayCollection();
	}

	/**
	 * Get role
	 *
	 * @see RoleInterface
	 */
	public function getRole()
	{
		return $this->role;
	}

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
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
     * Set name
     *
     * @param string $name
     *
     * @return DBRole
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return DBRole
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

	public function __toString()
	{
		return $this->getName() . ': ' . $this->getRole();
	}
}
