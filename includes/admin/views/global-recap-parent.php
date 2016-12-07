<?php

	?>
	 <div style="text-align: center;">
		 <strong><?php echo esc_html( 'Récapitulatif des appels et blâmes le ' . $day . '/' . $month . '/' . $year, 'call-manager' ); ?></strong>
	 </div>
	 <?php
				$user_meta = get_user_meta( $user_id, 'imputation_' . $year . $month, true );
		if ( '' === $user_meta ) {
					$id_select = get_users( 'orderby=nicename&role=administrator&exclude=' . $user_id . '' );
			foreach ( $id_select as $user ) {
						$ids[ $user->ID ] = 0;
					}
					$ids['0'] = 0;
					$ids['999999'] = 0;
			for ( $i = 1; $i <= 31; $i++ ) {
						$imputation[ $i ] = array(
								'call' => 0,
								'blame' => $ids,
						);
					}
					update_user_meta( $user_id, 'imputation_' . $year . $month, $imputation );
					$user_meta = get_user_meta( $user_id, 'imputation_' . $year . $month, true );
					$total_call = $user_meta[ $day ]['call'];
				}
		foreach ( $data_users as $data ) {
				$user_id = $data->ID;
				$nom_util = $data->display_name;
			 	?>
				<?php include( plugin_dir_path( __FILE__ ) . 'global-recap-child.php' ); ?>
					<?php } ?>
