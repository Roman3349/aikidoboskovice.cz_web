<?php

namespace App\Forms;

use Nette\Object;
use Nette\Application\UI\Form;
use Nette\Security\User;
use Nette\Security\AuthenticationException;

class SignInFormFactory extends Object {

	const
			PASSWORD_MIN_LENGTH = 7,
			PASSWORD_MAX_LENGTH = 60;

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
		$form->addText('email', 'Email')
				->setRequired('Prosím zadejte svůj email.')
				->addRule($form::EMAIL);
		$form->addPassword('password', 'Heslo:')
				->setRequired('Prosím zadejte své heslo.')
				->addRule($form::MIN_LENGTH, 'Heslo musí mít více než ' . self::PASSWORD_MIN_LENGTH . ' znaků.', self::PASSWORD_MIN_LENGTH)
				->addRule($form::MAX_LENGTH, 'Heslo musí mít méně než ' . self::PASSWORD_MAX_LENGTH . ' znaků.', self::PASSWORD_MAX_LENGTH);
		$form->addSubmit('send', 'Zaregistrovat se');
		$form->onSuccess[] = array($this, 'formSucceeded');
		return $form;
	}

	public function formSucceeded(Form $form, $values) {
		try {
			$this->user->add($values->username, $values->email, $values->password);
		} catch (AuthenticationException $e) {
			$form->addError('Toto uživatelské jméno již používá jivý uživatel.');
		}
	}

}
