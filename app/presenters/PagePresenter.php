<?php

namespace App\Presenters;

use Nette;

class PagePresenter extends BasePresenter {

	/** @var Nette\Database\Context */
	private $database;

	public function __construct(Nette\Database\Context $database) {
		$this->database = $database;
	}

	public function renderDefault() {
		$pages = $this->database->table('pages')->order('created_at DESC')->limit(10);
		$this->template->pages = $pages;
	}

	public function renderShow($pageId) {
		$page = $this->database->table('pages')->get($pageId);
		if (!$page) {
			$this->error('Stránka nebyla nalezena');
		}
		$this->template->page = $page;
	}

}
