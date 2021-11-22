<?php

use Underpin\Abstracts\Underpin;
use function Underpin\underpin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add this loader.
Underpin::attach( 'setup', new \Underpin\Factories\Observer( 'cli_command', [
	'update' => function ( Underpin $plugin ) {
		// Only register these items if debug mode is enabled, or if WP CLI is running.
		if ( ( defined( 'WP_CLI' ) && WP_CLI ) || Underpin::is_debug_mode_enabled() ) {
			require_once( plugin_dir_path( __FILE__ ) . 'Command.php' );
			require_once( plugin_dir_path( __FILE__ ) . 'Command_Instance.php' );
			$plugin->loaders()->add( 'cli', [
				'instance' => 'Underpin_Commands\Abstracts\Command',
				'default'  => 'Underpin_Commands\Factories\Command_Instance',
			] );
		}
	},
] ) );