<?php
/**
 * Handles logic for the admin settings page.
 *
 * @since 1.0.0
 */
final class VNF {

	/**
	 * The single instance of the class.
	 *
	 * @var Trust_Order_Notifications
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * Main Trust_Order_Notifications Instance.
	 *
	 * Ensures only one instance of Trust_Order_Notifications is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @return Trust_Order_Notifications - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init_hooks' ] );
	}

	/**
	 * Adds the admin menu
	 * the plugin's admin settings page.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function init_hooks() {
		add_action( 'admin_menu', [ $this, 'menu' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'wp_footer', array( $this, 'frontend' ) );
		add_filter( 'admin_footer_text', [ $this, 'admin_footer_text' ], 500 );
		add_action( 'admin_enqueue_scripts', [ $this, 'vnf_color_picker' ]);
		if ( isset( $_REQUEST['page'] ) && 'trusted-order-notifications' == $_REQUEST['page'] ) {
			// Only admins can save settings.
			if ( ! current_user_can('manage_options') ) {
				return;
			}

			$this->save();
		}
	}
	
	
	public function vnf_color_picker( $hook_suffix ) {
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script('wp-color-picker');
	}
	/**
	 * Registers Widget.
	 */
	
	public function enqueue_scripts() {
		wp_enqueue_style( 'vnf-style', VNF_ASSETS_URL . 'css/vnfaster-order.min.css', array(), VNF_VERSION );
		wp_enqueue_script( 'vnf-js',  VNF_ASSETS_URL . 'js/vnfaster-order.min.js', array(), VNF_VERSION );
	}

	/**
	 * Renders the admin settings menu.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function menu() {
		if ( is_main_site() || ! is_multisite() ) {
			if ( current_user_can( 'manage_options' ) ) {

				$title    = esc_html__( 'Order Notifications', 'trusted-order-notifications' );
				$cap      = 'manage_options';
				$slug     = 'trusted-order-notifications';
				$func     = [ $this, 'backend' ];
				$icon     = 'dashicons-testimonial';
				$position = 500;

				add_menu_page( $title, $title, $cap, $slug, $func, $icon, $position );
			}
		}
	}

	/**
	 * Get settings data.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function data() {
		$defaults = array(
			'timenext'       => '',
			'customer'       => '',
			'color' => '',
			'position'       => '',
			'thankyou' => ''
		);

		$data = $this->option( 'vnf_options', true );

		if ( ! is_array( $data ) || empty( $data ) ) {
			return $defaults;
		}

		if ( is_array( $data ) && ! empty( $data ) ) {
			return wp_parse_args( $data, $defaults );
		}
	}

	/**
	 * Renders the update message.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function message() {
		if ( ! empty( $_POST ) ) {
			echo '<div class="updated"><p>' . esc_html__( 'Settings updated!', 'trusted-order-notifications' ) . '</p></div>';
		}
	}

	/**
	 * Admin html form setting.
	 *
	 * @return [type] [description]
	 */
	public function backend() {
		include VNF_PATH . 'includes/options-dashboard.php';
	}

	/**
	 * Trusted Order Notifications front-end template.
	 * @return [type] [description]
	 */
	public function frontend() {
		$data = $this->data();
		
		$timenext = '10000';
		$position = 'bottom-right';
		$customer ='Cristiano Ronaldo|096 352 xxx|1 minute ago' . PHP_EOL .
		'Lionel Messi|098 8765 xxx|5 minutes ago';
		$color ='#009611';
		$thankyou = 'Thank You,';
		$orderss = 'Order Successful!';
		$onmobile = '';
		if ( ! empty( $data['timenext'] ) ) {
			$timenext = $data['timenext'];
		}
		if ( ! empty( $data['position'] ) ) {
			$position = $data['position'];
		}
		if ( ! empty( $data['customer'] ) ) {
			$customer = $data['customer'];
		}
		if ( ! empty( $data['color'] ) ) {
			$color = $data['color'];
		}
		if ( ! empty( $data['thankyou'] ) ) {
			$thankyou = $data['thankyou'];
		}
		if ( ! empty( $data['orderss'] ) ) {
			$orderss = $data['orderss'];
		}
		if ( ! empty( $data['onmobile'] ) ) {
			$onmobile = $data['onmobile'];
		}
		$listcustomer = explode(PHP_EOL, $customer);
		?>
		
	<script>
    $('document').ready(function(){
        var ran = 1000;
        <?php if($onmobile == ''){ if (wp_is_mobile()) {}else{ ?>
					showTo(ran);
					setInterval(function(){
						var ran = Math.floor((Math.random() * 10000));
						showTo(ran);
					}, <?php echo $timenext; ?>);
				<?php } } else{ ?>
					showTo(ran);
					setInterval(function(){
						var ran = Math.floor((Math.random() * 10000));
						showTo(ran);
					}, <?php echo $timenext; ?>);
		<?php } ?>

    });
    function showTo(ran) {
        setTimeout(function(){
            vnfaster.options.positionClass  = 'vnfasterfn-<?php echo $position; ?>';
            vnfaster.options.showDuration  = 300;
            vnfaster.options.hideDuration  = 300;
            vnfaster.options.timeOut  = 5000;
			var phones = [];
			<?php
			
			foreach ($listcustomer as $phonevnf){
				$sdt = explode('|', $phonevnf);	
			?>
			phones.push("<?php echo $sdt[1]; ?>"); 
			<?php } ?>
			
			var names = [];
			<?php
			foreach ($listcustomer as $namevnf){
				$ten = explode('|', $namevnf);	
			?>
			names.push("<?php echo $ten[0]; ?>"); 
			<?php } ?>
			
			var times = [];
			<?php
			foreach ($listcustomer as $timevnf){
				$thoigian = explode('|', $timevnf);	
			?>
			times.push("<?php echo preg_replace("/[\n\r]/","",$thoigian[2]); ?>");
			<?php } ?>
			
            var phone = phones[Math.floor(Math.random()*phones.length)];
            var name = names[Math.floor(Math.random()*names.length)];
			var time = times[Math.floor(Math.random()*times.length)];
			
            title = '<?php echo $thankyou; ?> ' + name;
            var msg = phone + ' <?php echo $orderss; ?> <br/> ' + time;
            vnfaster.success(msg, title);
        }, ran);
    }
</script>
<style type="text/css">
.vnfasterfn-success{
	background-color: <?php echo $color; ?>!important;
}
</style>
	  
	<?php
	}

