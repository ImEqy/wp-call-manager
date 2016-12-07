<?php
/**
 * [FR]  Page ajoutant la div contenant le dialog du call-recap dans chronologie de task-maanger.
 * [ENG] This Php file contain a div for the call-recap's pop-up from Chronology in task-maanger.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

?>
<tr style="background-color: #BBBBBB;">
	<th colspan="6">
		<?php
		if ( 'recall' === $cm_array['0']['status'] ) {
			esc_html_e( 'Liste des appels reçus que vous devez rappeler', 'call-maanger' );
		} elseif ( 'will_recall' === $cm_array['0']['status'] ) {
			esc_html_e( 'Liste des appels reçus qui rappelleront', 'call-maanger' );
		} elseif ( 'treated' === $cm_array['0']['status'] ) {
			esc_html_e( 'Liste des appels traités', 'call-maanger' );
		} elseif ( 'transfered' === $cm_array['0']['status'] ) {
			esc_html_e( 'Liste des appels transférés', 'call-maanger' );
		}
		?>
	</th>
</tr>
<tr style="background-color: #e0e0e0;">
	<th style="white-space: nowrap;"> <?php esc_html_e( "Date de réception de l'appel", 'call-manager' ) ?> </th>
	<th style="white-space: nowrap;"> <?php esc_html_e( 'Nom du Contact', 'call-manager' ) ?> </th>
	<th style="white-space: nowrap;"> <?php esc_html_e( 'Nom de la Société', 'call-manager' ) ?> </th>
	<th style="white-space: nowrap;"> <?php esc_html_e( 'Numéro de Téléphone', 'call-manager' ) ?> </th>
	<th style="white-space: nowrap;"> <?php esc_html_e( 'E-mail', 'call-manager' ) ?> </th>
	<th style="white-space: nowrap;"> <?php esc_html_e( 'Commentaire', 'call-manager' ) ?> </th>
</tr>
<?php
unset( $cm_array['0'] );
foreach ( $cm_array as $key => $value ) {
	?>
	<tr style="background-color: #eeeeee;">
		<td> <?php echo esc_html( $value['date_comment'] ); ?> </td>
		<td> <?php echo esc_html( $value['name_caller'] ); ?> </td>
		<td> <?php echo esc_html( $value['society_caller'] ); ?> </td>
		<td> <?php echo esc_html( $value['phone_caller'] ); ?> </td>
		<td> <?php echo esc_html( $value['mail_caller'] ); ?> </td>
		<td> <div style="width: 200px; word-wrap: break-word;"> <?php echo esc_html( $value['comment_content_receive'] ); ?> </div> </td>
	</tr>
