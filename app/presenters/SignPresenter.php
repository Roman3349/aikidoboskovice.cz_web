<?php

namespace App\Presenters;

use Nette;
use App\Forms\SignInFormFactory;

class SignPresenter extends BasePresenter {

	/** @var SignInFormFactory @inject */
	public $factory;

	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm() {
		$form = $this->factory->create();
		$form->onSuccess[] = function ($form) {
			$form->getPresenter()->redirect('Homepage:');
		};
		return $form;
	}

	public function actionOut() {
		$this->getUser()->logout();
	}

}
