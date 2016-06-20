<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 20.06.2016
 * Time: 19:13
 */

namespace AppBundle\Entity;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class DBCategoryAdmin extends AbstractAdmin
{
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper->add('name', 'text', array('label' => 'Название'));
		$formMapper->add('url_name', 'text', array('label' => 'Url имя'));
		$formMapper->add('path', 'text', array('label' => 'Путь родителькой категории'));
	}

	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper->add('name');
		$datagridMapper->add('url_name');
		$datagridMapper->add('path');
	}

	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper->addIdentifier('name');
		$listMapper->addIdentifier('url_name');
	}
}