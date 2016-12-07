<?php
/**
 * [FR]  Page ajoutant la div contenant le dialog du bouton Call.
 * [ENG] This Php file contain a div for button Call's pop-up.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

?>
<div id="dialog" title="Renseignements">
	<p>
		<form id="form-dialog" action="<?php echo esc_html( admin_url( 'admin-ajax.php' ) ); ?>">
			<?php
			wp_nonce_field( 'form_dialog_check', '_wpnonce_dialog' );
			$admin_user = get_users( 'orderby=nicename&role=administrator' );
			?>
			<?php esc_html_e( 'Pour qui ?', 'call-manager' ) ?> <br />
			<select name = "to_call">
				<?php
				foreach ( $admin_user as $user ) {
					$id = $user->ID;
					$name = ucfirst( $user->display_name );
					?> <option <?php selected( $id, get_current_user_id(), true ) ?> value="<?php echo esc_attr( $id ); ?>"><?php echo esc_attr( $name ); ?></option> <?php
				}
				?>
			</select> <br />
			<input type="hidden" name="action" value="form_call">
			<?php esc_html_e( 'Choisissez votre option :', 'call-manager' ) ?> <br />
			<input type="radio" id="treated" name="button_call" value="treated" checked="checked"> <label for="treated"><?php esc_html_e( 'Traité', 'call-manager' ); ?> </label> <br />
			<input type="radio" id="transfered" name="button_call" value="transfered"> <label for="transfered"><?php esc_html_e( 'Transféré', 'call-manager' ); ?> </label> <br />
			<input type="radio" id="will_recall" name="button_call" value="will_recall"> <label for="will_recall"> <?php esc_html_e( 'Rappellera', 'call-manager' ); ?> </label> <br />
			<input type="radio" id="recall" name="button_call" value="recall"> <label for="recall"> <?php esc_html_e( 'A rappeler', 'call-manager' ); ?> </label> <br />
			<?php esc_html_e( 'Informations contact :', 'call-manager' ) ?> <br />
			<input type="text" id="name_contact_call" name="name_contact_call" placeholder="<?php esc_attr_e( 'Nom du contact', 'call-manager' ) ?>"> <br />
			<input type="text" id="society_contact_call" name="society_contact_call" placeholder="<?php esc_attr_e( 'Société du contact', 'call-manager' ) ?>"> <br />
			<input type="text" id="number_contact_call" name="number_contact_call" placeholder="<?php esc_attr_e( 'Numéro du contact', 'call-manager' ) ?>"> <br />
			<input type="email" id="email_contact_call" name="email_contact_call" placeholder="<?php esc_attr_e( 'E-mail du contact', 'call-manager' ) ?>"> <br />
			<textarea rows="3" cols="15" id="comment_content_call" form="form-dialog" name="comment_content_call" placeholder="<?php esc_attr_e( 'Commentaire', 'call-manager' ) ?>"></textarea> <br />
		</form>
	</p>
</div>
