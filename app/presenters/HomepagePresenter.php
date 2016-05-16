<?php

namespace App\Presenters;

use Nette;

class HomepagePresenter extends BasePresenter {

	/** @var Nette\Database\Context */
	private $database;
	
	public function __construct(Nette\Database\Context $database) {
		$this->database = $database;
	}
	
	public function renderDefault() {
		
	}

}
