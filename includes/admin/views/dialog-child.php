<?php
/**
 * [FR]  Page ajoutant la div contenant le dialog du bouton Recall.
 * [ENG] This Php file contain a div for button Recall's pop-up.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

?>
<tr style="background-color: #BBBBBB;">
	<th style="white-space: nowrap;"> <?php esc_html_e( "Date de réception de l'appel", 'call-manager' ) ?> </th>
	<th style="white-space: nowrap;"> <?php esc_html_e( 'Nom du Contact', 'call-manager' ) ?> </th>
	<th style="white-space: nowrap;"> <?php esc_html_e( 'Nom de la Société', 'call-manager' ) ?> </th>
	<th style="white-space: nowrap;"> <?php esc_html_e( 'Numéro de Téléphone', 'call-manager' ) ?> </th>
	<th style="white-space: nowrap;"> <?php esc_html_e( 'E-mail', 'call-manager' ) ?> </th>
	<th style="white-space: nowrap;"> <?php esc_html_e( 'Commentaire', 'call-manager' ) ?> </th>
	<th style="white-space: nowrap;">
		<?php
		if ( 'will_recall' === $comment['status'] ) {
			esc_html_e( 'A rappelé ?', 'call-manager' );
		} elseif ( 'recall' === $comment['status'] ) {
			esc_html_e( 'Traité ?', 'call-manager' );
		}
		?>
		</strong>
	</th>
</tr>
<?php
foreach ( $data_comment as $data ) {
	?>
	<tr>
		<td> <?php echo esc_html( $data->date_comment ); ?> </td>
		<td> <?php echo esc_html( $data->name_caller ); ?> </td>
		<td> <?php echo esc_html( $data->society_caller ); ?> </td>
		<td> <?php echo esc_html( $data->phone_caller ); ?> </td>
		<td> <?php echo esc_html( $data->mail_caller ); ?> </td>
		<td> <div style="width: 200px; word-wrap: break-word;"> <?php echo esc_html( $data->comment_content ); ?> </div> </td>
		<td>
			<a href="<?php echo esc_attr( $data->url ); ?>">
			<?php
			if ( 'will_recall' === $comment['status'] ) {
				esc_html_e( 'A rappelé', 'call-manager' );
			} elseif ( 'recall' === $comment['status'] ) {
				esc_html_e( 'Traité', 'call-manager' );
			} ?>
			</a>
		</td>
	</tr>
	<?php
}
?>
