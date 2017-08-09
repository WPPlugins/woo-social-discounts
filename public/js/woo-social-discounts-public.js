    jQuery(document).ready(function($) {

        WSDSharing = {

            total_counts: {

                "facebook": 0, "twitter": 0, 
            },

            setCookie: function (name, value) {

                var cookie = name + "=" + encodeURIComponent(value);

                 document.cookie = cookie + "; path=/";

            },
            
            
            http: function() {
                
                if ( 'https:' === window.location.protocol ) {
                    
                    return 'https:';
                    
                } else {
                    
                    return 'http:';
                    
                }
                
            },            

            facebook_compare_shares: function () {

                var location = window.location.href;

                var initial_count = WSDSharing.total_counts.facebook;
                
                var protocol = this.http();

                jQuery.getJSON(protocol+'//graph.facebook.com/?id='+location+'&callback=?', function (data) {

                    if(data.shares > initial_count){

                        WSDSharing.setCookie('wsd_cookie', 'true', 0);

                        jQuery('.wsd-sharing').replaceWith("<div><p>Thanks for sharing! Your discount will be applied at checkout.</p></div>");

                        clearInterval(InIntervId);

                    }

                });
            },


            twitter_compare_shares: function () {

                var location = window.location.href;

                var initial_count = WSDSharing.total_counts.twitter;
                
                var protocol = this.http();

                jQuery.getJSON(protocol+'//cdn.api.twitter.com/1/urls/count.json?url='+location+'&callback=?', function (data) {


                    if(data.count > initial_count){

                         WSDSharing.setCookie('wsd_cookie', 'true', 0);

                        jQuery('.wsd-sharing').replaceWith("<div><p>Thanks for sharing! Your discount will be applied at checkout.</p></div>");

                        clearInterval(InIntervId);

                    }

                });
            }

        };
        
        var protocol = WSDSharing.http();

        jQuery.getJSON(protocol+'//graph.facebook.com/?id='+location+'&callback=?', function (data) {

            if(data.shares && WSDSharing.total_counts){

                WSDSharing.total_counts.facebook = data.shares;

            } 

        });

        jQuery.getJSON(protocol+'//cdn.api.twitter.com/1/urls/count.json?url='+location+'&callback=?', function (data) {

            if(data.count && WSDSharing.total_counts){

                WSDSharing.total_counts.twitter = data.count;

            } 

        });

}); 