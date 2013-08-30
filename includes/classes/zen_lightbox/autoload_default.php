<?php
/**
 * Zen Lightbox
 *
 * @author Alex Clarke (aclarke@ansellandclarke.co.uk)
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: autoload_default.php 2008-12-09 aclarke $
 */
?>

jQuery(function($) {
        $("a[rel^='lightbox']").slimbox({<?php require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'zen_lightbox/options.php'); ?>}, function(el) 
        {
                return [el.href, el.title /* + '<br /><a href="' + el.href + '">Download this image</a>'*/];
        }, function(el) {
        	if((this == el) || (this.rel.length > 8 && this.rel == el.rel))
        		return true;
        		
        	var patt = new RegExp("lightbox-(\\S+)","g");
        	var r1 = patt.exec(el.rel);
        	patt = new RegExp("lightbox-(\\S+)","g");
        	var r2 = patt.exec(this.rel);
        	//alert('r1[1]='+r1[1]);
        	//alert('r2[1]='+r2[1]);
        	if(r1[1]==r2[1])
        		return true;
        	else
        		return false;
        });
        <?php if (ZEN_LIGHTBOX_CLOSE_IMAGE == 'true' || ZEN_LIGHTBOX_PREV_NEXT == 'true') { echo ("$('#lbPrevLink').addClass('prevNoHover'); $('#lbNextLink').addClass('nextNoHover');");}?>
});
//--></script>