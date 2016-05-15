<?php

namespace App\Config;

class Config {

	// Database
	const db_host = 'localhost';
	const db_user = 'root';
	const db_pass = '';
	const db_db = 'cms';
	// Captcha
	const captcha_sitekey = '';
	const captcha_secretkey = '';
	// Tracy
	const tracy_addr = '::1';
	const tracy_cookie = 'secret'; // Content of cookie tracy-debug
}
