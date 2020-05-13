<?php
/**
 * Genesis Custom Blocks Pro upgrade page.
 *
 * @package   GenesisCustomBlocks
 * @copyright Copyright(c) 2020, Genesis Custom Blocks
 * @license   http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 */

use GenesisCustomBlocks\Admin\License;

?>
<section class="container">
	<div class="dashboard_welcome tile">
		<div class="tile_body">
			<div>
				<h1>Genesis Custom Blocks <span class="pro-pill">Pro</span></h1>
				<p class="description"><?php esc_html_e( 'A custom block building experience perfect for agencies and freelancers.', 'genesis-custom-blocks' ); ?></p>
				<div class="cta_license_form_wrapper">
					<form class="license_key_form" method="post" action="options.php">
						<?php
						register_setting( 'genesis-custom-blocks-license-key', License::OPTION_NAME );
						settings_fields( 'genesis-custom-blocks-license-key' );
						?>
						<input class="input_text" placeholder="Enter license key" name="<?php echo esc_attr( License::OPTION_NAME ); ?>" type="text" />
						<input class="button" type="submit" value="<?php esc_html_e( 'Activate', 'genesis-custom-blocks' ); ?>" />
					</form>
					<p class="license_key_text">or</p>
					<a target="_blank" class="button button--secondary button_cta" href="https://getblocklab.com/block-lab-pro"><?php esc_html_e( 'Go Pro', 'genesis-custom-blocks' ); ?></a>
				</div>
			</div>
		</div>
	</div>
	<!-- Dashboard Tile -->
	<div class="tile tile_2">
		<div class="tile_header">
			<div class="tile_icon_wrapper" style="background-image: url('https://getblocklab.com/wp-content/uploads/2019/02/block_lab_admin_icon_new_fields.svg');"></div>
		</div>
		<div class="tile_body">
			<h4 class="align_center"><?php esc_html_e( 'Pro Fields', 'genesis-custom-blocks' ); ?></h4>
			<p class="align_center"><?php esc_html_e( 'More fields including repeater, post object, and more to help you build the custom blocks you need for yourself and your clients.', 'genesis-custom-blocks' ); ?></p>
		</div>
	</div>
	<!-- Dashboard Tile -->
	<div class="tile tile_2">
		<div class="tile_header">
			<div class="tile_icon_wrapper" style="background-image: url('https://getblocklab.com/wp-content/uploads/2019/02/block_lab_admin_icon_features.svg');"></div>
		</div>
		<div class="tile_body">
			<h4 class="align_center"><?php esc_html_e( 'Pro Features', 'genesis-custom-blocks' ); ?></h4>
			<p class="align_center"><?php esc_html_e( 'Features including conditional logic, custom validation, and white-labeling, to help you extend Genesis Custom Blocks and leverage the best of Gutenberg.', 'genesis-custom-blocks' ); ?></p>
		</div>
	</div>
	<!-- Dashboard Tile -->
	<div class="tile tile_2">
		<div class="tile_header">
			<div class="tile_icon_wrapper" style="background-image: url('https://getblocklab.com/wp-content/uploads/2019/02/block_lab_admin_icon_support.svg');"></div>
		</div>
		<div class="tile_body">
			<h4 class="align_center"><?php esc_html_e( 'Pro Support', 'genesis-custom-blocks' ); ?></h4>
			<p class="align_center"><?php esc_html_e( 'Priority support and regular feature updates. We’re right here for you whenever you have a question.', 'genesis-custom-blocks' ); ?></p>
		</div>
	</div>
	<!-- Dashboard Tile -->
	<div class="tile tile_3">
	<div class="tile_body">
			<h4><?php esc_html_e( '★★ Loving Genesis Custom Blocks? ★★', 'genesis-custom-blocks' ); ?></h4>
			<p><?php esc_html_e( 'If Genesis Custom Blocks has helped you build amazing custom blocks for your site, leave us a review on WordPress.org.', 'genesis-custom-blocks' ); ?></p>
			<a class="button" target="_blank" href="https://wordpress.org/plugins/genesis-custom-blocks/#reviews"><?php esc_html_e( '★ Leave Review ★', 'genesis-custom-blocks' ); ?></a>
		</div>
	</div>
	<!-- Dashboard Tile -->
	<div class="tile tile_3">
	<div class="tile_body">
			<h4><?php esc_html_e( 'Get more out of Genesis Custom Blocks', 'genesis-custom-blocks' ); ?></h4>
			<p><?php esc_html_e( 'Subscribe to our newsletter for news, updates, and tutorials on working with Gutenberg.', 'genesis-custom-blocks' ); ?></p>
		</div>
		<div class="tile_footer tile_footer_email">
			<div id="mc_embed_signup">
				<form action="https://getblocklab.us19.list-manage.com/subscribe/post?u=f8e0c6b0ab32fc57ded52ab4a&amp;id=f05b221414" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					<div id="mc_embed_signup_scroll">
						<div class="mc-field-group">
							<label class="input_label" for="mce-EMAIL">Email Address </label>
							<input class="input" type="email" value="" placeholder="Email Address" name="EMAIL" id="mce-EMAIL" />
						</div>
						<div id="mce-responses" class="clear">
							<div class="response" id="mce-error-response" style="display:none"></div>
							<div class="response" id="mce-success-response" style="display:none"></div>
						</div>
						<div class="clear">
							<input class="button" type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" />
						</div>
					</div>
				</form>
			</div>

			<!--End mc_embed_signup-->
		</div>
	</div>
</section>
