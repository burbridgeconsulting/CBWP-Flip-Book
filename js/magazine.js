jQuery(document).ready(function($) {                                
    
    // Popup display
    $('.popup').click(function(event) {
        event.stopImmediatePropagation()
        $(this).parent().find('.content').toggle() 
    })

    // Clicking right page moves us DOWN the pages  
    $('.page.right').not('.last').click(function(event) {   
        $(this).parent().fadeOut()
    })
    
    // Clicking left page moves us UP the pages  
    $('.page.left').not('.first').click(function(event) {  
        $(this).parent().next().fadeIn()
    })        
  
    // Clicking anything else hides popup 
    // $('body').not('.popup .msg').click(function() {
    //     $('.popup .content').hide()
    // })
    
})
