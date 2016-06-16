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
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DBCategoryRepository")
 * @ORM\Table(name="categories")
 */
class DBCategory
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $url_name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $path;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\DBItem", mappedBy="categories")
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
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
     * @return DBCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Set urlName
     *
     * @param string $urlName
     *
     * @return DBCategory
     */
    public function setUrlName($urlName)
    {
        $this->url_name = $urlName;

        return $this;
    }

    /**
     * Get urlName
     *
     * @return string
     */
    public function getUrlName()
    {
        return $this->url_name;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return DBCategory
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Add item
     *
     * @param \AppBundle\Entity\DBItem $item
     *
     * @return DBCategory
     */
    public function addItem(\AppBundle\Entity\DBItem $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \AppBundle\Entity\DBItem $item
     */
    public function removeItem(\AppBundle\Entity\DBItem $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    public function __toString()
    {
        return $this->getUrlName();
    }
}
