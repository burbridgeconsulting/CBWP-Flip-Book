jQuery(document).ready(function($) {
                             
  // Clicking right page moves us DOWN the pages  
  $('.page.right').not('.last').click(function() {  
      $(this).parent().fadeOut()
  })
    
  // Clicking left page moves us UP the pages  
  $('.page.left').not('.first').click(function() {  
      $(this).parent().next().fadeIn()
  })        
  
  // Popup display
  $('.popup').click(function() {
      $(this).parent().find('.content').toggle('fast')
  })
    
})
