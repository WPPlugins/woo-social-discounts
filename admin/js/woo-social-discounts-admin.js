jQuery(document).ready( function(){
    
    jQuery(".select_countries").select2({
      placeholder: "Select a country",
      allowClear: true,
      tags: true
    });

    jQuery(".coupon_code_select").select2();

});