<?php
/**
 * Public class to handle frontend files
 *
 * @package WP CLI
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Public Pages Class
 *
 * Handles all the different features and functions
 * for the front end pages.
 *
 * @package WP CLI
 * @since 1.0.0
 */
class Wpcli_Public {

	/**
	 * Hnadle the wp cli hook function
	 */
	public function wp_cli_register_commands() {
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			WP_CLI::add_command( 'sample', array( $this, 'wp_cli_sample_command' ) );
			WP_CLI::add_command( 'display_arguments', array( $this, 'wp_cli_display_arguments' ) );
			WP_CLI::add_command( 'display_messages', array( $this, 'wp_cli_display_messages' ) );
			WP_CLI::add_command( 'generate_post_progress_bar', array( $this, 'wp_cli_generate_posts_progress_bar' ) );
			WP_CLI::add_command( 'generate_posts', array( $this, 'wp_cli_generate_posts' ) );
		}
	}

	/**
	 *  Function to handle the sample command action.
	 */
	public function wp_cli_sample_command() {
		/**
		 * Run command wp sample.
		 */
		WP_CLI::line( 'Thank you for running the sample command.' );
	}

	/**
	 *  Function to handle the display_arguments command action.
	 *
	 * @param array $args wpcli arguments.
	 * @param array $assoc_args wpcli associate arguments.
	 * @since 1.0.0
	 */
	public function wp_cli_display_arguments( $args, $assoc_args ) {

		/** Run command wp display_arguments.
		 *  Run command wp display_arguments John Doe 'Jane Doe' 32 --title='Moby Dick' --author='Herman Melville' --published=1851 --publish --no-archive.
		*/

		// Examples of Arguments.
		isset( $args[0] ) ? WP_CLI::line( $args[0] ) : WP_CLI::line( 'John' );
		isset( $args[1] ) ? WP_CLI::line( $args[1] ) : WP_CLI::line( 'Doe' );
		isset( $args[2] ) ? WP_CLI::line( $args[2] ) : WP_CLI::line( 'Jane Doe' );
		isset( $args[3] ) ? WP_CLI::line( $args[3] ) : WP_CLI::line( '32' );

		// Example of Associated Arguments.
		isset( $assoc_args['title'] ) ? WP_CLI::line( $assoc_args['title'] ) : WP_CLI::line( 'Moby Dick' );
		isset( $assoc_args['author'] ) ? WP_CLI::line( $assoc_args['author'] ) : WP_CLI::line( 'Herman Melville' );
		isset( $assoc_args['published'] ) ? WP_CLI::line( $assoc_args['published'] ) : WP_CLI::line( '1851' );

		// Example of Associated Arguments as flag.
		isset( $assoc_args['publish'] ) ? WP_CLI::line( $assoc_args['publish'] ) : WP_CLI::line( true );
		isset( $assoc_args['archive'] ) ? WP_CLI::line( $assoc_args['archive'] ) : WP_CLI::line( false );

	}

	/**
	 *  Function to handle the display_messages command action.
	 *
	 * @param array $args wpcli arguments.
	 * @param array $assoc_args wpcli associate arguments.
	 */
	public function wp_cli_display_messages( $args, $assoc_args ) {

		// Run command wp display_messages.
		// Run command wp display_messages --debug.
		// Run command wp display_messages --error.

		// No prepends.
		WP_CLI::line( 'Standard line return.' ); // No prefix on line return.
		WP_CLI::log( 'Standard line returned that wont be silenced.' ); // No prefix on line but ignores --quiet.

		// Color make sure to use %n at the end of a style or else the style will apply to the next output.
		WP_CLI::line( WP_CLI::colorize( '%BBlue text%n' ) ); // Returns text in blue color. Ignores --quiet.
		WP_CLI::line( WP_CLI::colorize( '%MMagenta text%n' ) ); // Returns text in magenta. Ignores --quiet.
		WP_CLI::line( WP_CLI::colorize( '%UUnderline text%n' ) ); // Returns text underlined. Ignores --quiet.

		// Only prepends.
		WP_CLI::success( 'Post updated!' ); // Prepends Success to message.
		WP_CLI::warning( 'No match was found.' ); // Prepends Warning to message.

		// Special conditions.
		WP_CLI::debug( 'Breakpoint comment.' ); // Displays only when --debug flag is used.

		WP_CLI::error_multi_line( array( 'Error found!', 'Post not updated!', 'User not updated!' ) ); // Displays multi-line error in red box. Doesn't exit script. Ignores --quiet but looses formating.

		// Returns error message if --error custom flag is added.
		if ( isset( $assoc_args['error'] ) && $assoc_args['error'] ) {
			WP_CLI::error( 'Error found!' ); // Prepends message with Error and exits script.
		}

		WP_CLI::halt( 200 ); // Halts script execution with a specific return code. Could for calling your subcommand from another.

	}

	/**
	 * Displays progress bar to demonstrate progression through a time consuming process.
	 *
	 * @param array $args Arguments in array format.
	 * @param array $assoc_args Key value arguments stored in associated array format.
	 * @since 1.0.0
	 */
	public function wp_cli_generate_posts_progress_bar( $args, $assoc_args ) {

		// Run command wp generate_post_progress_bar 5.

		$desired_posts_to_generate = (int) $args[0];

		$progress = \WP_CLI\Utils\make_progress_bar( 'Generating Posts', $desired_posts_to_generate );

		for ( $i = 0; $i < $desired_posts_to_generate; $i++ ) {
			// Code used to generate a post.
			WP_CLI::line( $i );
			$progress->tick();
		}

		$progress->finish();

	}

	/**
	 * Generate posts with meta values.
	 *
	 * @param array $args Arguments in array format.
	 * @param array $assoc_args Key value arguments stored in associated array format.
	 * @since 1.0.0
	 */
	public function wp_cli_generate_posts( $args, $assoc_args ) {

		// Run command wp generate_posts 5 Test 1.

		// Get Post Details.
		$desired_posts_to_generate = (int) $args[0]; // First argument is how many posts should be generated.
		$title_prepend             = $args[1]; // Second argument should be the title of posts generated. This will be used with index in loop to generate a title.
		$author_id                 = (int) $args[2]; // Id of author who to assign generated post to.

		$progress = \WP_CLI\Utils\make_progress_bar( 'Generating Posts', $desired_posts_to_generate );

		for ( $i = 0; $i < $desired_posts_to_generate; $i++ ) {

			// Code used to generate a post.
			$my_post = array(
				'post_title'  => $title_prepend . ' ' . ( $i + 1 ),
				'post_status' => 'publish',
				'post_author' => $author_id,
				'post_type'   => 'post',
				'tags_input'  => array( 'generated' ),
				'meta_input'  => $assoc_args, // Simply passes all key value pairs to posts generated that can be used in testing.
			);

			// Insert the post into the database.
			wp_insert_post( $my_post );

			$progress->tick();
		}

		$progress->finish();
		WP_CLI::success( $desired_posts_to_generate . ' posts generated!' ); // Prepends Success to message.
	}

	/**
	 * Adding Hooks
	 *
	 * Adding proper hooks for the public pages.
	 *
	 * @package WP CLI
	 * @since 1.0.0
	 */
	public function add_hooks() {
		// Hook to handle cli request.
		add_action( 'cli_init', array( $this, 'wp_cli_register_commands' ) );
	}
}
