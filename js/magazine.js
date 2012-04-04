jQuery(document).ready(function( $ ) { 
	
	imgsLoaded = new Array()
	
    $('#cbqc_magazine').booklet({
        autoCenter: true,
        closed: true,
        covers: true,
		overlays: false,
        arrows: true,
        manual: false,
        tabs: false,
        hash: false,
        keyboard: true,
        height: 676,
        width: 1100,
		pagePadding: 0,
		startingPage: 0,
		menu: '.book-menu',
		chapterSelector: true,   
		next: '.page.right',
		prev: '.page.left',
		pageNumbers: true,    
		before: function(opts) {   
			var pageIndex = opts.curr 
			
			function loadImg(img) {
				if (img.attr('data-img-loaded') == '0') {
					img.attr('src', img.attr('data-img-url'))
					img.attr('data-img-loaded', '1')                                                      					
				}
			}
			
			loadImg($('#cbqc_magazine').find('.page').eq(pageIndex-1).find('img'))
			loadImg($('#cbqc_magazine').find('.page').eq(pageIndex).find('img'))
						
			imgsLoaded[pageIndex] = true
			
			var totalPages = $('#cbqc_magazine .page').length + 1
			// alert('pageIndex = ' + pageIndexcurr + ' | totalPages = ' + totalPages)						
			if (typeof prevPage === 'undefined') {
				prevPage = 0
			}               
			if ((prevPage == 0) || (totalPages == prevPage)) {
				$('#cbqc_magazine_outr').animate({ width: '1100px' }, 1200)
			}                                      
			else if ((pageIndex == 0) || (pageIndex == totalPages)) {
				$('#cbqc_magazine_outr').animate({ width: '550px' }, 1200)
			}                             
		},
        after: function(opts){
			prevPage = opts.curr
            // alert('after! new page index is : ' + opts.curr)                
			if (opts.curr > 3) {
				var title = $('#cbqc_magazine .b-page-' + opts.curr + ' .page-title').text()
				$('#cbqc_magazine_outr .b-current').text(title)
			}
        }            
    })    
    
	// TOC clicks
	 $('.toc-item a').click(function(event) {
		event.stopImmediatePropagation()
		event.preventDefault() 

	    var pageNum = parseInt( $(this).attr('href') )
	    $('#cbqc_magazine').booklet( pageNum )
	})
    
    // Popup display
    $('#cbqc_magazine .popup').click(function(event) {
        event.stopImmediatePropagation()
        $(this).parent().find('.content').toggle() 
    })

})