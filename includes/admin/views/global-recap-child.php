<?php
/**
 * Page du tableau global-recap child
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 *
 */
$id_select = get_users( 'orderby=nicename&role=administrator&exclude=' . $user_id . '' );
if ( ! empty( $id_select ) ) {
	foreach ( $id_select as $user ) {
		$x = $user->ID;
			if ( ! empty( $user_meta[ $day ]['blame'][ $x ] ) ) {
				$total_blame = $total_blame + $user_meta[ $day ]['blame'][ $x ];
		}
	}
		if ( ! isset( $user_meta[ $day ]['blame']['0'] ) ) {
			$user_meta[ $day ]['blame']['0'] = 0;
	}
		if ( ! isset( $user_meta[ $day ]['blame']['999999'] ) ) {
			$user_meta[ $day ]['blame']['999999'] = 0;
	}
		$total_blame = $total_blame + $user_meta[ $day ]['blame']['0'];
		$total_blame = $total_blame + $user_meta[ $day ]['blame']['999999'];
}
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
					<span><?php echo esc_html( $total_call ) ?></span> | <span><?php echo esc_html( $total_blame ) ?></span>
			</div>
					</div>
<?php } ?>
</div>
</div>
</div>
