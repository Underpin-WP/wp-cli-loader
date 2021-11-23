<?php
/**
 * Command Abstraction
 *
 *  Implements a WP CLI Command. See https://make.wordpress.org/cli/handbook/guides/commands-cookbook/
 *
 * @since   1.0.0
 * @package Underpin\Abstracts
 */

namespace Underpin\Commands\Abstracts;

use Underpin\Traits\Feature_Extension;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Command
 *
 * @since   1.0.0
 * @package Underpin\Abstracts
 */
abstract class Command {

	use Feature_Extension;

	protected $command_description;

	protected $command;

	public function do_actions() {

		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			if ( ! empty( $this->command_description ) ) {
				/** @noinspection PhpUndefinedClassInspection */
				\WP_CLI::add_command( $this->command, $this, $this->command_description );

			} else {
				/** @noinspection PhpUndefinedClassInspection */
				\WP_CLI::add_command( $this->command, $this );
			}
		}
	}

	public function __get( $key ) {
		if ( isset( $this->$key ) ) {
			return $this->$key;
		} else {
			return new WP_Error( 'param_not_set', 'The key ' . $key . ' could not be found.' );
		}
	}

}