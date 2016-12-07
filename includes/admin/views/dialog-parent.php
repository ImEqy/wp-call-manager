<?php
/**
 * [FR]  Page ajoutant la div contenant le dialog du bouton Recall.
 * [ENG] This Php file contain a div for button Recall's pop-up.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

?>
<div
	<?php
	if ( 'will_recall' === $comment['status'] ) {
	?> id="dialog-will-recall" title="Voici les personnes qui vont rappeler"
	<?php
	} elseif ( 'recall' === $comment['status'] ) {
	?> id="dialog-recall" title="Voici les personnes que vous devez rappeler"
	<?php
	}
	?> class="hidden"
>
	<table border="1" cellspacing="0" cellpadding="5" style="text-align: center; table-layout: fixed;">
	<?php include( plugin_dir_path( __FILE__ ) . 'dialog-child.php' ); ?>
	</table>
</div>
