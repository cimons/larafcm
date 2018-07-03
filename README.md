# Laravel-FCM

## Introduction

Laravel-FCM is an easy to use package working with both Laravel and Lumen for sending push notification with [Firebase Cloud Messaging](https://firebase.google.com/docs/cloud-messaging/) (FCM).

It currently **only supports HTTP protocol** for :

- sending a downstream message to one device

> Note: The XMPP protocol is not currently supported.


## Installation

To get the latest version of Laravel-FCM on your project, require it from "composer":


	$ composer require cimons/larafcm


Or you can add it directly in your composer.json file:


	{
    	"require": {
        	   "cimons/larafcm": "dev-master"
    	}
	}


### Laravel

Register the provider directly in your app configuration file config/app.php `config/app.php`:

```php
'providers' => [
	// ...

	Cimons\LaraFcm\LaraFcmServiceProvider::class,
]
```

Add the facade aliases in the same file:

```php
'aliases' => [
	...
	'FCM'             => Cimons\LaraFcm\Facades\FCM::class,
]
```



Copy the config file ```fcm.php``` manually from the directory ```/vendor/cimons/larafcm/config``` to the directory ```/config ``` (you may need to create this directory).


### Package Configuration

In your `.env` file, add the server key and the secret key for the Firebase Cloud Messaging:

```php
FCM_SERVER_KEY=my_secret_server_key
FCM_SENDER_ID=my_secret_sender_id
```

### Downstream Messages

A downstream message is a notification message, a data message, or both, that you send to a target device or to multiple target devices using its registration_Ids.

The following use statements are required for the examples below:

```php
use Cimons\LaraFcm\Message\NotificationBuilder;
use Cimons\LaraFcm\Facades\FCM;
```

#### Sending a Downstream Message to a Device

```php

$notificationBuilder = NotificationBuilder('my title');
$notificationBuilder->setBody('Hello world')
				    ->setSound('default');
$notification = $notificationBuilder->build();

$token = "a_registration_from_your_database";
$downstreamResponse = FCM::sendTo($token, $notification);

if ($downstreamResponse->isSent == 1) {
     echo "The message has been sent.";
} else {
    echo "The message could not be sent."
}
````
#### Licence

This library is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

Some of this documentation is coming from the official documentation. You can find it completely on the [Firebase Cloud Messaging](https://firebase.google.com/docs/cloud-messaging/) Website.
