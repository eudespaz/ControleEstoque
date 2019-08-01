jQuery.fn.iframe = function(options) {
    return this.each(function() {
        var $this = jQuery(this);
        var cls = this.className;
        
        var opts = jQuery.extend({
            frameborder:  ((cls.match(/fb:(\d+)/)||[])[1]) || 0,
            marginwidth:  ((cls.match(/wm:(\d+)/)||[])[1]) || 0,
            marginheight: ((cls.match(/hm:(\d+)/)||[])[1]) || 0,
            width:        ((cls.match(/w:(\d+)/)||[])[1]) || 640,
            height:       ((cls.match(/h:(\d+)/)||[])[1]) || 480,
            scrolling:    ((cls.match(/sc:(\w+)/)||[])[1]) || "auto",
            version:     '1,0,0,0',
            cls:          cls,
            src:          $this.attr('href') || $this.attr('src'),
			id:			  $this.attr('id'),
            caption:      $this.text(),
            attrs:        {},
            elementType:  'div',
            xhtml:        true
        }, options || {});
        
        var endTag = opts.xhtml ? ' />' : '>';

        var a = ['<iframe src="' + opts.src + '"'];
		if(opts.id){
			a.push(' id="' + opts.id + '"');
		}else{
			a.push(' id="content_iframe"');
		}
		a.push(' frameborder="' + opts.frameborder + '"');
		a.push(' marginwidth="' + opts.marginwidth + '"');
		a.push(' marginheight="' + opts.marginheight + '"');
		a.push(' width="' + opts.width + '"');
		a.push(' height="' + opts.height + '"');
		a.push(' scrolling="' + opts.scrolling + '"');
		a.push(endTag);
        
        // convert anchor to span/div/whatever...
        var $el = jQuery('<' + opts.elementType + ' class="' + opts.cls + '"></' + opts.elementType + '>');
        $el.html(a.join(''));
        $this.after($el).remove();
    });
};