<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 11.06.2016
 * Time: 21:10
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DBOrderRepository")
 * @ORM\Table(name="orders")
 */
class DBOrder
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
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DBUser", inversedBy="orders")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
	private $user;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(type="datetime", length=30)
	 */
	private $date;

	/**
	 * @var DBOrderStatus
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DBOrderStatus")
	 * @ORM\JoinColumn(referencedColumnName="id")
	 */
	private $status;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\DBOrderItem", mappedBy="order", cascade={"persist"})
	 */
	private $order_items;

	public function __construct()
	{
		$this->order_items = new ArrayCollection();
		$this->date = new \DateTime("now");
	}

	/**
	 * Get id
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return DBOrder
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add orderItem
     *
     * @param \AppBundle\Entity\DBOrderItem $orderItem
     *
     * @return DBOrder
     */
    public function addOrderItem(\AppBundle\Entity\DBOrderItem $orderItem)
    {
        $this->order_items[] = $orderItem;
	    $orderItem->setOrder($this);

        return $this;
    }

    /**
     * Remove orderItem
     *
     * @param \AppBundle\Entity\DBOrderItem $orderItem
     */
    public function removeOrderItem(\AppBundle\Entity\DBOrderItem $orderItem)
    {
        $this->order_items->removeElement($orderItem);
    }

    /**
     * Get orderItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderItems()
    {
        return $this->order_items;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\DBUser $user
     *
     * @return DBOrder
     */
    public function setUser(\AppBundle\Entity\DBUser $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\DBUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set status
     *
     * @param \AppBundle\Entity\DBOrderStatus $status
     *
     * @return DBOrder
     */
    public function setStatus(\AppBundle\Entity\DBOrderStatus $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \AppBundle\Entity\DBOrderStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

	/**
	 * Get Total count
	 *
	 * @return int
	 */
	public function getTotalCount() {
		$total_count = 0;
		foreach ($this->order_items as $order_item) {
			$total_count += $order_item->getCount();
		}
		return $total_count;
	}

	/**
	 * Get Total price
	 *
	 * @return int
	 */
	public function getTotalPrice() {
		$total_price = 0;
		foreach ($this->order_items as $order_item) {
			$total_price += $order_item->getPrice() * $order_item->getCount();
		}
		return $total_price;
	}
}
