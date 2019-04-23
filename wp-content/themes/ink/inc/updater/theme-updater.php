<?php
/**
 * Easy Digital Downloads Theme Updater.
 *
 * @package Ink.
 */

// Includes the files needed for the theme updater.
if ( ! class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include dirname( __FILE__ ) . '/theme-updater-admin.php';
}

// Loads the updater classes.
$updater = new EDD_Theme_Updater_Admin(

	// Config settings.
	$config = array(
		'remote_api_url' => 'https://codestag.com', // Site where EDD is hosted.
		'item_name'      => 'Ink', // Name of theme.
		'theme_slug'     => 'ink', // Theme slug.
		'version'        => STAG_THEME_VERSION, // The current version of this theme.
		'author'         => 'Codestag', // The author of this theme.
		'download_id'    => '9383', // Optional, used for generating a license renewal link.
		'renew_url'      => '', // Optional, allows for a custom license renewal link.
		'beta'           => false, // Optional, set to true to opt into beta versions.
	),
	// Strings.
	$strings = array(
		'theme-license'             => __( 'Theme License', 'stag' ),
		'enter-key'                 => __(
			'Enter your theme license key received upon purchase from <a target="_blank" href="https://codestag.com/account/">Codestag</a>.<br><br>
											If you\'re coming from ThemeForest, please download <a href="https://envato.com/market-plugin/" target="_blank">Envato Market</a> plugin instead to receive automatic updates.', 'stag'
		),
		'license-key'               => __( 'License Key', 'stag' ),
		'license-action'            => __( 'License Action', 'stag' ),
		'deactivate-license'        => __( 'Deactivate License', 'stag' ),
		'activate-license'          => __( 'Activate License', 'stag' ),
		'status-unknown'            => __( 'License status is unknown.', 'stag' ),
		'renew'                     => __( 'Renew?', 'stag' ),
		'unlimited'                 => __( 'unlimited', 'stag' ),
		'license-key-is-active'     => __( 'License key is active.', 'stag' ),
		'expires%s'                 => __( 'Expires %s.', 'stag' ),
		'expires-never'             => __( 'Lifetime License.', 'stag' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'stag' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'stag' ),
		'license-key-expired'       => __( 'License key has expired.', 'stag' ),
		'license-keys-do-not-match' => __(
			'License keys do not match. <br><br> Enter your theme license key received upon purchase from <a target="_blank" href="https://codestag.com/account/">Codestag</a>.<br>
		If you\'re coming from ThemeForest, please download <a href="https://envato.com/market-plugin/" target="_blank">Envato Market</a> plugin instead to receive automatic updates.', 'stag'
		),
		'license-is-inactive'       => __( 'License is inactive.', 'stag' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'stag' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'stag' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'stag' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'stag' ),
		'update-available'          => __( '<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'stag' ),
	)
);
