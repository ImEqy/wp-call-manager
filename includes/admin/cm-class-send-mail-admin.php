<?php
/**
 * BLA.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

/**
 * BLA.
 */
class Cm_Mail_Sender {

	/**
	 * BLA.
	 *
	 * @method __construct
	 */
	public function __construct() {
		add_action( 'admin_footer', array( $this, 'prepare_send_mail' ), 107 );
	}

	/**
	 * Envoie un mail par jour.
	 *
	 * @method prepare_send_mail
	 */
	public function prepare_send_mail() {
		if ( ! wp_next_scheduled( 'cm_mail' ) ) {
			wp_schedule_event( time(), 'hourly', 'cm_mail' );
		}
		$user_data = get_userdata( get_current_user_id() );
		if ( 'administrator' === implode( ', ', $user_data->roles ) ) {
			add_action( 'cm_mail', array( $this, 'send_mail' ), 108 );
		}
	}

	/**
	 * La fonction qui envoie le mail.
	 *
	 * @method send_mail
	 */
	public function send_mail() {
		$comment = array(
			'meta_key' => '_eocm_receiver_id',
			'meta_value' => get_current_user_id(),
			'status' => array( 'recall', 'will_recall' ),
			'order' => 'ASC',
		);
		$data_comment = get_comments( $comment );
		$data_recall_comment_count = 0;
		$data_will_recall_comment_count = 0;
		$array_recall_comment['0'] = array( 'status' => 'recall' );
		$array_will_recall_comment['0'] = array( 'status' => 'will_recall' );
		foreach ( $data_comment as $data ) {
			$temp_data_comment = array(
				'status' => $data->comment_approved,
				'date_comment' => get_comment_date( '', $data->comment_ID ),
				'name_caller' => get_comment_meta( $data->comment_ID, '_eocm_caller_name', true ),
				'society_caller' => get_comment_meta( $data->comment_ID, '_eocm_caller_society', true ),
				'phone_caller' => get_comment_meta( $data->comment_ID, '_eocm_caller_phone', true ),
				'mail_caller' => get_comment_meta( $data->comment_ID, '_eocm_caller_email', true ),
				'comment_content_receive' => $data->comment_content,
			);
			if ( 'recall' === $temp_data_comment['status'] ) {
				$data_recall_comment_count++;
				$array_recall_comment[ $data_recall_comment_count ] = $temp_data_comment;
			}
			if ( 'will_recall' === $temp_data_comment['status'] ) {
				$data_will_recall_comment_count++;
				$array_will_recall_comment[ $data_will_recall_comment_count ] = $temp_data_comment;
			}
		}
		if ( ( $data_recall_comment_count > 0 ) or ( $data_will_recall_comment_count > 0 ) ) {
			ob_start();
			?>
			<table border="1" cellpadding="5" style="text-align: center; table-layout: fixed; margin: 0 auto;">
			<?php
			if ( $data_recall_comment_count > 0 ) {
				$cm_array = $array_recall_comment;
				include( plugin_dir_path( __FILE__ ) . 'views/task-manager/summary-call-recap-child.php' );
			}
			if ( $data_will_recall_comment_count > 0 ) {
				$cm_array = $array_will_recall_comment;
				include( plugin_dir_path( __FILE__ ) . 'views/task-manager/summary-call-recap-child.php' );
			}
			?>
			</table>
			<?php
			$contents = ob_get_clean();
			$cm_get_email = get_userdata( get_current_user_id() );
			$to = $cm_get_email->user_email;
			$sujet = 'Vous devez rappeler des clients !';
			$message = $contents;
			$header = array( 'Content-Type: text/html; charset=UTF-8' );
			wp_mail( $to, $sujet, $message, $header );
		}
	}
}

new Cm_Mail_Sender();
