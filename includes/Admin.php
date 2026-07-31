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
			do_settings_sections('pbrberpf');
		//	do_settings_sections('pbrberpf_settings');
		//	do_settings_fields('pbrberpf', 'pbrberpf_settings');
?>
<br /><br />
	Booking engine URL: <input type="text" name="srcurl" class="regular-text" 
	size="100" value="<?PHP 
//	echo esc_attr($option['beurl']);
?>"/><br /><br />
	Page 1 exclusions: <input type="text" name="sexa" class="regular-text"
	size="100" value="<?PHP
	//echo esc_attr($option['page1ex']);
	?>" /><br /><br />
	Page 2 exclusions: <input type="text" name="sexb" class="regular-text"
	size="100" value="<?PHP
	//echo esc_attr($option['page2ex']);
	?>" /><br />
<br />
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
	static public function pbrberpf_field_pill_cb($args) {
		$options = get_option('pbrberpf_opt');
		var_dump($args);
		var_dump($options);
?>
    Hotel ID: <input type="text" name="hotelid" size="10" class="regular-text" value="<?PHP
	echo esc_attr($options['hotelid']);
?>" /><br />	
<?PHP
	}
	static public function rsettings() {
		register_setting('pbrberpf', 'pbrberpf_options');
		add_settings_section('pbrberpf_settings',
			'', 
			__NAMESPACE__ . '\Admin::adm_setsec',
			'pbrberpf');
		add_settings_field('pbrberpf_opt',
			__('Option', 'pbrberpf'),
			__NAMESPACE__ . '\Admin::pbrberpf_field_pill_cb',
			'pbrberpf', 'pbrberpf_settings',
		);
	}
/*
		register_setting('pbrberpf_options',
				'pbrberpf_opt',
			[
				'type' => 'array',
				'default' => ''
			]
		);
	}
*/
}
