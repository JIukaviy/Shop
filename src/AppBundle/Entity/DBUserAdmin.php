<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 21.06.2016
 * Time: 16:24
 */

namespace AppBundle\Entity;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class DBUserAdmin extends AbstractAdmin
{
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
			->add('username', 'text', array('label' => 'Имя пользователя'))
			->add('email', 'text')
			->add('roles', 'entity', array(
				'label' => 'Роли',
				'class' => 'AppBundle\Entity\DBRole',
				'choice_label' => 'name',
				'multiple' => true
			));
	}

	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('username', null, array('label' => 'Имя пользователя'))
			->add('email');
	}

	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->addIdentifier('username', null, array('label' => 'Имя пользователя'))
			->addIdentifier('email');
	}

	public function toString($object)
	{
		return $object instanceof DBUser
			? $object->getUsername()
			: 'Пользователь'
			;
	}
}