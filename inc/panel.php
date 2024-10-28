<?php
class ACWP_SkiplinksAdminPanel {

    public function __construct() {

        // Register admin pages
        add_action( 'admin_menu', array(&$this, 'register_pages') );

        // Register settings
        add_action( 'admin_init', array(&$this, 'register_settings') );
        add_action( 'rest_api_init', array(&$this, 'register_settings') );
    }

    public function register_pages() {

        // Check if we already got the primary page of AccessibleWP if not we will add it
        if ( empty ($GLOBALS['admin_page_hooks']['accessible-wp'] ) ) {
            add_menu_page(
                'AccessibleWP', 
                'AccessibleWP', 
                'read', 
                'accessible-wp', 
                array($this, 'main_page_callback'), 
                plugins_url( 'accessible-wp-toolbar/assets/svg/accessible.svg', __FILE__ ), 
                '2.1');
        }

        // Add our sub page
        add_submenu_page('accessible-wp', __('AccessibleWP Skiplinks', 'accessiblewp-skiplinks'), 'Skiplinks', 'manage_options', 'accessiblewp-skiplinks', array(&$this, 'submenu_page_callback'));
    }

    public function register_settings(){
        register_setting('accessiblewp-skiplinks', 'acwp_skiplinks', array('show_in_rest' => true));
        register_setting('accessiblewp-skiplinks', 'acwp_skiplinks_header_label', array('show_in_rest' => true));
        register_setting('accessiblewp-skiplinks', 'acwp_skiplinks_header_id', array('show_in_rest' => true));
        register_setting('accessiblewp-skiplinks', 'acwp_skiplinks_content_label', array('show_in_rest' => true));
        register_setting('accessiblewp-skiplinks', 'acwp_skiplinks_content_id', array('show_in_rest' => true));
        register_setting('accessiblewp-skiplinks', 'acwp_skiplinks_footer_label', array('show_in_rest' => true));
        register_setting('accessiblewp-skiplinks', 'acwp_skiplinks_footer_id', array('show_in_rest' => true));
        register_setting('accessiblewp-skiplinks', 'acwp_skiplinks_noanimation', array('show_in_rest' => true));
        register_setting('accessiblewp-skiplinks', 'acwp_skiplinks_bg', array('show_in_rest' => true));
        register_setting('accessiblewp-skiplinks', 'acwp_skiplinks_txt', array('show_in_rest' => true));
        register_setting('accessiblewp-skiplinks', 'acwp_skiplinks_body_open', array('show_in_rest' => true));
        register_setting('accessiblewp-skiplinks', 'acwp_skiplinks_nometa', array('show_in_rest' => true));
        register_setting('accessiblewp-skiplinks', 'acwp_skiplinks_noshadows', array('show_in_rest' => true));
        register_setting('accessiblewp-skiplinks', 'acwp_skiplinks_turnsides', array('show_in_rest' => true));

    }

