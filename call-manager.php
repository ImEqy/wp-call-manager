<?php
/**
 * Initialisation du plugin.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

/*
 * Plugin Name: Call Manager
 * Description: Un plugin pour les devs d'Eoxia.
 * Version: 1.13.0.0.
 * Author: Damien.
*/

include( 'includes/admin/cm-class-ajax-admin.php' );
include( 'includes/admin/cm-class-barmenu-admin.php' );
include( 'includes/admin/cm-class-filter-admin.php' );
include( 'includes/admin/cm-class-send-mail-admin.php' );
