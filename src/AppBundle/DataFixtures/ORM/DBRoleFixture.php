<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 21.06.2016
 * Time: 0:33
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\DBRole;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DBRoleFixture extends AbstractFixture implements OrderedFixtureInterface
{
	/**
	 * @param string $name
	 * @param string $role_name
	 * @param ObjectManager $manager
	 * @return DBRoleFixture
	 */
	private function newRole($role_name, $name, $manager) {
		$role= new DBRole();
		$role
			->setRole('ROLE_' . strtoupper($role_name))
			->setName($name);
		$manager->persist($role);
		$this->addReference('role-' . strtolower($role_name), $role);
		return $this;
	}

	public function load(ObjectManager $manager) {
		$this
			->newRole('admin', 'Администратор', $manager)
			->newRole('user', 'Пользователь', $manager);

		$manager->flush();
	}

	public function getOrder() {
		return 1;
	}
}