	/**
	 * Renders the action for a form.
	 *
	 * @since 1.0.0
	 * @param string $type The type of form being rendered.
	 * @return void
	 */
	public function form_action( $type = '' ) {
		return admin_url( '/admin.php?page=trusted-order-notifications' . $type );
	}

	/**
	 * Returns an option from the database for
	 * the admin settings page.
	 *
	 * @since 1.0.0
	 * @param string $key The option key.
	 * @return mixed
	 */
	public function option( $key, $network_override = true ) {
		if ( is_network_admin() ) {
			$value = get_site_option( $key );
		}
			elseif ( ! $network_override && is_multisite() ) {
				$value = get_site_option( $key );
			}
			elseif ( $network_override && is_multisite() ) {
				$value = get_option( $key );
				$value = ( false === $value || ( is_array( $value ) && in_array( 'disabled', $value ) ) ) ? get_site_option( $key ) : $value;
			}
			else {
			$value = get_option( $key );
		}

		return $value;
	}

	/**
	 * Saves settings.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 */
	private function save() {
		if ( ! isset( $_POST['vnf-settings-nonce'] ) || ! wp_verify_nonce( $_POST['vnf-settings-nonce'], 'vnf-settings' ) ) {
			return;
		}

		$data = $this->data();

		$data['timenext'] = isset( $_POST['vnf_options']['timenext'] ) ? sanitize_text_field( $_POST['vnf_options']['timenext'] ) : '';
		$data['customer'] = isset( $_POST['vnf_options']['customer'] ) ?  $_POST['vnf_options']['customer']  : '';
		$data['position'] = isset( $_POST['vnf_options']['position'] ) ? sanitize_text_field( $_POST['vnf_options']['position'] ) : '';
		$data['color'] = isset( $_POST['vnf_options']['color'] ) ? sanitize_text_field( $_POST['vnf_options']['color'] ) : '';
		$data['thankyou'] = isset( $_POST['vnf_options']['thankyou'] ) ? sanitize_text_field( $_POST['vnf_options']['thankyou'] ) : '';
		$data['orderss'] = isset( $_POST['vnf_options']['orderss'] ) ? sanitize_text_field( $_POST['vnf_options']['orderss'] ) : '';
		$data['onmobile'] = isset( $_POST['vnf_options']['onmobile'] ) ? sanitize_text_field( $_POST['vnf_options']['onmobile'] ) : '';
		
		update_site_option( 'vnf_options', $data );
	
	}

	/**
	 * Admin footer text.
	 *
	 * Modifies the "Thank you" text displayed in the admin footer.
	 *
	 * Fired by `admin_footer_text` filter.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $footer_text The content that will be printed.
	 *
	 * @return string The content that will be printed.
	 */
	public function admin_footer_text( $footer_text ) {
		$current_screen = get_current_screen();
		$is_screen = ( $current_screen && false !== strpos( $current_screen->id, 'trusted-order-notifications' ) );

		if ( $is_screen ) {
			$footer_text = __( 'Enjoyed <strong>Trusted Order Notifications</strong>? Please leave us a <a href="https://vnfaster.com/" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating. We really appreciate your support!', 'trusted-order-notifications' );
		}

		return $footer_text;
	}
}
