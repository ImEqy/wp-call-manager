<?php

	?>
	 <div style="text-align: center;">
		 <strong><?php echo esc_html( 'Récapitulatif des appels et blâmes le '. $day . '/' . $month . '/' . $year, 'call-manager' ); ?></strong>
	 </div>
		<div id="jours" style="display: table; padding: 10px; "> <!-- Oké !-->
			<!-- Tableau User !-->
			<td rowspan="1" colspan="2">
				<?php echo "Nom d'utilisateur"; ?>
			</td>
				<?php
				$days = date( 't' );
				for ( $d = 1; ;$d++ ) {
					if ( $d == $days ) {
						break;
					}?>
				Jour <?php echo esc_html( $d ); ?>
				<?php }?>
				</div>
				<div>
			<?php
			foreach ( $data_users as $data ) {
				$user_id = $data->ID;
				$nom_util = $data->display_name;
			 	?>
					<?php echo esc_html( $nom_util ) ?>

				</div>
				<?php include( plugin_dir_path( __FILE__ ) . 'global-recap-child.php' ); ?>
					<?php } ?>
