<?php
/**
 * Administration page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php settings_fields( 'woo_social_discounts_group' ); ?>
        <h3><?php _e( 'Woo Social Discounts Settings', 'woo-social-discounts' ); ?></h3>
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row"><label for="woo_social_discounts_message">Share Message</label></th>
                        <td><input type="text" class="input-text regular-input" size="70" value="<?php echo $settings['message']; ?>" id="woo_social_discounts_message" name="woo_social_discounts[message]" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="woo_social_discounts_network">Choose Social Networks</label></th>
                        <td>
                            <p>
                                <input type="checkbox" name="woo_social_discounts[social_shares][facebook]" id="woo_social_discounts_fb" value="1" <?php echo isset($settings['social_shares']['facebook'])? 'checked="checked"': ''; ?>/>Facebook&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" name="woo_social_discounts[social_shares][twitter]" id="woo_social_discounts_twitter" value="1"<?php echo isset($settings['social_shares']['twitter'])? 'checked="checked"': ''; ?>/>Twitter&nbsp;&nbsp;&nbsp;
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="woo_social_discounts_coupon">Choose Coupon</label></th>
                        <td>
                            <p>
                                <select class="coupon_code_select" name="woo_social_discounts[coupon_code]" size="1" style="width: 60%">
                                   <?php 
                                   
                                        foreach ($coupon_objects_array as $coupon_object) {
                                            
                                            if(isset($settings['coupon_code']) && $coupon_object->post_title == $settings['coupon_code']) {
                                                
                                            echo '<option selected="selected" value="' .$coupon_object->post_title. '">'.$coupon_object->post_title. '</option>';
                                                
                                            } else {
                                                
                                            echo '<option value="' .$coupon_object->post_title. '">'.$coupon_object->post_title. '</option>';
                                                
                                            }

                                        }
                                   
                                   ?>
                               </select>
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="woo_social_discounts_countries">Choose Countries</label></th>
                        <td>
                            <p>
                                <select class="select_countries" name="woo_social_discounts_allowed_countries[]" multiple="multiple" style="width: 60%">
                                    
                                    <?php 
                                    
                                        foreach ($woo_social_discounts_countries as $country=>$value) {
                                            
                                            $selected = in_array($country, $woo_social_discounts_allowed_countries) ? 'selected="selected"' : '';
                                                
                                            echo '<option '.$selected.' value="'.$country.'">'.$value. '</option>';
                                          
                                        }
                                    ?>  
                                    
                                </select>                            
                            </p>
                            <p>NB: Please note that this feature requires the <a target="_blank" href="https://wordpress.org/plugins/geoip-detect/">GEOIP Detection</a> plugin to be installed.</p>
                        </td>
                    </tr>                    
                </tbody>
            </table>
            <?php submit_button(); ?>
    </form>
</div>
