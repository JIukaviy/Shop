<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 11.05.2016
 * Time: 13:25
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DBItemRepository")
 * @ORM\Table(name="items")
 */
class DBItem implements \JsonSerializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $price;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $description;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $preview;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="DBCategory", inversedBy="items")
     * @ORM\JoinTable(
     *     name="item_category_links",
     *     joinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     */
    private $categories;

    public function __construct() {
        $this->categories = new ArrayCollection();
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
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
     * @return DBItem
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return DBItem
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Add category
     *
     * @param \AppBundle\Entity\DBCategory $category
     *
     * @return DBItem
     */
    public function addCategory(\AppBundle\Entity\DBCategory $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \AppBundle\Entity\DBCategory $category
     */
    public function removeCategory(\AppBundle\Entity\DBCategory $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return DBItem
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
     * Set preview
     *
     * @param string $preview
     *
     * @return DBItem
     */
    public function setPreview($preview)
    {
        $this->preview = $preview;

        return $this;
    }

    /**
     * Get preview
     *
     * @return string
     */
    public function getPreview()
    {
        return $this->preview;
    }

	public function jsonSerialize()
	{
		return array(
			'id' => $this->id,
			'name' => $this->name,
			'preview' => $this->preview,
			'price' => $this->price
		);
	}

	public function __toString()
	{
		return $this->getName();
	}
}
