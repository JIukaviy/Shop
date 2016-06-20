<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 20.06.2016
 * Time: 19:25
 */

namespace AppBundle\Entity;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class DBItemAdmin extends AbstractAdmin
{
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
			->add('name', 'text', array('label' => 'Название'))
			->add('price', 'number', array('label' => 'Цена'))
			->add('description', 'textarea', array('label' => 'Описание'))
			->add('preview', 'text', array('label' => 'Ссылка на фотографию'))
			->add('categories', 'entity', array(
				'class' => 'AppBundle\Entity\DBCategory',
				'choice_label' => 'name',
				'multiple' => true,
				'label' => 'Категории'
			));
	}

	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('name')
			->add('price');
	}

	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->addIdentifier('name')
			->addIdentifier('price');
	}
}