    public function main_page_callback() {
        ?>
        <div class="wrap">
            <div id="welcome-panel" class="welcome-panel welcome-panel-accessiblewp">
                <div class="welcome-panel-header">
                    <div class="welcome-content">
                        <h1><?php _e('Welcome to <span>AccessibleWP</span> Dashboard!', 'accessiblewp-skiplinks');?></h1>
                        <p class="about-description"><?php _e('Accessibility solutions for websites based on the WordPress.', 'accessiblewp-skiplinks');?></p>
                        <nav>
                            <a class="button button-primary button-hero load-customize hide-if-no-customize" href="<?php echo admin_url('/admin.php?page=accessiblewp-toolbar');?>"><?php _e('Toolbar Settings', 'accessiblewp-skiplinks');?></a>
                        </nav>
                        <hr />
                        <p><a href="https://www.codenroll.co.il/" target="_blank"><?php _e('Who We Are?', 'accessiblewp-skiplinks'); ?></a> | <a href="https://www.amitmoreno.com/" target="_blank"><?php _e('About The Author', 'accessiblewp-skiplinks'); ?></a> | <a href="https://www.w3.org/WAI/standards-guidelines/" target="_blank"><?php _e('W3C Accessibility Standards Overview', 'accessiblewp-skiplinks'); ?></a></p>
                
                    </div>
                    <div class="welcome-feedback">
                        <h2><?php _e('Send Feedback', 'accessiblewp-skiplinks');?></h2>
                        <p><a href="https://www.codenroll.co.il/contact" target="_blank">Leave a message</a></p>
                        <p>Email: <a href="mailto:a@Codenroll.co.il">a@Codenroll.co.il</a></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function submenu_tab_mainlinks() {
        ?>
        <div id="acwp_skiplinks_main" class="acwp-tab">
            <h2><?php _e('Options', 'accessiblewp-skiplinks');?></h2>
            <table class="form-table">
            	<tr valign="top">
                    <th scope="row"><?php _e("Activate the skiplinks", 'accessiblewp-skiplinks');?></th>
                    <td><input type="checkbox" name="acwp_skiplinks" value="yes" <?php checked( esc_attr( get_option('acwp_skiplinks') ), 'yes' ); ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="acwp_skiplinks_turnsides"><?php _e("Turn sides over", 'accessiblewp-skiplinks');?></label>
                    </th>
                    <td>
                        <input type="checkbox" name="acwp_skiplinks_turnsides" value="yes" <?php checked( esc_attr( get_option('acwp_skiplinks_turnsides') ), 'yes' ); ?> />
                        <p><?php _e('The default state of the skiplinks is that in LTR mode they appear on the left side and in RTL mode they appear on the right side. If you check this checkbox, the skiplinks will be displayed on opposite sides.', 'accessiblewp-skiplinks');?></p>
                    </td>
                </tr>
                <tr>
                	<td colspan="2">
                		<hr />
                	</td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="acwp_skiplinks_header_label"><?php _e('Header link label', 'accessiblewp-skiplinks');?></label>
                    </th>
                    <td>
                        <input type="text" id="acwp_skiplinks_header_label" name="acwp_skiplinks_header_label" value="<?php echo esc_attr( get_option('acwp_skiplinks_header_label') ); ?>" placeholder="<?php _e('Header', 'accessiblewp-skiplinks');?>" />
                        <p><?php _e('Set the label of your header link.', 'accessiblewp-skiplinks');?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="acwp_skiplinks_header_id"><?php _e('Header link ID', 'accessiblewp-skiplinks');?></label>
                    </th>
                    <td>
                        <input type="text" id="acwp_skiplinks_header_id" name="acwp_skiplinks_header_id" value="<?php echo esc_attr( get_option('acwp_skiplinks_header_id') ); ?>" placeholder="header" />
                        <p><?php _e('Set the ID of your header HTML tag in a CSS format. For example:', 'accessiblewp-skiplinks');?> #header</p>
                    </td>
                </tr>
                <tr>
                	<td colspan="2">
                		<hr />
                	</td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="acwp_skiplinks_content_label"><?php _e('Content link label', 'accessiblewp-skiplinks');?></label>
                    </th>
                    <td>
                        <input type="text" id="acwp_skiplinks_content_label" name="acwp_skiplinks_content_label" value="<?php echo esc_attr( get_option('acwp_skiplinks_content_label') ); ?>" placeholder="<?php _e('Page Content', 'accessiblewp-skiplinks');?>" />
                        <p><?php _e('Set the label of your content link.', 'accessiblewp-skiplinks');?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="acwp_skiplinks_content_id"><?php _e('Content ID', 'accessiblewp-skiplinks');?></label>
                    </th>
                    <td>
                        <input type="text" id="acwp_skiplinks_content_id" name="acwp_skiplinks_content_id" value="<?php echo esc_attr( get_option('acwp_skiplinks_content_id') ); ?>" placeholder="page" />
                        <p><?php _e('Set the ID of the HTML tag of your main content area in a CSS format. For example:', 'accessiblewp-skiplinks');?> #page</p>
                    </td>
                </tr>
                <tr>
                	<td colspan="2">
                		<hr />
                	</td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="acwp_skiplinks_footer_label"><?php _e('Footer link label', 'accessiblewp-skiplinks');?></label>
                    </th>
                    <td>
                        <input type="text" id="acwp_skiplinks_footer_label" name="acwp_skiplinks_footer_label" value="<?php echo esc_attr( get_option('acwp_skiplinks_footer_label') ); ?>" placeholder="<?php _e('Footer', 'accessiblewp-skiplinks');?>" />
                        <p><?php _e('Set the label of your footer link.', 'accessiblewp-skiplinks');?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="acwp_skiplinks_footer_id"><?php _e('Footer ID', 'accessiblewp-skiplinks');?></label>
                    </th>
                    <td>
                        <input type="text" id="acwp_skiplinks_footer_id" name="acwp_skiplinks_footer_id" value="<?php echo esc_attr( get_option('acwp_skiplinks_footer_id') ); ?>" placeholder="footer" />
                        <p><?php _e('Set the ID of your footer HTML tag in a CSS format. For example:', 'accessiblewp-skiplinks');?> #footer</p>
                    </td>
                </tr>
            </table>
        </div>
        <?php
    }
    
    public function submenu_tab_info() {
        ?>
        <div id="acwp_info" class="acwp-tab active">
            <h2><?php _e('How To Use?', 'accessiblewp-skiplinks');?></h2>
            <p><?php _e('This screen describes what the skiplinks are and how to use them.', 'accessiblewp-skiplinks'); ?></p>
            <hr />
            <h3><?php _e('What are skiplinks?', 'accessiblewp-skiplinks'); ?></h3>
            <p><?php _e('Skiplinks allow the user to skip between the page sections using the keyboard (usually using the TAB key). These skiplinks are not visible in the interface but are accessible via the keyboard and appear on the screen only when they are in focus mode.', 'accessiblewp-skiplinks'); ?></p>
            <h3><?php _e('How to use the skiplinks?', 'accessiblewp-skiplinks'); ?></h3>
            <p><?php _e('To activate the skiplinks properly there are several steps that need to be done', 'accessiblewp-skiplinks');?>:</p>
            <ol>
                <li><?php _e('First, activate the skiplinks to appear on the front-end by checking the checkbox on the "Options" screen next to the label: "Activate the skiplinks".', 'accessiblewp-skiplinks'); ?></li>
                <li><?php _e('Now the permanent sections must be defined, those that appear on all your website pages (header, footer and page content). You can set this under the "Options" screen. Defining the skiplinks is done by setting the ID of that section and a very short description. For example if the ID of our header is \'header\' we will define the ID of the section like this: <b>header</b> (without the # at the beginning), and in the label field we can write "Header".', 'accessiblewp-skiplinks'); ?></li>
                <li><?php _e('Once the permanent sections have been defined, it is possible to define more skiplinks for each page to its own unique sections. These skiplinks will only appear on that specific page. You can do this through the meta box found on each page edit in the same way we defined the permanent skiplinks (section ID and label).', 'accessiblewp-skiplinks'); ?></li>
                <li><?php _e('You can check the skiplinks you created by navigating the page using the TAB button on your keyboard.', 'accessiblewp-skiplinks'); ?></li>
            </ol>
        </div>
        <?php
    }
    
    public function submenu_tab_style(){
        ?>
        <div id="acwp_style" class="acwp-tab">
            <h2><?php _e('Style', 'accessiblewp-skiplinks');?></h2>

            <table class="form-table">
            	<tr valign="top">
                    <th scope="row"><?php _e("Disable skiplinks animation", 'accessiblewp-skiplinks');?></th>
                    <td><input type="checkbox" name="acwp_skiplinks_noanimation" value="yes" <?php checked( esc_attr( get_option('acwp_skiplinks_noanimation') ), 'yes' ); ?> /></td>
                </tr>
                
                <tr valign="top">
                    <th scope="row"><?php _e("Disable skiplinks shadows", 'accessiblewp-skiplinks');?></th>
                    <td><input type="checkbox" name="acwp_skiplinks_noshadows" value="yes" <?php checked( esc_attr( get_option('acwp_skiplinks_noshadows') ), 'yes' ); ?> /></td>
                </tr>
                
                <tr valign="top">
                    <th scope="row"><?php _e('Custom background color', 'accessiblewp-skiplinks');?></th>
                    <td><input type="color" name="acwp_skiplinks_bg" class="color-field" value="<?php echo esc_attr( get_option('acwp_skiplinks_bg') ); ?>" data-default-color="#3c8dbc" />
                    	<small><?php echo esc_attr( get_option('acwp_skiplinks_bg') ); ?></small>
                    </td>
                </tr>
                
                <tr valign="top">
                    <th scope="row"><?php _e('Custom text color', 'accessiblewp-skiplinks');?></th>
                    <td><input type="color" name="acwp_skiplinks_txt" class="color-field" value="<?php echo esc_attr( get_option('acwp_skiplinks_txt') ); ?>" data-default-color="#fff" />
                    	<small><?php echo esc_attr( get_option('acwp_skiplinks_txt') ); ?></small>
                    </td>
                </tr>
                
            </table>
        </div>
        <?php
    }
    
    public function submenu_tab_additional(){
        ?>
        <div id="acwp_skiplinks_additional" class="acwp-tab">
            <h2><?php _e('Settings', 'accessiblewp-skiplinks');?></h2>

            <table class="form-table">
                
                <tr valign="top">
                    <th scope="row"><?php _e("My theme support 'wp_body_open' (recommended)", 'accessiblewp-skiplinks');?></th>
                    <td><input type="checkbox" name="acwp_skiplinks_body_open" value="yes" <?php checked( esc_attr( get_option('acwp_skiplinks_body_open') ), 'yes' ); ?> /></td>
                </tr>
                
                <tr valign="top">
                    <th scope="row"><?php _e("Disable additional skiplinks from page meta", 'accessiblewp-skiplinks');?></th>
                    <td><input type="checkbox" name="acwp_skiplinks_nometa" value="yes" <?php checked( esc_attr( get_option('acwp_skiplinks_nometa') ), 'yes' ); ?> /></td>
                </tr>
                
            </table>
        </div>
        <?php
    }
    
    public function submenu_page_callback() {
        ?>
        <div id="accessible-wp-skiplinks" class="wrap">
            <h1><?php _e('AccessibleWP Skiplinks', 'accessiblewp-skiplinks');?></h1>
            <form method="post" action="options.php">
                <?php settings_fields( 'accessiblewp-skiplinks' ); ?>
                <?php do_settings_sections( 'accessiblewp-skiplinks' ); ?>

                <div class="nav-tab-wrapper">
                    <a href="#acwp_info" class="nav-tab nav-tab-active"><?php _e('How To Use?', 'accessiblewp-skiplinks');?></a>
                    <a href="#acwp_skiplinks_main" class="nav-tab"><?php _e('Options', 'accessiblewp-skiplinks');?></a>
                    <a href="#acwp_style" class="nav-tab"><?php _e('Style', 'accessiblewp-skiplinks');?></a>
                    <a href="#acwp_skiplinks_additional" class="nav-tab"><?php _e('Settings', 'accessiblewp-skiplinks');?></a>
                </div>
                <?php
                echo $this->submenu_tab_info();
                echo $this->submenu_tab_mainlinks();
                echo $this->submenu_tab_additional();
                echo $this->submenu_tab_style();
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}
if( is_admin() )
    new ACWP_SkiplinksAdminPanel();