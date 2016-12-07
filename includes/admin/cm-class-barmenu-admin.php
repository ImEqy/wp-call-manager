<?php
/**
 * [FR]  Page ajoutant les boutons Call & Blame & Recall ainsi que les divs contenant les formulaires et le css des boutons et des dialogs.
 * [ENG] This Php file adds buttons Call & Blame & Recall and contains divs for forms, dialogs' and buttons' css.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

/**
 * Class qui s'occupe d'intégrer et d'ajouter des formulaires aux boutons.
 */
class Cm_Barmenu_Admin {
	/**
	 * Fonction utilisé quand la class est appelé qui appelle les autres fonctions de la classe.
	 *
	 * @method __construct
	 */
	public function __construct() {
		add_action( 'admin_bar_menu', array( $this, 'cm_call' ), 100 );
		add_action( 'admin_bar_menu', array( $this, 'cm_blame' ), 101 );
		add_action( 'admin_bar_menu', array( $this, 'cm_recall' ), 102 );
		add_action( 'admin_bar_menu', array( $this, 'cm_will_recall' ), 102 );
		add_action( 'admin_menu', array( $this, 'cm_call_manager_menu' ), 102 );
		add_action( 'admin_footer', array( $this, 'dialog' ), 103 );
		add_action( 'admin_enqueue_scripts', array( $this, 'cm_custom_wp_toolbar_css_admin' ), 104 );
		add_action( 'wp_enqueue_scripts', array( $this, 'cm_custom_wp_toolbar_css_admin' ), 104 );
	}

	/**
	 * [FR]  La fonction suivante créer le bouton Call.
	 * [ENG] This function create the button Call.
	 *
	 * @method imputation_tel
	 * @param  mixed $wp_admin_bar WordPress function for addding node.
	 */
	public function cm_call( $wp_admin_bar ) {
		$user_data = get_userdata( get_current_user_id() );
		if ( 'administrator' === implode( ', ', $user_data->roles ) ) {
			$time_db = current_time( 'Ym' );
			$day = intval( current_time( 'd' ) );
			$select = get_user_meta( get_current_user_id(),'imputation_' . $time_db, true );
			if ( '' === $select ) {
				$id_select = get_users( 'orderby=nicename&role=administrator&exclude=' . get_current_user_id() . '' );
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
				update_user_meta( get_current_user_id(), 'imputation_' . $time_db, $imputation );
				$select = get_user_meta( get_current_user_id(),'imputation_' . $time_db, true );
				$total_call = $select[ $day ]['call'];
			}
			if ( '' !== $select ) {
				$total_call = $select[ $day ]['call'];
			}
			$bouton_tel = array(
				'id'       => 'imputation_tel',
				'title'    => '<span style="cursor:pointer;" class="ab-action"><span class="ab-icon"></span><span class="ab-label">' . $total_call . '</span></span>',
			);
			$wp_admin_bar->add_node( $bouton_tel );
			$bouton_tel_moins = array(
				'id'       => 'imputation_tel_moins',
				'title'    => '<span style="cursor:pointer;" class="ab-action-moins"><span class="ab-icon"></span>' . esc_html__( 'Retirer un appel' ) . '</span>',
				'parent'   => 'imputation_tel',
			);
			$wp_admin_bar->add_node( $bouton_tel_moins );
		}
	}

