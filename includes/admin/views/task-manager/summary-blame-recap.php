<?php
/**
 * [FR]  Page ajoutant la div contenant le dialog du blame-recap dans chronologie de task-maanger.
 * [ENG] This Php file contain a div for the blame-recap's pop-up from Chronology in task-maanger.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

?>
<div id="cm-summary-blame-recap-<?php echo esc_attr( $user_id . $year . $month . $day ); ?>" class="hidden pop-up"
<?php
if ( null !== $day ) {
	?> title="<?php esc_attr_e( 'Voici la liste des personnes que vous avez blame ce jour-là' , 'call-manager' ) ?>" <?php
} else {
	?> title="<?php esc_attr_e( 'Voici la liste des personnes que vous avez blame ce mois-ci' , 'call-manager' ) ?>" <?php
}
?>
>
	<table>
			<tr>
		<?php
		if ( null !== $day ) {
			foreach ( $cm_blame_recap_day_array as $name => $nbr_blame_day ) {
				?>
				<td> <?php echo esc_html( $name . ' : ' . $nbr_blame_day . '.' ) ?> </td>
				<td> </td> <td> </td> <td> </td> <td> </td> <td> </td>
				<?php
				$i++;
				if ( 0 === $i % 8 ) {
					?> </tr> <tr> <?php
				}
			}
		} elseif ( null === $day ) {
			foreach ( $cm_blame_recap_month_array as $name => $nbr_blame_month ) {
				?>
				<td> <?php echo esc_html( $name . ' : ' . $nbr_blame_month . '.' ) ?> </td>
				<td> </td> <td> </td> <td> </td> <td> </td> <td> </td>
				<?php
				$i++;
				if ( 0 === $i % 8 ) {
					?> </tr> <tr> <?php
				}
			}
		}
		?>
		</tr>
	</table>
</div>
