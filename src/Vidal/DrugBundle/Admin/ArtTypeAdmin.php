<?php

namespace Vidal\DrugBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ArtTypeAdmin extends Admin
{
	protected $datagridValues;

	public function __construct($code, $class, $baseControllerName)
	{
		parent::__construct($code, $class, $baseControllerName);

		if (!$this->hasRequest()) {
			$this->datagridValues = array(
				'_page'       => 1,
				'_per_page'   => 25,
				'_sort_order' => 'ASC',
				'_sort_by'    => 'rubrique'
			);
		}
	}

	protected function configureShowField(ShowMapper $showMapper)
	{
		$showMapper
			->add('id')
			->add('title', null, array('label' => 'Заголовок'))
			->add('url', null, array('label' => 'Адрес страницы', 'help' => 'латинские буквы и цифры, слова через тире'))
			->add('rubrique', null, array('label' => 'Раздел'))
			->add('priority', null, array('label' => 'Приоритет'))
			->add('enabled', null, array('label' => 'Активна'));
	}

	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
			->add('title', null, array('label' => 'Заголовок', 'required' => true))
			->add('url', null, array('label' => 'Адрес страницы', 'required' => true, 'help' => 'латинские буквы и цифры, слова через тире'))
			->add('rubrique', null, array('label' => 'Раздел', 'required' => true))
			->add('announce', null, array('label' => 'Анонс', 'required' => false, 'attr' => array('class' => 'ckeditorfull')))
			->add('priority', null, array('label' => 'Приоритет', 'required' => false))
			->add('enabled', null, array('label' => 'Активна', 'required' => false));
	}

	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('id')
			->add('title', null, array('label' => 'Заголовок'))
			->add('url', null, array('label' => 'Адрес страницы'))
			->add('rubrique', null, array('label' => 'Раздел'))
			->add('priority', null, array('label' => 'Приоритет'))
			->add('enabled', null, array('label' => 'Активна'));
	}

	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->add('id')
			->add('title', null, array('label' => 'Заголовок'))
			->add('url', null, array('label' => 'Адрес страницы'))
			->add('rubrique', null, array('label' => 'Раздел'))
			->add('priority', null, array('label' => 'Приоритет'))
			->add('enabled', null, array('label' => 'Активна', 'template' => 'VidalDrugBundle:Sonata:swap_enabled.html.twig'))
			->add('_action', 'actions', array(
				'label'   => 'Действия',
				'actions' => array(
					'show'   => array(),
					'edit'   => array(),
					'delete' => array(),
				)
			));
	}
}