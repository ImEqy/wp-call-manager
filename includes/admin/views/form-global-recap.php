<?php
/**
 * Page ajoutant le formulaire d'up de la page.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

?>
<div class="wrap">
	<form method="post">
		<?php
		wp_nonce_field( 'up_check', '_wpnonce_up' );
		$actual_year = intval( $year );
		$actual_month = intval( $month );
		?>
		<?php echo esc_html( 'Année :', 'call-manager' ); ?>
		<select name="year">
			<?php
			for ( $y = 2016; $y <= $actual_year ; $y++ ) {
				?>
				<option value="<?php echo esc_attr( $y ); ?>" <?php if ( $actual_year === $y ) { ?> selected="selected" <?php } ?> > <?php echo esc_html( $y ); ?></option>
				<?php
			}
			?>
		</select>
		<?php echo esc_html( 'Mois :', 'call-manager' ); ?>
		<select name="month">
			<?php
			for ( $m = 1; $m < 13; $m++ ) {
				?>
				<option value="<?php echo esc_attr( $m ); ?>" <?php if ( $actual_month === $m ) { ?> selected="selected" <?php } ?> > <?php echo esc_html( $m ); ?></option>
				<?php
			}
			?>
		</select>
		<?php echo esc_html( 'Seuil de coloration :', 'call-manager' ); ?>
		<input type="text" name="color" value="<?php echo esc_html( $color ); ?>">
		<input type="submit" name="up" value="Filtrer">
	</form>
</div>
<?php
