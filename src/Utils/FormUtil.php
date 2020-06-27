<?php
/**
 * Created by PhpStorm.
 * User: SOLA2
 * Date: 2019/09/29
 * Time: 17:24
 */

namespace App\Utils;

use App\Controller\AppController;

class FormUtil {

	/**
	 * Ajaxを返すときにヘッダーに必要な情報を追加する処理
	 * @param AppController $appController
	 * @return array
	 */
	static public function getFormTemplate() {
		return array('error' => '<div class="col-sm-12 error-message alert alert-danger mt-2 mb-0 py-1">{{content}}</div>',
			'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
			'confirmJs' => '{{confirm}}',
			'formGroup' => '<label for="username">{{label}}</label><div class="input-group mb-3">{{span_icon}}{{input}}</div>',
			'dateWidget' => '<input type="Date" name="{{name}}" value="{{value}}" {{attrs}}>',
			'select' => '<select name="{{name}}"{{attrs}} data-toggle="{{select_toggle}}">{{content}}</select>',
			'inputContainer' => '<div class="input {{type}}{{required}} {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}</div>',
			'inputContainerError' => '<div class="input {{type}}{{required}} error {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}{{error}}</div>',);
	}
}
