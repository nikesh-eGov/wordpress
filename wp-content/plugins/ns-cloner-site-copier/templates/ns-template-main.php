<?php
/**
 * Template for main cloner admin page
 *
 * @package NS_Cloner
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<div class="ns-cloner-header">
	<a href="<?php echo esc_url( network_admin_url( 'admin.php?page=' . ns_cloner()->menu_slug ) ); ?>">
		<img src="<?php echo esc_url( NS_CLONER_V4_PLUGIN_URL . 'images/ns-cloner-top-logo.png' ); ?>" alt="NS Cloner" />
	</a>
</div>

<div class="ns-cloner-wrapper <?php echo empty( ns_cloner()->get_modes() ) ? 'disabled' : 'enabled'; ?>">

	<form class="ns-cloner-form ns-cloner-main-form" method="post" enctype="multipart/form-data">

		<!-- premptive environment warnings -->
		<?php ns_cloner()->render( 'warnings' ); ?>

		<!-- mode selector -->
		<div class="ns-cloner-section" id="ns-cloner-section-modes">
			<div class="ns-cloner-section-header">
				<h4><?php esc_html_e( 'Select Cloning Mode', 'ns-cloner' ); ?></h4>
				<span class="ns-cloner-collapse-all">
					<small>&#9650;</small> <?php esc_html_e( 'Collapse All', 'ns-cloner' ); ?>
				</span>
				<span class="ns-cloner-expand-all">
					<small>&#9660;</small>
					<?php esc_html_e( 'Expand All', 'ns-cloner' ); ?>
				</span>
			</div>
			<div class="ns-cloner-section-content">
				<?php if ( empty( ns_cloner()->get_modes() ) ) : ?>
				<h5><?php esc_html_e( 'No cloning modes are currently available for this site.', 'ns-cloner' ); ?></h5>
				<?php else : ?>
				<select class="ns-cloner-select-mode" name="clone_mode">
					<?php foreach ( ns_cloner()->get_modes() as $mode_id => $details ) : ?>
						<option value="<?php echo esc_attr( $mode_id ); ?>"
								data-description="<?php echo esc_attr( wpautop( $details->description ) ); ?>"
								data-button-text="<?php echo esc_attr( $details->button_text ); ?>">
							<?php echo esc_html( $details->title ); ?>
						</option>
					<?php endforeach; ?>
				</select>
				<div class="ns-cloner-mode-description"></div>
				<?php endif; ?>
			</div>
		</div>

		<!-- sections -->
		<?php do_action( 'ns_cloner_render_sections' ); ?>

		<!-- warning text -->
		<div class="ns-cloner-disclaimer">
			<strong><?php esc_html_e( 'WARNING:', 'ns-cloner' ); ?></strong>
			<?php esc_html_e( 'We have made an incredibly complex process ridiculously easy with this powerful plugin. We have tested thoroughly and used this exact tool in our own live multisite environments. However, our comfort level should not dictate your precautions. If you\'re confident in your testing and back-up scheme - which you should have in place anyway ;) - then by all means - start cloning like there\'s no tomorrow!', 'ns-cloner' ); ?>
		</div>

	</form>

	<!-- sidebhar -->
	<?php ns_cloner()->render( 'sidebar' ); ?>

	<!-- clone button -->
	<div class="ns-cloner-button-wrapper">
		<div class="ns-cloner-button-steps"></div>
		<input class="ns-cloner-button" type="submit"/>
		<div class="ns-cloner-scroll-progress"></div>
	</div>

	<div class="ns-cloner-processes-modal">
		<div class="ns-cloner-processes-modal-wrapper">
			<div class="ns-cloner-processes-working">
				<div class="ns-modal-head">
					<button class="ns-modal-refresh"><?php esc_html_e( 'Refresh', 'ns-cloner' ); ?></button>
					<button class="ns-modal-cancel"><?php esc_html_e( 'Cancel', 'ns-cloner' ); ?></button>
					<h1>
						<span class="ns-modal-title">
						<?php
						// Display the title of the current in progress clone mode if applicable.
						if ( ns_cloner()->process_manager->is_in_progress() ) :
							$mode = ns_cloner_request()->get( 'clone_mode' );
							echo esc_html( $mode ? ns_cloner()->get_mode( $mode )->title : 'Unrecognized mode' );
						endif;
						?>
						</span>
						<?php esc_html_e( 'started...', 'ns-cloner' ); ?>
					</h1>
				</div>
				<div class="ns-modal-body">
					<div class="ns-cloner-warning-message ajax-on" style="display:none">
						<?php esc_html_e( 'NOTE: it appears background processing may have stalled on your site. Activating backup AJAX processing (so it\'s best not to close this window).', 'ns-cloner' ); ?>
					</div>
					<div class="ns-process-wrapper ns-create-site">
						<h2><?php esc_html_e( 'Current status', 'ns-cloner' ); ?>:</h2>
						<div class="ns-cloner-progress-bar">
							<div class="ns-percents">0%</div>
							<div class="ns-cloner-progress-bar-inner">
							</div>
						</div>
						<div class="ns-cloner-progress-info">
							<span class="objects-migrated">0</span> of
							<span class="total-objects">all</span>
							<?php esc_html_e( 'items processed', 'ns-cloner' ); ?>
						</div>
						<div class="ns-cloner-progress-items"></div>
					</div>
				</div>
			</div>
			<div class="ns-cloner-processes-done">
				<div class="ns-modal-head">
					<button class="ns-modal-close"><?php esc_html_e( 'Close', 'ns-cloner' ); ?></button>
					<h1><span class="ns-modal-title"></span> <?php esc_html_e( 'finished...', 'ns-cloner' ); ?></h1>
				</div>
				<div class="ns-modal-body">
					<div class="ns-process-report">
						<?php
						// Show report on previous clone operation if for some reason it wasn't seen.
						ns_cloner()->render( 'report' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
