<?php
/**
 * [FR]  Page ajoutant la div contenant le dialog du call-recap dans chronologie de task-maanger.
 * [ENG] This Php file contain a div for the call-recap's pop-up from Chronology in task-maanger.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

?>
<div id="cm-summary-call-recap-<?php echo esc_attr( $user_id . $year . $month . $day ); ?>" class="hidden pop-up"
<?php
if ( null !== $day ) {
	?> title="<?php esc_attr_e( 'Voici la liste des personnes qui vous ont contacté ce jour-là' , 'call-manager' ) ?>" <?php
} else {
	?> title="<?php esc_attr_e( 'Voici la liste des personnes qui vous ont contacté ce mois-ci' , 'call-manager' ) ?>" <?php
}
?>
>
<p style="text-align: center; margin: 0 auto;"> <?php echo esc_html( 'Total : ' . $number_call . '. Renseigné : ' . $data_self_comment_count . '. Traité : ' . $data_treated_comment_count . '. Transféré : ' . $data_transfered_comment_count . '. A rappeler : ' . $data_recall_comment_count . '. Rappellera : ' . $data_will_recall_comment_count . '.' ); ?> </p>
	<table border="1" cellspacing="0" cellpadding="5" style="text-align: center; table-layout: fixed; margin: 0 auto;">
		<?php
		if ( $data_recall_comment_count > 0 ) {
			$cm_array = $array_recall_comment;
			include( plugin_dir_path( __FILE__ ) . 'summary-call-recap-child.php' );
		}
		if ( $data_will_recall_comment_count > 0 ) {
			$cm_array = $array_will_recall_comment;
			include( plugin_dir_path( __FILE__ ) . 'summary-call-recap-child.php' );
		}
		if ( $data_treated_comment_count > 0 ) {
			$cm_array = $array_treated_comment;
			include( plugin_dir_path( __FILE__ ) . 'summary-call-recap-child.php' );
		}
		if ( $data_transfered_comment_count > 0 ) {
			$cm_array = $array_transfered_comment;
			include( plugin_dir_path( __FILE__ ) . 'summary-call-recap-child.php' );
		}
		?>
	</table>
</div>
<?php
