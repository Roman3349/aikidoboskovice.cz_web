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
		$page = $this->database->table('homepage')->get(1);
		if (!$page) {
			$this->error('Homepage nebyla nalezena');
		}
		$this->template->page = $page;
		$this->template->user = $this->getUser();
	}

}
