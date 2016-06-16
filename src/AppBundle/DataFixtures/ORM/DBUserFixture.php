<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 21.06.2016
 * Time: 0:20
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\DBUser;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DBUserFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
	/**
	 * @var ContainerInterface
	 */
	private $container;

	public function setContainer(ContainerInterface $container = null) {
		$this->container = $container;
	}

	public function load(ObjectManager $manager) {
		$userAdmin = new DBUser();

		$userAdmin
			->setUsername('JIukaviy')
			->setEmail('jiukaviy@gmail.com')
			->setPassword($this->container->get('security.password_encoder')->encodePassword($userAdmin, 'admin'))
			->addRole($this->getReference('role-admin'))
			->addRole($this->getReference('role-user'));

		$manager->persist($userAdmin);
		$manager->flush();

		$this->addReference('user-admin', $userAdmin);
	}

	public function getOrder() {
		return 2;
	}
}