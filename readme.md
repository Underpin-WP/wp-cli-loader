# Underpin WP CLI Loader

Loader That assists with adding WP CLI commands to a WordPress website.

## Installation

### Using Composer

`composer require underpin/cli-loader`

### Manually

This plugin uses a built-in autoloader, so as long as it is required _before_
Underpin, it should work as-expected.

`require_once(__DIR__ . '/underpin-cli/cli.php');`

## Setup

1. Install Underpin. See [Underpin Docs](https://www.github.com/underpin-wp/underpin)
1. Register new WP CLI commands as-needed.

## Basic Example

A very basic example could look something like this. This will create a single command `wp test`.

```php
\Underpin\underpin()->cli()->add( 'test', [
	'command'             => 'test',                           // Command name.
	'name'                => 'Test Command',                   // Human-readable name. Used by Underpin logging tools.
	'description'         => 'Runs a test command in the CLI', // Human-readable description. Used by Underpin logging tools.
	'action_callback'     => function ( $args ) {              // The command to run when this command is invoked in the CLI
		\WP_CLI::success( "The script has run, $args[0]!" );
	},
	'command_description' => [                                 // Optional. The description of the command. See WP CLI cookbook.
		'shortdesc' => 'Prints a test message.',
		'synopsis'  => [
			[
				'type'        => 'positional',
				'name'        => 'name',
				'description' => 'The name of the person to greet.',
				'optional'    => false,
				'repeating'   => false,
			],
		],
		'longdesc'  => '## EXAMPLES' . "\n\n" . 'Success: The script has run, Alex!',
	],
] );
```

Running the above command would look like:

```
$ wp test
Success: The script has run, !
```

```
$ wp test Alex
Success: The script has run, Alex!
```

Running help would output the help as such:

```
$ wp test --help
NAME

  wp test

DESCRIPTION

  Prints a test message.

SYNOPSIS

  wp test <name>

OPTIONS

  <name>
    The name of the person to greet.

EXAMPLES

  Success: The script has run, Alex!

GLOBAL PARAMETERS

:
```

## Sub Commands

If you want to make several commands inside a namespace, you must extend `Command` and reference the extended class
directly, like so:

Check out [WP_CLI's Commands Cookbook](https://make.wordpress.org/cli/handbook/guides/commands-cookbook/) for more
information.

```php
class Say_Hello extends Underpin_Commands\Abstracts\Command{

	protected $command = 'say';
	/**
	 * Prints a greeting.
	 *
	 * ## OPTIONS
	 *
	 * <name>
	 * : The name of the person to greet.
	 *
	 * [--type=<type>]
	 * : Whether or not to greet the person with success or error.
	 * ---
	 * default: success
	 * options:
	 *   - success
	 *   - error
	 * ---
	 *
	 * ## EXAMPLES
	 *
	 *     wp example hello Newman
	 *
	 * @when after_wp_load
	 */
	function hello( $args, $assoc_args ) {
		list( $name ) = $args;

		// Print the message with type
		$type = $assoc_args['type'];
		\WP_CLI::$type( "Hello, $name!" );
	}

}

\Underpin\underpin()->cli()->add('say','Say_Hello');
```

Running the above command would look like:

```
$ wp say hello Alex --type=error
Error: Hello, Alex!
```

```
$ wp say hello Kate
Success: Hello, Kate!
```

```
$ wp say hello
usage: wp say hello <name> [--type=<type>]
```

Running help would output help as such:

```
$ wp say hello --help
NAME

  wp say hello

DESCRIPTION

  Prints a greeting.

SYNOPSIS

  wp say hello <name> [--type=<type>]

OPTIONS

  <name>
    The name of the person to greet.

  [--type=<type>]
    Whether or not to greet the person with success or error.
    ---
    default: success
    options:
      - success
      - error
    ---

EXAMPLES

    wp example hello Newman

GLOBAL PARAMETERS

  --path=<path>
      Path to the WordPress files.

  --url=<url>
      Pretend request came from given URL. In multisite, this argument is how the target site is specified.

  --ssh=[<scheme>:][<user>@]<host|container>[:<port>][<path>]
      Perform operation against a remote server over SSH (or a container using scheme of "docker", "docker-compose", "vagrant").

  --http=<http>
      Perform operation against a remote WordPress installation over HTTP.

  --user=<id|login|email>
      Set the WordPress user.

  --skip-plugins[=<plugins>]
      Skip loading all plugins, or a comma-separated list of plugins. Note: mu-plugins are still loaded.
:

```