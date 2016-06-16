<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 21.06.2016
 * Time: 1:10
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\DBOrderStatus;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class DBOrderStatusFixture extends AbstractFixture
{
	/**
	 * @param string $name
	 * @param ObjectManager $manager
	 * @return DBOrderStatusFixture
	 */
	private function newOrderStatus($name, $manager) {
		$status = new DBOrderStatus();
		$status->setName($name);

		$manager->persist($status);

		return $this;
	}

	public function load(ObjectManager $manager) {
		$this
			->newOrderStatus('Формируется', $manager)
			->newOrderStatus('Отправлено', $manager)
			->newOrderStatus('Доставлено', $manager);

		$manager->flush();
	}
}