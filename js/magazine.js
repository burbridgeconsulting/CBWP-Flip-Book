jQuery(document).ready(function($) {                                
    
    // TOC clicks
    $('.toc-item a').click(function(event) {
        event.stopImmediatePropagation()
        event.preventDefault() 
        
        var destination = $(this).attr('href')  
        
        // Jump to that spread, by making everything after it, hidden
        $(destination).nextAll().each(function() {
            $(this).css('display', 'none')
        })       
        $('#toc').fadeOut()
    })
    
    // Popup display
    $('#cbqc_magazine .popup').click(function(event) {
        event.stopImmediatePropagation()
        $(this).parent().find('.content').toggle() 
    })

    // Clicking right page moves us DOWN the pages  
    $('#cbqc_magazine .page.right').not('.last').click(function(event) {   

        $(this).parent().fadeOut()
        
        if ( $(this).hasClass('first') ) {
            $(this).parent().parent().animate({
                width: '1101'
                }, 1000, 'swing', function() {
    
            })
        }

    })
    
    // Clicking left page moves us UP the pages  
    $('#cbqc_magazine .page.left').not('.first').click(function(event) {  

        $(this).parent().next().fadeIn()
        
        if ( $(this).hasClass('page-toc') ) {
            $(this).parent().parent().animate({
                width: '550'
                }, 1000, 'swing', function() {
    
            })
        }
                      
    })                               
    
})
















