<?php
/**
 * [FR]  Page ajoutant les filtres des boutons Call & Blame.
 * [ENG] This Php file contain filters for buttons Call & Blame.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

/**
 * Class qui gère les ajouts sur Task Manager..
 */
class Cm_Filter_Admin {
	/**
	 * Fonction utilisé quand la class est appelé qui appelle les autres fonctions de la classe.
	 *
	 * @method __construct
	 */
	public function __construct() {
		add_filter( 'tm_filter_timeline_summary_month_end', array( $this, 'display' ), 106, 4 );
		add_filter( 'tm_filter_timeline_day', array( $this, 'display' ), 106, 5 );
	}

	/**
	 * [FR]  Ajout du total de Call & Blame du mois et du jour dans la chronologie.
	 * [ENG] From here it's the compatiblity with Task-manager's Chronology.
	 *
	 * @method display.
	 * @param  mixed $content Le contenu.
	 * @param  int   $user_id L'id de la personne en cours d'affichage.
	 * @param  int   $year    L'année de la chronologie affichée.
	 * @param  int   $month   Le mois en cours de la chronologie.
	 * @param  int   $day     Le jour en cours de la chronologie.
	 */
	public function display( $content, $user_id, $year, $month, $day = null ) {
		$this->display_total( $content, $user_id, $year, $month, $day );
		$this->display_call_recap( $content, $user_id, $year, $month, $day );
		$this->display_blame_recap( $content, $user_id, $year, $month, $day );
	}

	/**
	 * Affichage des totaux dans la chronologie.
	 *
	 * @method display_total
	 * @param  mixed $content Le contenu.
	 * @param  int   $user_id L'id de la personne en cours d'affichage.
	 * @param  int   $year    L'année de la chronologie affichée.
	 * @param  int   $month   Le mois en cours de la chronologie.
	 * @param  int   $day     Le jour en cours de la chronologie.
	 */
	public function display_total( $content, $user_id, $year, $month, $day = null ) {
		$number_call = 0;
		$number_blame = 0;
		$selection = get_user_meta( $user_id, 'imputation_' . $year . '' . $month, true );
		if ( ! empty( $selection ) ) {
			if ( null === $day ) {
				foreach ( $selection as $key => $call ) {
					$number_call = $number_call + $selection[ $key ]['call'];
					foreach ( $selection[ $key ]['blame'] as $id => $valueblame ) {
						$number_blame = $number_blame + $selection[ $key ]['blame'][ $id ];
					}
				}
			} else {
				$number_call = $selection[ $day ]['call'];
				foreach ( $selection[ $day ]['blame'] as $id => $valueblame ) {
					$number_blame = $number_blame + $selection[ $day ]['blame'][ $id ];
				}
			}
		}
		include( plugin_dir_path( __FILE__ ) . 'views/task-manager/summary-filter.php' );
	}

	/**
	 * Ajout des récaps.
	 *
	 * @method display_call_recap
	 * @param  mixed $content Le contenu.
	 * @param  int   $user_id L'id de la personne en cours d'affichage.
	 * @param  int   $year    L'année de la chronologie affichée.
	 * @param  int   $month   Le mois en cours de la chronologie.
	 * @param  int   $day     Le jour en cours de la chronologie.
	 */
	public function display_call_recap( $content, $user_id, $year, $month, $day = null ) {
		$number_call = 0;
		$selection = get_user_meta( $user_id, 'imputation_' . $year . '' . $month, true );
		if ( ! empty( $selection ) ) {
			if ( null === $day ) {
				foreach ( $selection as $key => $call ) {
					$number_call = $number_call + $selection[ $key ]['call'];
				}
			} else {
				$number_call = $selection[ $day ]['call'];
			}
		}
		$comment = array(
			'meta_key' => '_eocm_receiver_id',
			'meta_value' => get_current_user_id(),
			'status' => array( 'treated', 'recall', 'transfered', 'will_recall' ),
			'order' => 'ASC',
			'date_query' => array( 'year' => $year, 'month' => $month, 'day' => $day ),
		);
		$data_comment = get_comments( $comment );
		$data_self_comment_count = 0;
		$data_treated_comment_count = 0;
		$data_transfered_comment_count = 0;
		$data_recall_comment_count = 0;
		$data_will_recall_comment_count = 0;
		$array_treated_comment['0'] = array( 'status' => 'treated' );
		$array_transfered_comment['0'] = array( 'status' => 'transfered' );
		$array_recall_comment['0'] = array( 'status' => 'recall' );
		$array_will_recall_comment['0'] = array( 'status' => 'will_recall' );
		foreach ( $data_comment as $data ) {
			$temp_data_comment = array(
				'status' => $data->comment_approved,
				'date_comment' => get_comment_date( '', $data->comment_ID ),
				'name_caller' => get_comment_meta( $data->comment_ID, '_eocm_caller_name', true ),
				'society_caller' => get_comment_meta( $data->comment_ID, '_eocm_caller_society', true ),
				'phone_caller' => get_comment_meta( $data->comment_ID, '_eocm_caller_phone', true ),
				'mail_caller' => get_comment_meta( $data->comment_ID, '_eocm_caller_email', true ),
				'comment_content_receive' => $data->comment_content,
			);
			if ( get_current_user_id() === intval( $data->user_id ) ) {
				$data_self_comment_count++;
			}
			if ( 'treated' === $temp_data_comment['status'] ) {
				$data_treated_comment_count++;
				$array_treated_comment[ $data_treated_comment_count ] = $temp_data_comment;
			}
			if ( 'transfered' === $temp_data_comment['status'] ) {
				$data_transfered_comment_count++;
				$array_transfered_comment[ $data_transfered_comment_count ] = $temp_data_comment;
			}
			if ( 'recall' === $temp_data_comment['status'] ) {
				$data_recall_comment_count++;
				$array_recall_comment[ $data_recall_comment_count ] = $temp_data_comment;
			}
			if ( 'will_recall' === $temp_data_comment['status'] ) {
				$data_will_recall_comment_count++;
				$array_will_recall_comment[ $data_will_recall_comment_count ] = $temp_data_comment;
			}
		}
		include( plugin_dir_path( __FILE__ ) . 'views/task-manager/summary-call-recap-parent.php' );
	}

