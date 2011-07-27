jQuery(document).ready(function($) {                                
    
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
                width: '1024'
                }, 1000, 'linear', function() {
    
            })
        }

    })
    
    // Clicking left page moves us UP the pages  
    $('#cbqc_magazine .page.left').not('.first').click(function(event) {  

        $(this).parent().next().fadeIn()
        
        if ( $(this).hasClass('page-1') ) {
            $(this).parent().parent().animate({
                width: '514'
                }, 1000, 'linear', function() {
    
            })
        }
                      
    })                               
    
})
















