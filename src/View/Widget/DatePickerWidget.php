<?php
	/**
	 * Created by PhpStorm.
	 * User: kyuuya58
	 * Date: 2020/06/07
	 * Time: 14:38
	 */
namespace App\View\Widget;

use Cake\View\Form\ContextInterface;
use Cake\View\Widget\WidgetInterface;

class DatePickerWidget implements WidgetInterface
{
	protected $_templates;

	public function __construct($templates)
	{
		$this->_templates = $templates;
	}

	public function render(array $data, ContextInterface $context)
	{
		$data += [
				'name' => '',
				'val' => '',
		];
		return $this->_templates->format('datepicker', [
				'name' => $data['name'],
				'val' => $data['val'],
				'templateVars' => $data['templateVars'],
				'attrs' => $this->_templates->formatAttributes($data, ['name'], ['val'])
		]);
	}

	public function secureFields(array $data)
	{
		return [ $data['name']];
	}

}