	/**
	 * Ajout des récaps.
	 *
	 * @method display_blame_recap
	 * @param  mixed $content Le contenu.
	 * @param  int   $user_id L'id de la personne en cours d'affichage.
	 * @param  int   $year    L'année de la chronologie affichée.
	 * @param  int   $month   Le mois en cours de la chronologie.
	 * @param  int   $day     Le jour en cours de la chronologie.
	 */
	public function display_blame_recap( $content, $user_id, $year, $month, $day = null ) {
		$select = get_user_meta( get_current_user_id(),'imputation_' . $year . $month, true );
		$id_select = get_users( 'orderby=nicename&role=administrator&exclude=' . get_current_user_id() . '' );
		$i = 0;
		if ( ! empty( $id_select ) ) {
			if ( null === $day ) {
				for ( $m = 0; $m <= 31; $m++ ) {
					$cm_month[] = $m;
				}
				$nbr_total_blame_inconnu = 0;
				$nbr_total_blame_stagiaire = 0;
				$cm_blame_recap_month_array = array();
				foreach ( $cm_month as $non_day ) {
					if ( isset( $select[ $non_day ]['blame']['0'] ) and ( 0 !== $select[ $non_day ]['blame']['0'] ) ) {
						$nbr_total_blame_inconnu = $nbr_total_blame_inconnu + $select[ $non_day ]['blame']['0'];
					}
					if ( isset( $select[ $non_day ]['blame']['999999'] ) and ( 0 !== $select[ $non_day ]['blame']['999999'] ) ) {
						$nbr_total_blame_stagiaire = $nbr_total_blame_stagiaire + $select[ $non_day ]['blame']['999999'];
					}
					foreach ( $id_select as $user ) {
						if ( ! empty( $select[ $non_day ]['blame'][ $user->ID ] ) ) {
							$name = ucfirst( $user->display_name );
							$nbr_blame = $select[ $non_day ]['blame'][ $user->ID ];
							if ( ! isset( $cm_blame_recap_month_array[ $name ] ) ) {
								$cm_blame_recap_month_array[ $name ] = 0;
							}
							$cm_blame_recap_month_array[ $name ] = $cm_blame_recap_month_array[ $name ] + $nbr_blame;
						}
					}
				}
				$cm_blame_recap_month_array['Inconnus'] = $nbr_total_blame_inconnu;
				$cm_blame_recap_month_array['Stagiaires'] = $nbr_total_blame_stagiaire;
			}
			if ( null !== $day ) {
				$cm_blame_recap_day_array = array();
				if ( isset( $select[ $day ]['blame']['0'] ) and ( 0 !== $select[ $day ]['blame']['0'] ) ) {
					$cm_blame_recap_day_array['Inconnus'] = $select[ $day ]['blame']['0'];
				}
				if ( isset( $select[ $day ]['blame']['999999'] ) and ( 0 !== $select[ $day ]['blame']['999999'] ) ) {
					$cm_blame_recap_day_array['Stagiaires'] = $select[ $day ]['blame']['999999'];
				}
				foreach ( $id_select as $user ) {
					if ( ! empty( $select[ $day ]['blame'][ $user->ID ] ) ) {
						$name = ucfirst( $user->display_name );
						$nbr_blame = $select[ $day ]['blame'][ $user->ID ];
						$cm_blame_recap_day_array[ $name ] = $nbr_blame;
					}
				}
			}
			include( plugin_dir_path( __FILE__ ) . 'views/task-manager/summary-blame-recap.php' );
		}
	}
}

new Cm_Filter_Admin();
