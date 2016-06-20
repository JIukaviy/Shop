<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 20.06.2016
 * Time: 20:42
 */

namespace AppBundle\Entity;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class DBOrderAdmin extends AbstractAdmin
{
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
			->add('user', 'entity', array(
				'label' => 'Пользователь',
				'class' => 'AppBundle\Entity\DBUser',
				'choice_label' => 'username'))
			->add('date', 'datetime', array(
				'label' => 'Дата создания'))
			->add('order_items', 'sonata_type_collection',
				array('label' => 'Товары', 'by_reference' => false),
				array(
					'edit' => 'inline'
				)
			)
			->add('status', 'entity', array(
				'label' => 'Статус',
				'class' => 'AppBundle\Entity\DBOrderStatus',
				'choice_label' => 'name'
			));
	}

	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('user.username', null, array('label' => 'Пользователь'))
			->add('date', null, array('label' => 'Пользователь'));
	}

	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->addIdentifier('user.username', null, array('label' => 'Пользователь'))
			->addIdentifier('date', null, array('label' => 'Дата создания'));
	}
}