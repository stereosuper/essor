<?php
/**
 * Email Log Addon Activation handler.
 * Based on the code from https://github.com/easydigitaldownloads/EDD-Extension-Boilerplate
 * Namespace is not used since this class might be used in PHP 5.2
 *
 * @package  EmailLog\Addon
 * @version  1.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * Email Log Add-on Activation Handler Class.
 *
 * @since 1.0.0
 */
class EmailLogAddonActivator {

	/**
	 * Plugin name.
	 *
	 * @var string
	 */
	private $addon_name;

	/**
	 * Plugin path.
	 *
	 * @var string
	 */
	private	$addon_directory;

	/**
	 * Plugin file.
	 *
	 * @var string
	 */
	private $addon_file;

	/**
	 * Is Email Log plugin installed?
	 *
	 * @var bool
	 */
	private	$has_el;

	/**
	 * Email Log plugin base path.
	 *
	 * @var string
	 */
	private	$el_base;

	/**
	 * Minimum version of Email Log that is needed.
	 *
	 * @var string
	 */
	private $required_el_version;

	/**
	 * Minimum version of PHP that is needed.
	 *
	 * @var string
	 */
	private $required_php_version;

	/**
	 * Setup the activation class.
	 *
	 * @param string $addon_file_path      Add-on main file.
	 * @param string $required_el_version  The minimum version of Email Log that is required. Default 2.0.0.
	 * @param string $required_php_version The minimum version of PHP that is required. Default is 5.3.0.
	 */
	public function __construct( $addon_file_path, $required_el_version = '2.0.0', $required_php_version = '5.3.0' ) {
		$this->required_el_version  = $required_el_version;
		$this->required_php_version = $required_php_version;

		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$plugins = get_plugins();

		// Set addon directory.
		$directories = array_filter( explode( '/', plugin_dir_path( $addon_file_path ) ) );
		$this->addon_directory = end( $directories );

		// Set addon file.
		$this->addon_file = basename( $addon_file_path );

		// Set plugin name.
		if ( isset( $plugins[ $this->addon_directory . '/' . $this->addon_file ]['Name'] ) ) {
			$this->addon_name = str_replace( 'Email Log - ', '', $plugins[ $this->addon_directory . '/' . $this->addon_file ]['Name'] );
		} else {
			$this->addon_name = __( 'This plugin', 'email-log' );
		}

		// Is Email Log installed?
		foreach ( $plugins as $plugin_path => $plugin ) {
			if ( 'Email Log' === $plugin['Name'] ) {
				$this->has_el  = true;
				$this->el_base = $plugin_path;
				break;
			}
		}
	}

	/**
	 * Check if the required version of Email Log plugin is installed.
	 * If not, show a notice.
	 *
	 * @return bool True, if requirement are met, False otherwise.
	 */
	public function requirement_met() {
		if ( version_compare( PHP_VERSION, $this->required_php_version, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'update_php_notice' ) );

			return false;
		}

		if ( ! function_exists( 'load_email_log_addon' ) ) {
			add_action( 'admin_notices', array( $this, 'missing_plugin_notice' ) );

			return false;
		} else {
			$email_log = email_log();

			if ( ! version_compare( $email_log->get_version(), $this->required_el_version, '>=' ) ) {
				add_action( 'admin_notices', array( $this, 'upgrade_plugin_notice' ) );

				return false;
			}
		}

		return true;
	}

	/**
	 * Display update PHP notice.
	 */
	public function update_php_notice() {
		printf( '<div class="error"><p>%s %s</p></div>',
			esc_html( $this->addon_name ),
			sprintf(
				esc_html__( 'requires at least PHP %1$s or above! You are currently using PHP %2$s, which is very old. Please contact your web host and upgrade PHP.', 'email-log' ),
				esc_html( $this->required_php_version ),
				PHP_VERSION //@codingStandardsIgnoreLine No need to escape constant.
			)
		);
	}

	/**
	 * Display notice if Email Log isn't installed or activated.
	 */
	public function missing_plugin_notice() {
		if ( $this->has_el ) {
			$url  = esc_url( wp_nonce_url( admin_url( 'plugins.php?action=activate&plugin=' . $this->el_base ), 'activate-plugin_' . $this->el_base ) );
			$link = '<a href="' . $url . '">' . __( 'activate it', 'email-log' ) . '</a>';
		} else {
			$url  = esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=email-log' ), 'install-plugin_email-log' ) );
			$link = '<a href="' . $url . '">' . __( 'install it', 'email-log' ) . '</a>';
		}

		printf( '<div class="error"><p>%s %s</p></div>',
			esc_html( $this->addon_name ),
			sprintf( __( 'requires Email Log! Please %s to continue!', 'email-log' ), $link ) //@codingStandardsIgnoreLine Link is constructed just above.
		);
	}

	/**
	 * Display notice if Email Log needs to be updated.
	 */
	public function upgrade_plugin_notice() {
		$url  = esc_url( wp_nonce_url( admin_url( 'plugins.php?action=upgrade-plugin&plugin=' . $this->el_base ), 'upgrade-plugin_' . $this->el_base ) );
		$link = '<a href="' . $url . '">' . __( 'update it', 'email-log' ) . '</a>';

		printf( '<div class="error"><p>%s %s</p></div>',
			esc_html( $this->addon_name ),
			sprintf( __( 'requires Email Log version %s or above! Please %s to continue!', 'email-log' ), $this->required_el_version, $link ) //@codingStandardsIgnoreLine Link is constructed just above.
		);
	}
}
