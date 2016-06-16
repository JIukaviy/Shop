<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 29.05.2016
 * Time: 14:40
 */

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class DBUserRepository extends EntityRepository
{
	public function getAllUsers() {
		return $this->getEntityManager()->createQueryBuilder()
			->select('u')
			->from('AppBundle:DBUser', 'u')
			->orderBy('u.username')
			->getResult();
	}
}