<?php

namespace App\Forms;

use Nette\Object;
use Nette\Application\UI\Form;
use Nette\Security\User;
use Nette\Security\AuthenticationException;

class SignInFormFactory extends Object {

	/** @var FormFactory */
	private $factory;

	/** @var User */
	private $user;

	public function __construct(FormFactory $factory, User $user) {
		$this->factory = $factory;
		$this->user = $user;
	}

	/**
	 * @return Form
	 */
	public function create() {
		$form = $this->factory->create();
		$form->addText('username', 'Jméno:')
				->setRequired('Prosím zadejte své uživatelské jméno.');
		$form->addPassword('password', 'Heslo:')
				->setRequired('Prosím zadejte své heslo.');
		$form->addCheckbox('remember', 'Pamatovat si mě.');
		$form->addSubmit('send', 'Přihlásit se');
		$form->onSuccess[] = array($this, 'formSucceeded');
		return $form;
	}

	public function formSucceeded(Form $form, $values) {
		if ($values->remember) {
			$this->user->setExpiration('14 days', FALSE);
		} else {
			$this->user->setExpiration('20 minutes', TRUE);
		}

		try {
			$this->user->login($values->username, $values->password);
		} catch (AuthenticationException $e) {
			$form->addError('Uživatelské jméno nebo heslo není správné.');
		}
	}

}
