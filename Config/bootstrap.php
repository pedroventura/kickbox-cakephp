<?php

// include de autoload from composer
App::import('Vendor', 'KickboxEmail.Kickbox', array('file' => 'autoload.php'));

// By default debugging is enabled and data is saved in a log file
Configure::write('KickboxEmail.log', true);

// CakeLog config
CakeLog::config('kickbox', array(
	'engine' => 'FileLog',
	'types' => array('info'),
	'scopes' => array('kickbox'),
	'file' => 'kickbox.log',
));

