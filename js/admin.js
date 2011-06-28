jQuery(document).ready(function($) { 
    
    // Not elegant to duplicate the following code:

    $('#cbqc_spread-left-page .delete').click(function(event) {
        event.preventDefault()  
        
        $(this).parents('td')
            .find('.field-img').fadeOut().end()
            .find('.url').remove().end()
            .find('#cbqc_image-left').val('')

        $('#delete-cbqc_image-left').val('true')               
    })

    $('#cbqc_spread-right-page .delete').click(function(event) {
        event.preventDefault()
        
        $(this).parents('td')
            .find('.field-img').fadeOut().end()
            .find('.url').remove().end()
            .find('#cbqc_image-right').val('').end()
            .find('#delete-cbqc_image-right').val('true')

            $('#delete-cbqc_image-right').val('true')               
    })

})
