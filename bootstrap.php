<?php

use Underpin\Abstracts\Underpin;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add this loader.
Underpin::attach( 'setup', new \Underpin\Factories\Observers\Loader( 'cli', [
	'instance' => 'Underpin\Commands\Abstracts\Command',
	'default'  => 'Underpin\Commands\Factories\Command_Instance',
] ) );