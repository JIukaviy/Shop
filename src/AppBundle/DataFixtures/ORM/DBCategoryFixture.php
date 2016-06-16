<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 21.06.2016
 * Time: 0:42
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\DBCategory;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DBCategoryFixture extends AbstractFixture implements OrderedFixtureInterface
{
	/**
	 * @param string $name
	 * @param string $url_name
	 * @param string $path
	 * @param ObjectManager $manager
	 * @return DBCategoryFixture
	 */
	private function newCat($name, $url_name, $path, $manager) {
		$cat = new DBCategory();
		$cat
			->setName($name)
			->setUrlName($url_name)
			->setPath($path);

		$manager->persist($cat);

		$this->addReference('cat-' . $url_name, $cat);
		return $this;
	}

	public function load(ObjectManager $manager) {
		$this
			->newCat('Компьютеры', 'computers', '/', $manager)

			->newCat('Настольные компьютеры', 'desktop', '/computers/', $manager)

			->newCat('Ноутбуки', 'notebooks', '/computers/', $manager)
			->newCat('Ультрабуки', 'ultrabooks', '/computers/notebooks/', $manager)
			->newCat('Минибуки', 'minibooks', '/computers/notebooks/', $manager)
			->newCat('Микробуки', 'microbooks', '/computers/notebooks/', $manager)
			->newCat('Нанобуки', 'nanobooks', '/computers/notebooks/', $manager)
			->newCat('Бамбуки', 'bambooks', '/computers/notebooks/', $manager)

			->newCat('Комплектующие', 'accessories', '/', $manager)
			->newCat('Процессоры', 'processors', '/accessories/', $manager)
			->newCat('Материнские платы', 'motherboards', '/accessories/', $manager)

			->newCat('Периферия', 'periphery', '/', $manager)
			->newCat('Игровая', 'game', '/periphery/', $manager)
			->newCat('Рули', 'steering_wheels', '/periphery/game/', $manager)
			->newCat('Джойстики', 'joysticks', '/periphery/game/', $manager)
			->newCat('Геймпады', 'gamepads', '/periphery/game/', $manager)
			->newCat('Офисная', 'office', '/periphery/', $manager);

		$manager->flush();
	}

	public function getOrder() {
		return 3;
	}
}