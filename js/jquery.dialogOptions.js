/*
 * jQuery UI dialogOptions v1.0
 * @desc extending jQuery Ui Dialog - Responsive, click outside, class handling
 * @author Jason Day
 *
 * Dependencies:
 *		jQuery: http://jquery.com/
 *		jQuery UI: http://jqueryui.com/
 *		Modernizr: http://modernizr.com/    Modernizr adds feature detection. dialogOptions optionally checks for html.touch for scrolling
 *
 * MIT license:
 *              http://www.opensource.org/licenses/mit-license.php
 *
 * (c) Jason Day 2014
 *
 * New Options:
 *  clickOut: true          // closes dialog when clicked outside
 *  responsive: true        // fluid width & height based on viewport
 *                          // true: always responsive
 *                          // false: never responsive
 *                          // "touch": only responsive on touch device
 *  scaleH: 0.8             // responsive scale height percentage, 0.8 = 80% of viewport
 *  scaleW: 0.8             // responsive scale width percentage, 0.8 = 80% of viewport
 *  showTitleBar: true      // false: hide titlebar
 *  showCloseButton: true   // false: hide close button
 *
 * Added functionality:
 *  add & remove dialogClass to #ui-widget-overlay for scoping styles
 *	patch for: http://bugs.jqueryui.com/ticket/4671
 *	recenter dialog - ajax loaded content
 */

// add new options with default values
$.ui.dialog.prototype.options.clickOut = false;
$.ui.dialog.prototype.options.responsive = true;
$.ui.dialog.prototype.options.setHeight_kelle = false;//emre magassűg űllítás máhogy
$.ui.dialog.prototype.options.scaleH = 1;/*0.8*/
$.ui.dialog.prototype.options.scaleW = 0.95;/*0.8*/
$.ui.dialog.prototype.options.showTitleBar = true;
$.ui.dialog.prototype.options.showCloseButton = true;


// extend _init
var _init = $.ui.dialog.prototype._init;
$.ui.dialog.prototype._init = function () {
    ///////////var self = this;

    // apply original arguments
    _init.apply(this, arguments);

    //patch
    if ($.ui && $.ui.dialog && $.ui.dialog.overlay) {
        $.ui.dialog.overlay.events = $.map('focus,keydown,keypress'.split(','), function (event) {
           return event + '.dialog-overlay';
       }).join(' ');
    }
};
// end _init


// extend open function
var _open = $.ui.dialog.prototype.open;
$.ui.dialog.prototype.open = function () {
    var self = this;

    // apply original arguments
    _open.apply(this, arguments);

    // get dialog original size on open
    //var oHeight = self.element.parent().outerHeight(),
       // oWidth = self.element.parent().outerWidth(),
       var isTouch = $("html").hasClass("touch");

    // responsive width & height
    var resize = function () {

        // check if responsive
        // dependent on modernizr for device detection / html.touch
        //if (self.options.responsive === true || (self.options.responsive === "touch" && isTouch)) {
            ////V1.034 nincs rá szükség!
			//var elem = self.element;
                //wHeight = $(window).height(),
                //////var wWidth = $(window).width();
				
                //dHeight = elem.parent().outerHeight(),
                //dWidth = elem.parent().outerWidth(),
                //setHeight = Math.min(wHeight * self.options.scaleH, oHeight),
                //var setWidth = Math.min(wWidth * self.options.scaleW, oWidth);
                ////var setWidth = Math.min(wWidth * self.options.scaleW);
				//var setHeight_emre=Math.min($(window).height()*0.95);
/*
            // check & set height
            if( (self.options.setHeight_kelle === true) && ((oHeight + 100) > wHeight || elem.hasClass("resizedH")) ){
                elem.dialog("option", "height", setHeight).parent().css("max-height", setHeight);
                elem.addClass("resizedH");
            }

            // check & set width
            if ((oWidth + 100) > wWidth || elem.hasClass("resizedW")) {
                elem.dialog("option", "width", setWidth).parent().css("max-width", setWidth);
                elem.addClass("resizedW");
            }

            // only recenter & add overflow if dialog has been resized
            if (elem.hasClass("resizedH") || elem.hasClass("resizedW")) {
                elem.dialog("option", "position", "center");
                elem.css("overflow", "auto");
            }
			*/
			
			//emre
			//elem.dialog("option", "width", setWidth).parent().css("max-width", setWidth);
			//elem.dialog("option", "width", setWidth);
			//elem.dialog("option","max-width",$(window).width()*0.95);
			
			//elem.dialog("option","maxHeight",$(window).height()*0.95);
			//elem.dialog("option", "Maxwidth","12px");
			
			////V1.034 nincs rá szükség!
			//elem.dialog("option","maxHeight",$(window).height()*0.95);
			
			//elem.parent().css("max-width",setWidth);
			
			//V1.034 nincs rá szükség!
			//elem.parent().css("max-width",$(window).width()*0.95);
			
			
			//emre 2023
			//////////////elem.dialog("option","position", {my: "center", at: "center", of: window});
					
        //}

        // add webkit scrolling to all dialogs for touch devices
        if (isTouch) {
            var elem = self.element;
			elem.css("-webkit-overflow-scrolling", "touch");
        }
    };

    // call resize()
    resize();

    // resize on window resize
    $(window).on("resize", function () {
        resize();
    });

    // resize on orientation change
     if (window.addEventListener) {  // Add extra condition because IE8 doesn't support addEventListener (or orientationchange)
        window.addEventListener("orientationchange", function () {
            resize();
        });
    }

    // hide titlebar
    if (!self.options.showTitleBar) {
        self.uiDialogTitlebar.css({
            "height": 0,
            "padding": 0,
            "background": "none",
            "border": 0
        });
        self.uiDialogTitlebar.find(".ui-dialog-title").css("display", "none");
    }

    //hide close button
    if (!self.options.showCloseButton) {
        self.uiDialogTitlebar.find(".ui-dialog-titlebar-close").css("display", "none");
    }

    // close on clickOut
    if (self.options.clickOut && !self.options.modal) {
        // use transparent div - simplest approach (rework)
        $('<div id="dialog-overlay"></div>').insertBefore(self.element.parent());
        $('#dialog-overlay').css({
            "position": "fixed",
            "top": 0,
            "right": 0,
            "bottom": 0,
            "left": 0,
            "background-color": "transparent"
        });
        //$('#dialog-overlay').click(function (e) {
		$('#dialog-overlay').on('click', function (e) {//emre
            e.preventDefault();
            e.stopPropagation();
            self.close();
        });
        // else close on modal click
    } else if (self.options.clickOut && self.options.modal) {
        //$('#ui-widget-overlay').click(function (e) {
		$('#ui-widget-overlay').on('click', function (e) {//emre
            self.close();
        });
    }

    // add dialogClass to overlay
	//emre
    /*if (self.options.dialogClass) {
        $('#ui-widget-overlay').addClass(self.options.dialogClass);
    }*/
};
//end open


// extend close function
var _close = $.ui.dialog.prototype.close;
$.ui.dialog.prototype.close = function () {
    var self = this;
    // apply original arguments
    _close.apply(this, arguments);

    // remove dialogClass to overlay
	//emre
    /*if (self.options.dialogClass) {
        $('#ui-widget-overlay').removeClass(self.options.dialogClass);
    }*/
    //remove clickOut overlay
    if ($("#dialog-overlay").length) {
        $("#dialog-overlay").remove();
    }
};
//end close
