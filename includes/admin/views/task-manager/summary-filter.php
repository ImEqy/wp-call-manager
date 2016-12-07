<?php
/**
 * [ENG] This Php file contains li to add on Chronology's task-maanger.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

if ( null !== $day ) {
	?>
	<li class='cm_summary_recap_daily'>
		<span style="cursor:pointer;" class="ab-action-recap-call-daily" data-id="<?php echo esc_attr( $user_id . $year . $month . $day ); ?>">
			<span class="dashicons dashicons-phone"> </span>
			<strong> <?php echo esc_html( $number_call ); ?> </strong>
		</span>
	</li>
	<li class='cm_summary_recap_daily'>
		<span style="cursor:pointer;" class="ab-action-recap-blame-daily" data-id="<?php echo esc_attr( $user_id . $year . $month . $day ); ?>">
			<span class="dashicons dashicons-businessman"> </span>
			<strong> <?php echo esc_html( $number_blame ); ?> </strong>
		</span>
	</li>
	<?php
} else {
	?>
	<li class='cm_summary_recap_monthly'>
		<span style="cursor:pointer;" class="ab-action-recap-call-monthly" data-id="<?php echo esc_attr( $user_id . $year . $month ); ?>">
			<span class="dashicons dashicons-phone"> </span>
			<strong> <?php echo esc_html( $number_call ); ?> </strong>
		</span>
	</li>
	<li class='cm_summary_recap_monthly'>
		<span style="cursor:pointer;" class="ab-action-recap-blame-monthly" data-id="<?php echo esc_attr( $user_id . $year . $month ); ?>">
			<span class="dashicons dashicons-businessman"> </span>
			<strong> <?php echo esc_html( $number_blame ); ?> </strong>
		</span>
	</li>
	<?php
}
