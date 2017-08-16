<?php namespace EmailLog\Addon;

use EmailLog\Util\EmailHeaderParser;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * MoreFields Addon.
 *
 * @since 2.0
 */
class MoreFieldsAddon extends EmailLogAddon {

	/**
	 * Set Add-on data.
	 */
	protected function initialize() {
		$this->addon_name = 'More Fields';
		$this->addon_version = '2.0.0';
	}

	/**
	 * Setup hooks and load the add-on.
	 */
	public function load() {
		parent::load();

		add_filter( 'el_manage_log_columns', array( $this, 'add_new_columns' ) );
		add_action( 'el_display_log_columns', array( $this, 'display_new_columns' ), 10, 2 );

		add_action( 'el_load_log_list_page', array( $this, 'on_log_list_page_load' ) );
		add_filter( 'el_manage_export_row', array( $this, 'include_email_headers' ), 10, 2 );
		add_filter( 'el_manage_export_columns', array( $this, 'add_additional_columns_for_export' ) );

		add_action( 'el_view_log_after_headers', array( $this, 'add_additional_headers' ) );
	}

	/**
	 * Gets the list of additional Columns with the Column headers.
	 *
	 * @return array List of additional Columns, i.e $column_key => $column_header.
	 */
	protected function get_columns() {
		$columns = array(
			'from'       => __( 'From', 'email-log' ),
			'cc'         => __( 'CC', 'email-log' ),
			'bcc'        => __( 'BCC', 'email-log' ),
			'reply-to'   => __( 'Reply To', 'email-log' ),
			'attachment' => __( 'Attachment', 'email-log' ),
		);

		return $columns;
	}

	/**
	 * Add new columns to email log list table.
	 *
	 * @param array $columns Columns of email log list table.
	 *
	 * @return array Modified list of columns.
	 */
	public function add_new_columns( $columns ) {
		$additional_columns = $this->get_columns();
		return array_merge( $columns, $additional_columns );
	}

	/**
	 * Adds additional Column headers to in the exported CSV.
	 *
	 * @param array $columns List of Columns.
	 *
	 * @return array List of all Columns.
	 */
	public function add_additional_columns_for_export( $columns ) {
		$additional_columns = $this->get_columns();
		return array_merge( $columns, array_keys( $additional_columns ) );
	}

	/**
	 * Display content for additional columns
	 *
	 * @param string $column_name Column Name.
	 * @param object $item        Data object.
	 */
	public function display_new_columns( $column_name, $item ) {
		$parser = new EmailHeaderParser();
		$header = $parser->parse_headers( $item->headers );

		switch ( $column_name ) {
			case 'from':
				echo( isset( $header['from'] ) ? esc_attr( $header['from'] ) : 'N/A' );
				break;

			case 'cc':
				echo( isset( $header['cc'] ) ? esc_attr( $header['cc'] ) : 'N/A' );
				break;

			case 'bcc':
				echo( isset( $header['bcc'] ) ? esc_attr( $header['bcc'] ) : 'N/A' );
				break;

			case 'reply-to':
				echo( isset( $header['reply-to'] ) ? esc_attr( $header['reply-to'] ) : 'N/A' );
				break;

			case 'attachment':
				echo( ( $item->attachments == 'false' ) ? 'No' : 'Yes' );
				break;
		}
	}

	/**
	 * Attach script to log list page when it is loaded.
	 *
	 * @param string $page Page slug.
	 */
	public function on_log_list_page_load( $page ) {
		add_action( 'admin_print_scripts-' . $page, array( $this, 'add_script' ) );
	}

	/**
	 * Enqueue script.
	 */
	public function add_script() {
		wp_enqueue_script( 'email-log-more-fields', plugins_url( '/js/email-log-more-fields.js', $this->addon_file ), array( 'jquery' ), $this->addon_version, true );
	}

	/**
	 * Adds the additional column values to the exported CSV row.
	 *
	 * @param array $output_item  The exported current Log item.
	 * @param array $log_items    The list of all Log items.
	 * @return array $output_item The exported current Log item with additional values.
	 */
	public function include_email_headers( $output_item, $log_items ) {
		$parser = new EmailHeaderParser();

		$log_items_key = $this->get_log_item_by_log_id( $output_item['id'], $log_items );

		if ( $log_items_key > -1 ) {
			$header = $parser->parse_headers( $log_items[ $log_items_key ]['headers'] );

			$output_item['from']        = ( isset( $header['from'] ) ? esc_attr( $header['from'] ) : '' );
			$output_item['cc']          = ( isset( $header['cc'] ) ? esc_attr( $header['cc'] ) : '' );
			$output_item['bcc']         = ( isset( $header['bcc'] ) ? esc_attr( $header['bcc'] ) : '' );
			$output_item['reply-to']    = ( isset( $header['reply-to'] ) ? esc_attr( $header['reply-to'] ) : '' );
			$output_item['attachments'] = ( 'false' === $log_items[ $log_items_key ]['attachments'] ) ? 'No' : 'Yes';
		}

		return $output_item;
	}

	/**
	 * Gets the Log item key based on the Log ID value.
	 *
	 * @param int   $log_id    The ID in the Email Log table.
	 * @param array $log_items Array of Log items.
	 * @return int             The Log item key.
	 */
	protected function get_log_item_by_log_id( $log_id, $log_items ) {
		foreach ( $log_items as $key => $item ) {
			if ( absint( $log_id ) === absint( $item['id'] ) ) {
				return $key;
			}
		}
		return -1;
	}

	/**
	 * Add additional headers to view message in thickbox.
	 *
	 * @since 2.0.0
	 *
	 * @param array $log_item Log item that is getting displayed.
	 */
	public function add_additional_headers( $log_item ) {
		$parser  = new EmailHeaderParser();
		$headers = $parser->parse_headers( $log_item['headers'] );
		$columns = $this->get_columns();

		foreach ( $columns as $key => $column ) {
			if ( ! empty( $headers[ $key ] ) ) {
				?>
				<tr style="background: #eee;">
					<td style="padding: 5px;"><?php echo esc_html( $column ) . ':'; ?></td>
					<td style="padding: 5px;"><?php echo esc_html( $headers[ $key ] ); ?></td>
				</tr>
				<?php
			}
		}
	}
}