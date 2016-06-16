<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 14.06.2016
 * Time: 2:01
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_items")
 */
class DBOrderItem
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DBOrder", inversedBy="order_items")
	 * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
	 */
	private $order;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DBItem")
	 * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
	 */
	private $item;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $count;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $price;

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
     * Set count
     *
     * @param integer $count
     *
     * @return DBOrderItem
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return DBOrderItem
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
     * Set order
     *
     * @param \AppBundle\Entity\DBOrder $order
     *
     * @return DBOrderItem
     */
    public function setOrder(\AppBundle\Entity\DBOrder $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \AppBundle\Entity\DBOrder
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set item
     *
     * @param \AppBundle\Entity\DBItem $item
     *
     * @return DBOrderItem
     */
    public function setItem(\AppBundle\Entity\DBItem $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \AppBundle\Entity\DBItem
     */
    public function getItem()
    {
        return $this->item;
    }

	public function __toString()
	{
		return $this->getItem()->getName();
	}
}