	/**
	 * [FR]  La fonction suivante créer le bouton Blame qui affiche un sub-menu de tous les administrateurs à blame.
	 * [ENG] This function create the Blame button which display a sub-menu of all administrators.
	 *
	 * @method imputation
	 * @param  mixed $wp_admin_bar WordPress function for addding node.
	 */
	public function cm_blame( $wp_admin_bar ) {
		$user_data = get_userdata( get_current_user_id() );
		if ( 'administrator' === implode( ', ', $user_data->roles ) ) {
			$time_db = current_time( 'Ym' );
			$day = intval( current_time( 'd' ) );
			$select = get_user_meta( get_current_user_id(),'imputation_' . $time_db, true );
			$total_blame = 0;
			$id_select = get_users( 'orderby=nicename&role=administrator&exclude=' . get_current_user_id() . '' );
			if ( ! empty( $id_select ) ) {
				foreach ( $id_select as $user ) {
					$x = $user->ID;
					if ( ! empty( $select[ $day ]['blame'][ $x ] ) ) {
						$total_blame = $total_blame + $select[ $day ]['blame'][ $x ];
					}
				}
				if ( ! isset( $select[ $day ]['blame']['0'] ) ) {
					$select[ $day ]['blame']['0'] = 0;
				}
				if ( ! isset( $select[ $day ]['blame']['999999'] ) ) {
					$select[ $day ]['blame']['999999'] = 0;
				}
				$total_blame = $total_blame + $select[ $day ]['blame']['0'];
				$total_blame = $total_blame + $select[ $day ]['blame']['999999'];
			}
			$bouton_blame = array(
				'id' 		=> 'imputation',
				'title'	=> '<span class="ab-icon"></span><span class="ab-label">' . $total_blame . '</span>',
			);
			$wp_admin_bar->add_node( $bouton_blame );
			$admin_user = get_users( 'orderby=nicename&role=administrator&exclude=' . get_current_user_id() . '' );
			$blame_number_inconnu = 0;
			if ( ! empty( $select[ $day ]['blame']['0'] ) ) {
				$blame_number_inconnu = $select[ $day ]['blame']['0'];
			}
			$inconnu = array(
				'id' => 'to_blame_0',
				'title' => '<span class="ab-child">Inconnu ' . esc_html__( 'vous a interrompu :', 'call-manager' ) . ' <span class="ab-retour_0">' . $blame_number_inconnu . '</span> fois.</span>',
				'parent' => 'imputation',
				'href' => admin_url( 'admin-ajax.php?action=count&user_id=0' ),
				'meta' => array(
					'class' => 'child_blame',
					'title' => esc_html__( 'Cliquez pour ajouter une interruption' ),
				),
			);
			$wp_admin_bar->add_node( $inconnu );
			$blame_number_stagiaire = 0;
			if ( ! empty( $select[ $day ]['blame']['999999'] ) ) {
				$blame_number_stagiaire = $select[ $day ]['blame']['999999'];
			}
			$stagiaire = array(
				'id' => 'to_blame_999999',
				'title' => '<span class="ab-child">Stagiaire ' . esc_html__( 'vous a interrompu :', 'call-manager' ) . ' <span class="ab-retour_999999">' . $blame_number_stagiaire . '</span> fois.</span>',
				'parent' => 'imputation',
				'href' => admin_url( 'admin-ajax.php?action=count&user_id=999999' ),
				'meta' => array(
					'class' => 'child_blame',
					'title' => esc_html__( 'Cliquez pour ajouter une interruption' ),
				),
			);
			$wp_admin_bar->add_node( $stagiaire );
			foreach ( $admin_user as $user ) {
				$id = $user->ID;
				$name = ucfirst( $user->display_name );
				$blame_number = 0;
				if ( ! empty( $select[ $day ]['blame'][ $id ] ) ) {
					$blame_number = $select[ $day ]['blame'][ $id ];
				}
				$to_blame = array(
					'id' => 'to_blame_' . $id,
					'title' => '<span class="ab-child">' . $name . ' ' . esc_html__( 'vous a interrompu :', 'call-manager' ) . ' <span class="ab-retour_' . $id . '">' . $blame_number . '</span> fois.</span>',
					'parent' => 'imputation',
					'href' => admin_url( 'admin-ajax.php?action=count&user_id=' . $id ),
					'meta' => array(
						'class' => 'child_blame',
						'title' => esc_html__( 'Cliquez pour ajouter une interruption' ),
					),
				);
				$wp_admin_bar->add_node( $to_blame );
			}
			$group = array(
				'id' => 'blame_group',
				'parent' => 'imputation',
			);
			$wp_admin_bar->add_group( $group );
		}
	}

	/**
	 * Bouton Recall qui ne s'affiche que quand vous avez une personne à rappeler.
	 *
	 * @method imputation_recall.
	 * @param  mixed $wp_admin_bar WordPress function for addding node.
	 */
	public function cm_recall( $wp_admin_bar ) {
		$user_data = get_userdata( get_current_user_id() );
		if ( 'administrator' === implode( ', ', $user_data->roles ) ) {
			$select_comment = array(
				'meta_key' => '_eocm_receiver_id',
				'meta_value' => get_current_user_id(),
				'status' => 'recall',
				'count' => true,
			);
			$selected_comment = get_comments( $select_comment );
			if ( $selected_comment > 0 ) {
				$bouton_recall = array(
					'id' => 'imputation_recall',
					'title' => '<span id="spanny" style="cursor:pointer;" class="ab-action-recall"><span class="ab-icon"></span>' . esc_html( 'Vous avez des personnes à rappeler !', 'call-manager' ) . '</span>',
					'meta' => array( 'title' => __( 'CLiquez ici pour plus de détails' ) ),
				);
				$wp_admin_bar->add_node( $bouton_recall );
			}
		}
	}

	/**
	 * Bouton Will_recall qui ne s'affiche que quand vous une personne va rappeler.
	 *
	 * @method cm_will_recall
	 * @param  mixed $wp_admin_bar WordPress function for addding node.
	 */
	public function cm_will_recall( $wp_admin_bar ) {
		$user_data = get_userdata( get_current_user_id() );
		if ( 'administrator' === implode( ', ', $user_data->roles ) ) {
			$select_comment = array(
				'meta_key' => '_eocm_receiver_id',
				'meta_value' => get_current_user_id(),
				'status' => 'will_recall',
				'count' => true,
			);
			$selected_comment = get_comments( $select_comment );
			if ( $selected_comment > 0 ) {
				$bouton_will_recall = array(
					'id' => 'imputation_will_recall',
					'title' => '<span id="spanny-deux" style="cursor:pointer;" class="ab-action-will-recall"><span class="ab-icon"></span>' . esc_html( 'Des personnes veulent vous rappeler !', 'call-manager' ) . '</span>',
					'meta' => array( 'title' => __( 'CLiquez ici pour plus de détails' ) ),
				);
				$wp_admin_bar->add_node( $bouton_will_recall );
			}
		}
	}

