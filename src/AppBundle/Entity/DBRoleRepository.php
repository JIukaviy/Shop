<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 11.06.2016
 * Time: 17:36
 */

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;

class DBRoleRepository extends EntityRepository
{
	public function getRoleByName($name) {
		$this->getEntityManager()->createQueryBuilder()
			->select('r')
			->from('AppBundle:DBRole', 'r')
			->where('r.role = ?1')
			->setParameter(1, $name)
			->getQuery()
			->getOneOrNullResult();
	}
}