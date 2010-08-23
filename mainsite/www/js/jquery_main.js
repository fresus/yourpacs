        jQuery.fn.corners = function(options) {        
            var settings = {
                tr: { radius: 15 },
                br: { radius: 15 },
                tl: { radius: 15 },
                bl: { radius: 15 },
                antiAlias: true,
                autoPad: true,
                validTags: ["div"] };
            if ( options && typeof(options) != 'string' )
                jQuery.extend(settings, options);

            return this.each(function() {
                new curvyObject(settings,this).applyCorners();
            });   
        };
        jQuery.fn.smallcorners = function(options) {        
            var settings = {
                tr: { radius: 1 },
                br: { radius: 1 },
                tl: { radius: 1 },
                bl: { radius: 1 },
                antiAlias: true,
                autoPad: true,
                validTags: ["div"] };
            if ( options && typeof(options) != 'string' )
                jQuery.extend(settings, options);

            return this.each(function() {
                new curvyObject(settings,this).applyCorners();
            });   
        };

        $(document).ready(function(){
            $(".bradius").corners();
        });