	/**
	 * [cm_call_manager_menu description]
	 *
	 * @method cm_call_manager_menu
	 */
	public function cm_call_manager_menu() {
		$user_data = get_userdata( get_current_user_id() );
		if ( 'administrator' === implode( ', ', $user_data->roles ) ) {
			add_menu_page( 'Call Manager', 'Call Manager', 'administrator', 'cm-menu', array( $this, 'cm_call_manager_menu_callback' ), 'dashicons-book-alt' );
		}
	}

	/**
	 * [cm_call_manager_menu_callback description]
	 *
	 * @method cm_call_manager_menu_callback.
	 */
	public function cm_call_manager_menu_callback() {
		$data_users = get_users( 'orderby=nicename&role=administrator' );
		$year = current_time( 'Y' );
		$month = current_time( 'm' );
		$day = intval( current_time( 'd' ) );
		$color = 5;
		if ( ! empty( $_POST['_wpnonce_up'] ) && check_admin_referer( 'up_check', '_wpnonce_up' ) ) {
			if ( ( current_time( 'm' ) !== $_POST['month'] ) and ( current_time( 'Y' ) !== $_POST['year'] ) ) {
				$year = $_POST['year'];
				$month = $_POST['month'];
			} elseif ( ( current_time( 'm' ) === $_POST['month'] ) and ( current_time( 'Y' ) !== $_POST['year'] ) ) {
				$year = $_POST['year'];
				$month = current_time( 'm' );
			} elseif ( ( current_time( 'm' ) !== $_POST['month'] ) and ( current_time( 'Y' ) === $_POST['year'] ) ) {
				$year = current_time( 'Y' );
				$month = $_POST['month'];
			}
			if ( isset( $_POST['color'] ) ) {
				$color = abs( $_POST['color'] );
			}
		}
		include( plugin_dir_path( __FILE__ ) . 'views/form-global-recap.php' );
		include( plugin_dir_path( __FILE__ ) . 'views/global-recap-parent.php' );
	}

	/**
	 * [FR]  Création de la Div pour la pop-up du bouton Call & Recall.
	 * [ENG] Here we create a div for the pop-up dialog when you clic on the Call & Recall buttons.
	 *
	 * @method dialog_call.
	 */
	public function dialog() {
		include( plugin_dir_path( __FILE__ ) . 'views/form-call.php' );
		$comment = array(
			'meta_key' => '_eocm_receiver_id',
			'meta_value' => get_current_user_id(),
			'order' => 'ASC',
		);
		$comment['status'] = 'will_recall';
		$data_comment = get_comments( $comment );
		foreach ( $data_comment as $comments ) {
			$comments->date_comment = get_comment_date( '', $comments->comment_ID );
			$comments->name_caller = get_comment_meta( $comments->comment_ID, '_eocm_caller_name', true );
			$comments->society_caller = get_comment_meta( $comments->comment_ID, '_eocm_caller_society', true );
			$comments->phone_caller = get_comment_meta( $comments->comment_ID, '_eocm_caller_phone', true );
			$comments->mail_caller = get_comment_meta( $comments->comment_ID, '_eocm_caller_email', true );
			$comments->url = admin_url( 'admin-ajax.php?action=treated&comment_id=' . $comments->comment_ID );
		}
		include( plugin_dir_path( __FILE__ ) . 'views/dialog-parent.php' );
		$comment['status'] = 'recall';
		$data_comment = get_comments( $comment );
		foreach ( $data_comment as $comments ) {
			$comments->date_comment = get_comment_date( '', $comments->comment_ID );
			$comments->name_caller = get_comment_meta( $comments->comment_ID, '_eocm_caller_name', true );
			$comments->society_caller = get_comment_meta( $comments->comment_ID, '_eocm_caller_society', true );
			$comments->phone_caller = get_comment_meta( $comments->comment_ID, '_eocm_caller_phone', true );
			$comments->mail_caller = get_comment_meta( $comments->comment_ID, '_eocm_caller_email', true );
			$comments->url = admin_url( 'admin-ajax.php?action=treated&comment_id=' . $comments->comment_ID );
		}
		include( plugin_dir_path( __FILE__ ) . 'views/dialog-parent.php' );
	}

	/**
	 * [FR]  Ajout du CSS des boutons Call & BLame.
	 * [ENG] Function to add CSS for buttons Call & Blame.
	 *
	 * @method custom_wp_toolbar_css_admin.
	 */
	public function cm_custom_wp_toolbar_css_admin() {
		wp_enqueue_style( 'cm_add_custom_wp_toolbar_css', plugin_dir_url( __FILE__ ) . '../../assets/css/style.css', array( 'wp-jquery-ui-dialog' ) );
		wp_enqueue_script( 'cm_custom_js', plugin_dir_url( __FILE__ ) . '../../assets/js/admin/cm-admin.js', array( 'jquery-ui-dialog', 'jquery-form' ) );
	}
}

new Cm_Barmenu_Admin();
