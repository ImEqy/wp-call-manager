<?php
/**
 * Page du tableau global-recap child
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 *
 */
	?>

	<div class="rTable">
				 <div class="rTableRow" style="">
				 <div class="rTableName"><strong><?php echo esc_html( $nom_util );?>
				 </strong></div>

	<div class="rTableDay">
<?php
$days = date( 't' );
for ( $d = 1; ;$d++ ) {
	if ( $d == $days ) {
		break;
	}
?>
<div class="rTableHead" style="text-align: center;">
				Jour <?php echo esc_html( $d ); ?>
				<div class="rTableRow">
					<span class="dashicons dashicons-phone"></span>
					<span class="dashicons dashicons-businessman"></span>
					<br>
					<span><?php echo esc_html( $total_call ) ?></span> | <span><?php echo esc_html( x ) ?></span>
			</div>
					</div>
<?php } ?>
</div>
</div>
</div>
