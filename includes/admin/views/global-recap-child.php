<?php
/**
 * Page du tableau global-recap child
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 *
 */
$call = 5;
$blame = 6;
$days = date( 't' );
for ( $d = 1; ;$d++ ) {
	if ( $d == $days ) {
		break;
	}
?>
<div class="table" style="display: table;">
	<div class="tableRow">
			<?php esc_html( $d );?>
			<?php echo esc_html( $total_blame ); ?>
<div class="tableRow" style="display: table; text-align: center;">
	<?php echo esc_html( $call );
				echo esc_html( $blame );
				?>
</div>
</div>
</div>
<?php } ?>
