<?php
if (function_exists('register_sidebar'))
    register_sidebar();
?>

<?php
class widget_test extends WP_Widget {
    function widget_test() {
        $widget_ops = array('description' => '小工具的描述信息');
        $this->WP_Widget('widget_test', '自定义小工具的标题', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', esc_attr($instance['title']));
        $limit = strip_tags($instance['limit']);
        echo $before_widget.$before_title.$title.$after_title;
        echo '<ul class="middleli">';
            test( $limit );    //小工具需要执行的函数
        echo '</ul>';
        echo $after_widget;
    }
    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['limit'] = strip_tags($new_instance['limit']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('title' => '', 'limit' => ''));
        $title = esc_attr($instance['title']);
        $limit = strip_tags($instance['limit']);
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>">数量：<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
        </p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
    }
}
add_action('widgets_init', 'widget_test_init');
function widget_test_init() {
    register_widget('widget_test');
}
?>

<?php
function mb_hot() { include(TEMPLATEPATH . '/hot.php'); }  
if( function_exists( 'register_sidebar_widget' ) ) {   
    register_sidebar_widget('自定义热门文章','mb_hot');   
}  
?>
