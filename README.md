# Kickbox CakePHP #

CakePHP Plugin for Email Verification by using Kickbox Service. http://kickbox.io/

## Getting Started

You can add the plugin as submodule in your project, via git submodule:

```sh
$ git submodule add git@github.com:elpeter/kickbox-cakephp.git app/Plugin/KickboxEmail
```

Otherwise, you can use git clone or download it. Place it in the Plugin folder.

### Resolve the dependencies

To get the Kickbox Library and the rest of the dependencies you will need to run composer.

```sh
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install
```

## Setup in CakePHP

To setup the plugin in your project follow the next steps.

### Get the API KEY

Register at https://kickbox.io. > Go to API Settings > Create new API KEY.

### Add the plugin to Bootstrap

Add the followind lines to your app/Config/bootstrap.php

```php
CakePlugin::load('KickboxEmail', array('bootstrap' => true));
define('KICKBOXAPIKEY', 'KICKBOX API KEY GOES HERE');
```

Set the constant *KICKBOXAPIKEY* with your API KEY from kickbox.io.

### Add the Component

Add the main component of the Plugin in your application.

You can add it for the whole project in app/Controller/AppController.php or the Controller you need it.

```php
public $components = array(
		'KickboxEmail.Validator'
	);
```

## How to validate an email

Use the validate method as follows:

```php	
$res = $this->Validator->verify('EMAIL GOES HERE');
```

*$res* will return *true* or *false*. So, if the email passed the validation or not.

There is a log file in app/tmp/logs/kickbox.log where you can check all the validation request and returned data.
By default is enabled. You can disable it by adding the following line in the app/Config/bootstrap.php

```php	
Configure::write('KickboxEmail.log', false);
```
