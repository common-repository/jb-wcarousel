<?php 
/*
Plugin Name: JB-wCarousel
Plugin URI: http://janbee-myjquery.pcriot.com/
Description: Carousel your widget
Version: 1.0
Author: JanBee Angeles
Author URI: http://janbee-myjquery.pcriot.com/
License: GPL2
*/          
error_reporting(E_ALL);  
add_action('widgets_init',  'carousel', 1);
add_action("widgets_init", array('Carousel', 'register'));    

register_activation_hook( __FILE__, array('Carousel', 'activate'));
register_deactivation_hook( __FILE__, array('Carousel', 'deactivate'));

function carousel(){
    if (function_exists('register_sidebar')){
        register_sidebar(array(
            'name' => 'wCarousel',
            'id' => 'bee_carousel',
            'description' => 'drop widget that you want to be Carouseled'
        ));
    }
}

class Carousel
{
    function activate(){
        $data = array( 
            'title' => '',
            'jq' => 'on'
        );
        if ( ! get_option('widget_wcarousel')){
            add_option('widget_wcarousel' , $data);
        } 
        else {
            update_option('widget_wcarousel' , $data);
        }
    }     
    function deactivate(){
        delete_option('widget_wcarousel');
    }
    
     
    function widget($args){
        global $wp_registered_widgets;       
        
        $data = get_option('widget_wcarousel'); 
        $jq = $data['jq'] == 'on' ? '<script type="text/javascript" src="wp-content/plugins/jb-wCarousel/js/jquery-1.4.2.min.js"></script>' : '';
        echo $args['before_widget'];  
        echo $args['before_title'] . $data['title'] . $args['after_title']; 
        echo $jq.'
            
            <script type="text/javascript" src="wp-content/plugins/jb-wCarousel/js/help.js"></script>
            <link rel="stylesheet" type="text/css" href="wp-content/plugins/jb-wCarousel/css/help.css"> 
            <ul id="wCarouselSource">';
            dynamic_sidebar('bee_carousel');    
        echo '</ul>
        <div id="wCarousel">
            <table>
                <tr>
                
                </tr>
            </table>
        </div>
        

        ';
        echo $args['after_widget'];     
    }

    function control_admin(){   
        $data = get_option('widget_wcarousel');
        $jqCheck = $data['jq'] == 'on' ? '<input class="" name="jqCheck" type="checkbox" checked />'
                                       : '<input class="" name="jqCheck" type="checkbox"  />';
       
        $html = '
        <div style="text-align:left">
            <label>Title:</label>
            <br>
            <input class="cPanel" name="title" type="text" value="'.$data['title'].'" />        

            <hr>
            <label>This plugin requires the latest jQuery framework if you have a jq already unchecked the checkbox </label><br>
            '.$jqCheck.'
            <hr>
            <div style="text-align:center">
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="DS7S93A63KDAG">
                <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
            </div>
        </div>
        
        ';
        echo $html; 
        if (!empty($_POST)){ 
            if(!empty($_POST['jqCheck'])) {
                $data['jq'] = attribute_escape($_POST['jqCheck']);
            }
            else{
                $data['jq'] = 'off';
            }
               
            $data['title'] = attribute_escape($_POST['title']);         
            update_option('widget_wcarousel', $data);  
        }
        
    }

    function register(){          
        register_sidebar_widget('JB-wCarousel', array('Carousel', 'widget'));
        register_widget_control('JB-wCarousel', array('Carousel', 'control_admin'));
    }
}

?>