<?php

if (!class_exists('resource_grid_Settings')) {
    class resource_grid_Settings
    {

        public static $options;

        public function __construct()
        {
            self::$options = get_option('resource_grid_options');
            add_action('admin_init', array($this, 'admin_init'));
        }

        public function admin_init()
        {

            register_setting('resource_grid_group', 'resource_grid_options', array($this, 'resource_grid_validate'));

            add_settings_section(
                'resource_grid_main_section',
                esc_html__('How does it work?', 'resources-grid-view'),
                null,
                'resource_grid_page1'
            );

            add_settings_section(
                'resource_grid_second_section',
                esc_html__('Other Plugin Options', 'resources-grid-view'),
                null,
                'resource_grid_page2'
            );

            add_settings_field(
                'resource_grid_shortcode',
                esc_html__('Shortcode', 'resources-grid-view'),
                array($this, 'resource_grid_shortcode_callback'),
                'resource_grid_page1',
                'resource_grid_main_section'
            );

            add_settings_field(
                'resource_grid_style',
                esc_html__('Slider Style', 'resources-grid-view'),
                array($this, 'resource_grid_style_callback'),
                'resource_grid_page2',
                'resource_grid_second_section',
                array(
                    'items' => array(
                        'style-1',
                        'style-2'
                    ),
                    'label_for' => 'resource_grid_style'
                )

            );
        }

        public function resource_grid_shortcode_callback()
        {
?>
            <span><?php esc_html_e('Use the shortcode [resource_grid] to display the slider in any page/post/widget', 'resources-grid-view'); ?></span>
        <?php
        }

        public function resource_grid_style_callback($args)
        {
        ?>
            <select id="resource_grid_style" name="resource_grid_options[resource_grid_style]">
                <?php
                foreach ($args['items'] as $item) :
                ?>
                    <option value="<?php echo esc_attr($item); ?>" <?php
                                                                        isset(self::$options['resource_grid_style']) ? selected($item, self::$options['resource_grid_style'], true) : '';
                                                                        ?>>
                        <?php echo esc_html(ucfirst($item)); ?>
                    </option>
                <?php endforeach; ?>
            </select>
<?php
        }

        public function resource_grid_validate($input)
        {
            $new_input = array();
            foreach ($input as $key => $value) {
                switch ($key) {
                    case 'resource_grid_title':
                        if (empty($value)) {
                            add_settings_error('resource_grid_options', 'resource_grid_message', esc_html__('The title field can not be left empty', 'resources-grid-view'), 'error');
                            $value = esc_html__('Please, type some text', 'resources-grid-view');
                        }
                        $new_input[$key] = sanitize_text_field($value);
                        break;
                    default:
                        $new_input[$key] = sanitize_text_field($value);
                        break;
                }
            }
            return $new_input;
        }
    }
}
