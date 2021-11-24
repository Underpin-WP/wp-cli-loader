<?php

use Underpin\Abstracts\Underpin;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add this loader.
Underpin::attach( 'setup', new \Underpin\Factories\Observers\Loader( 'cli', [
	'abstraction_class' => 'Underpin\Commands\Abstracts\Command',
	'default_factory'   => 'Underpin\Commands\Factories\Command_Instance',
] ) );