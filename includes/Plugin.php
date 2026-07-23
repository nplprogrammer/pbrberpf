<?PHP

namespace Pbr\Berpf;

class Plugin {
	protected static ?self $instance = null;
	protected ?string $entry_point = null;

	public static function get_instance(): self {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	protected static function display(): string {
        	return '<p> HELLO BIG MAN</p>';
	}

	static function adm_cfg_menu_html() {
?>
<h3>pbrberpf: PBR Booking Engine Result Pre-Filter</h3>
<div class="">
	<form method="post" action="options.php">
	Booking engine URL: <input type="text" name="srcurl" size="100" /><br />
	<input type="submit" value="Save" />
</div>
<?PHP
	}

	protected static function adm_cfg_menu(): void {
		add_menu_page(
			'pbrberpf config',
			'pbrberpf',
			'manage_options',
			'pbrberpf_config',
			__NAMESPACE__ . '\Plugin::adm_cfg_menu_html',
			'adm_cfg_menu_html',
			'dashicons-admin-generic',
			100
		);
	}

	protected static function rsettings() {
		register_setting('Filters', 'cfg-filters');
		add_settings_section('filter-a', 'Filter A',
			'section_filter_a', 'my-plugin');
		add_settings_sectioN('filter-b', 'Filter B',
			'section_filter_b', 'my-plugin');

		register_setting('my_settings_group',
				'my_option_name',
			[
				'type' => 'string',
				'sanitize_callback' => 'sanitize_text_field',
				'default' => ''
			]
		);
	}
	public static function run(string $entry_point): self {
		add_shortcode('pbrberf_display', function (): string {
			 return self::display(); });
		add_action('admin_menu',  function () { 
				return self::adm_cfg_menu(); });
		add_action('admin_init', function () { self::rsettings(); });

		$plugin = self::get_instance();

		$plugin->entry_point = $entry_point;

		register_activation_hook($entry_point, function () {
			self::activate();
		});

		register_deactivation_hook($entry_point, function() {
			self::deactivate();
		});

		return $plugin;
	}

	protected static function activate(): void {
		flush_rewrite_rules();
	}

	protected static function deactivate(): void {
		flush_rewrite_rules();
	}
}
