<?PHP

namespace Pbr\Berpf;

class Admin {
    	 static function adm_cfg_menu_html() {

			if (!current_user_can('manage_options')) {
					return;
			}
?>
<h3>pbrberpf: PBR Booking Engine Result Pre-Filter</h3>
<?PHP settings_errors(); ?>
<div class="wrap">
<h1><?PHP echo esc_html(get_admin_page_title()); ?></h1>
	<form method="post" action="options.php">
<?PHP
			settings_fields('pbrberpf');
			do_settings_sections('pbrberpf_settings');
			do_settings_fields('pbrberpf', 'pbrberpf_settings');
?>
<br /><br />
<div id="exsynexplain">
Exclusion should be written as
<b>Title 1#Title 2#Title 3..,</b>
	where <b>Title 1</b> is the name of a package you want excluded from the search result
</div>
<br />
<?PHP submit_button('Save Settings'); ?>
</div>
<?PHP
	}

	static public function adm_cfg_menu(): void {
		add_menu_page(
			'',
			'pbrberpf',
			'manage_options',
			'pbrberpf_config',
			__NAMESPACE__ . '\Admin::adm_cfg_menu_html',
			'adm_cfg_menu_html',
			'dashicons-admin-generic',
			100
		);
	}

	static public function adm_setsec() {
		echo "In adm_setsec";
	}

	static public function pbrberpf_field_hotelid_cb($args) {
		$hotelid = get_option('pbrberpf_hotelid', '');
?>
    Hotel ID: <input type="text" name="pbrberpf_hotelid" size="10" class="regular-text" value="<?PHP echo esc_attr($hotelid); ?>" /><br />
<?PHP
	}

	static public function pbrberpf_field_beurl_cb($args) {
		$beurl = get_option('pbrberpf_beurl', '');
?>
		Booking engine URL: <input type="text" name="pbrberpf_beurl" size="100"
			class="regular-text" value="<?PHP echo esc_attr($beurl); ?>" /><br />
<?PHP
	}

	static public function pbrberpf_field_pageaex_cb($args) {
			$pageaex = get_option('pbrberpf_page1ex', '');
?>
			Page 1 exclusions: <input type="text" name="pbrberpf_page1ex" size="100" class="regular-text" value="<?PHP echo esc_attr($pageaex); ?>" /> (See below for syntax.)<br />
<?PHP
	}

	static public function pbrberpf_field_pagebex_cb($args) {
			$pagebex = get_option('pbrberpf_page2ex', '');
?>
			Page 2 exclusions: <input type="text" name="pbrberpf_page2ex" size="100" class="regular-text" value="<?PHP echo esc_attr($pagebex); ?>" /> (See below for syntax.)<br />
<?PHP
	}

	static public function pbrberpf_field_cachetime_cb($args) {
			$cachetime = get_option('pbrberpf_cachetime', 1);
?>
			Cache time: <input type="text" name="pbrberpf_cachetime" size="100" class="regular-text" value="<?PHP echo esc_attr($cachetime); ?>" /><br />
<span id="pbrberpf_cache_explain">Set how many hours plugin should keep answers from booking engine cached. (Used in order to reduce possible calls to Booking Engine.)
<br />
<?PHP
	}

	static public function rsettings() {
		register_setting('pbrberpf', 'pbrberpf_hotelid');
		register_setting('pbrberpf', 'pbrberpf_beurl');
		register_setting('pbrberpf', 'pbrberpf_page1ex');
		register_setting('pbrberpf', 'pbrberpf_page2ex');
		register_setting('pbrberpf', 'pbrberpf_cachetime');

		add_settings_section('pbrberpf_settings', '', 
			__NAMESPACE__ . '\Admin::adm_setsec', 'pbrberpf');

		add_settings_field('pbrberpf_hotelid', __('Hotel ID', 'pbrberpf'), 
			__NAMESPACE__ . '\Admin::pbrberpf_field_hotelid_cb', 
			'pbrberpf', 'pbrberpf_settings',);
		add_settings_field('pbrberpf_beurl', __('Booking Engine URL', 
			'pbrberpf'), __NAMESPACE__ . '\Admin::pbrberpf_field_beurl_cb', 
			'pbrberpf', 'pbrberpf_settings',);
		add_settings_field('pbrberpf_page1ex', __('Page 1 exclusions', 
			'pbrberpf'), __NAMESPACE__ . '\Admin::pbrberpf_field_pageaex_cb', 
			'pbrberpf', 'pbrberpf_settings',);
		add_settings_field('pbrberpf_page2ex', __('Page 2 exclusions', 
			'pbrberpf'), __NAMESPACE__ . '\Admin::pbrberpf_field_pagebex_cb', 
			'pbrberpf', 'pbrberpf_settings',);
		add_settings_field('pbrberpf_cachetime', __('Cache Duration (hours)', 
			'pbrberpf'), __NAMESPACE__ . '\Admin::pbrberpf_field_cachetime_cb', 			'pbrberpf', 'pbrberpf_settings',);
	}
}
