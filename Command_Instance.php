<?php
/**
 * Command Factory
 *
 * @since   1.0.0
 * @package Underpin\Abstracts
 */


namespace Underpin_Commands\Factories;


use Underpin\Traits\Instance_Setter;
use Underpin_Commands\Abstracts\Command;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Admin_Bar_Menu
 * Handles creating custom WP CLI commands
 *
 * @since   1.0.0
 * @package Underpin\Abstracts
 */
class Command_Instance extends Command {
	use Instance_Setter;

	protected $action_callback;

	/**
	 * Command_Instance constructor.
	 *
	 * @param array $args Overrides to default args in the Command object
	 */
	public function __construct( $args = [] ) {
		$this->set_values( $args );
	}

	public function __invoke( $args ) {
		return $this->set_callable( $this->action_callback, $args );
	}

}