<?php

namespace App\Presenters;

use Nette;
use App\Forms;

class SignPresenter extends BasePresenter {

	/** @var Forms\SignInFormFactory @inject */
	public $signInfactory;

	/** @var Forms\SignUpFormFactory @inject */
	public $signUpfactory;

	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm() {
		return $this->signInfactory->create(function () {
					$this->flashMessage('Byl jste úspěšně přihlášen.', 'success');
					$this->redirect('Homepage:');
				});
	}

	/**
	 * Sign-up form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignUpForm() {
		return $this->signUpfactory->create(function () {
			$this->flashMessage('Byl jste úspěšně zaregistrován.', 'success');
					$this->redirect('Homepage:');
				});
	}

	public function actionOut() {
		$this->getUser()->logout();
	}

}
