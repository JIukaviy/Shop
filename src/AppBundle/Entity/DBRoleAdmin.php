<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 21.06.2016
 * Time: 16:31
 */

namespace AppBundle\Entity;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class DBRoleAdmin extends AbstractAdmin
{
	/**
	 * @param FormMapper $formMapper
	 */
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
			->add('name', 'text', array('label' => 'Название'))
			->add('role', 'text', array('label' => 'Роль'));
	}

	/**
	 * @param DatagridMapper $datagridMapper
	 */
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('name', null, array('label' => 'Название'))
			->add('role', null, array('label' => 'Роль'));
	}

	/**
	 * @param ListMapper $listMapper
	 */
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->addIdentifier('name', null, array('label' => 'Название'))
			->addIdentifier('role', null, array('label' => 'Роль'));
	}
}