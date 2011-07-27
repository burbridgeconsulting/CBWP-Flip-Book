jQuery(document).ready(function($) {                                
    
    // Popup display
    $('#cbqc_magazine .popup').click(function(event) {
        event.stopImmediatePropagation()
        $(this).parent().find('.content').toggle() 
    })

    // Clicking right page moves us DOWN the pages  
    $('#cbqc_magazine .page.right').not('.last').click(function(event) {   
        $(this).parent().fadeOut()
    })
    
    // Clicking left page moves us UP the pages  
    $('#cbqc_magazine .page.left').not('.first').click(function(event) {  
        $(this).parent().next().fadeIn()
    })                               
    
    // Clicking on cover opens magazine
    $('#cbqc_magazine .cover').click(function(event) {
        $(this).fadeOut(1600)
            .parent().animate({
                width: '1024'
                }, 1000, 'linear', function() {
    
            })
    })
  
    // Clicking anything else hides popup 
    // $('body').not('.popup .msg').click(function() {
    //     $('.popup .content').hide()
    // })
    
})
















