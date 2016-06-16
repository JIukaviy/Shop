<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 21.06.2016
 * Time: 0:56
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\DBCategory;
use AppBundle\Entity\DBItem;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DBItemFixture extends AbstractFixture implements OrderedFixtureInterface
{

	/**
	 * @param string $name
	 * @param int $price
	 * @param string $description
	 * @param string $preview
	 * @param mixed $categories
	 * @param ObjectManager $manager
	 * @return DBItemFixture
	 */
	public function newItem($name, $price, $description, $preview, $categories, $manager) {
		$item = new DBItem();
		$item
			->setName($name)
			->setPrice($price)
			->setDescription($description)
			->setPreview($preview);

		if(is_array($categories)) {
			foreach ($categories as $category) {
				$item->addCategory($category);
			}
		} else {
			$item->addCategory($categories);
		}

		$manager->persist($item);

		return $this;
	}

	public function load(ObjectManager $manager) {
		$this
			->newItem('ASUS K501UX', 50000, 'Шикарен и неповторим', 'https://mdata.yandex.net/i?path=b0808191533_img_id1993394003250968479.jpeg', $this->getReference('cat-notebooks'), $manager)
			->newItem('ASUS J50X', 45000, 'Тоже не плох', 'https://mdata.yandex.net/i?path=b0105192632_img_id5827250679805591258.jpeg', $this->getReference('cat-ultrabooks'), $manager)
			->newItem('ASUS и любой другой набор букв и цифр', 39999, 'бебебе', 'https://mdata.yandex.net/i?path=b0223173341_img_id1264901338410988491.jpeg', $this->getReference('cat-desktop'), $manager)
			->newItem('Бамбук', 999, 'Курить вредно', 'http://zdorovia-vam.ucoz.com/_pu/15/s31443688.jpg', $this->getReference('cat-bambooks'), $manager)
			->newItem('Intel Pentium I', 2500, 'Хорошо подходит для отапливания помещений', 'https://mdata.yandex.net/i?path=b1207021930_img_id6371327434324262991.jpeg', $this->getReference('cat-processors'), $manager)
			->newItem('ASUS Z170 PRO GAMING', 2500, 'Родная', 'https://mdata.yandex.net/i?path=b0816111858_img_id1249053269558099641.jpeg', $this->getReference('cat-motherboards'), $manager)
			->newItem('Руль', 1300, 'Можно рулить', 'https://mdata.yandex.net/i?path=b0703143815_img_id2809605888842737427.jpg', $this->getReference('cat-steering_wheels'), $manager)
			->newItem('Джойстик', 700, 'Ил-2 Штуромовик', 'https://mdata.yandex.net/i?path=b0807013840__img_id3437573108959936863.jpg', $this->getReference('cat-joysticks'), $manager)
			->newItem('DualShock', 699, 'Один из многих', 'https://mdata.yandex.net/i?path=b0427183725__Sony_Dualshock3_b.jpg', $this->getReference('cat-gamepads'), $manager)
			->newItem('Xbox', 690, 'Тот самый', 'https://mdata.yandex.net/i?path=b1231175313_img_id6813812429270295012.jpeg', $this->getReference('cat-gamepads'), $manager)
			->newItem('Logitech G105', 4127, 'Подходит как для геймеров так и для офисных работников', 'https://mdata.yandex.net/i?path=b1118142209_img_id5759413703879531251.jpg', array($this->getReference('cat-game'), $this->getReference('cat-office')), $manager);

		$manager->flush();
	}

	public function getOrder() {
		return 4;
	}
}