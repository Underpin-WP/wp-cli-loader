<?php

use Underpin\Abstracts\Underpin;
use function Underpin\underpin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add this loader.
add_action( 'underpin/before_setup', function ( $file, $class ) {

	// Only register these items if debug mode is enabled, or if WP CLI is running.
	if ( ( defined( 'WP_CLI' ) && WP_CLI ) || Underpin::is_debug_mode_enabled() ) {
		require_once( plugin_dir_path( __FILE__ ) . 'Command.php' );
		require_once( plugin_dir_path( __FILE__ ) . 'Command_Instance.php' );
		underpin()->get( $file, $class )->loaders()->add( 'cli', [
			'instance' => 'Underpin_Commands\Abstracts\Command',
			'default'  => 'Underpin_Commands\Factories\Command_Instance',
		] );
	}
}, 4, 2 );