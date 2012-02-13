jQuery(document).ready(function( $ ) {
	
    $('#cbqc_magazine').booklet({
        autoCenter: true,
        closed: true,
        covers: true,
        autoCenter: true,    
		overlays: false,
        arrows: true,
        manual: false,
        tabs: false,
        hash: true,
        keyboard: true,
        height: 676,
        width: 1100,
		pagePadding: 0,
		startingPage: 0,
		menu: '.book-menu',
		chapterSelector: true,  
		pageNumbers: true,
        after: function(opts){
            // alert('after! new page index is : ' + opts.curr)                
			if (opts.curr > 3) {
				var title = $('#cbqc_magazine .b-page-' + opts.curr + ' .page-title').text()
				$('#cbqc_magazine_outr .b-current').text(title)
			}
        }            
    })    
    
    // TOC clicks
   //  $('.toc-item a').click(function(event) {
   //      event.stopImmediatePropagation()
   //      event.preventDefault() 
   //      
   // 	    $('#cbqc_magazine').booklet(6)
   // })
    
    // Popup display
    $('#cbqc_magazine .popup').click(function(event) {
        event.stopImmediatePropagation()
        $(this).parent().find('.content').toggle() 
    })
    
})