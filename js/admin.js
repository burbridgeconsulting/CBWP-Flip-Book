jQuery(document).ready(function($) { 
    
    // Not elegant to duplicate the following code:

    $('#cbwp_spread-left-page .delete').click(function(event) {
        event.preventDefault()  
        
        $(this).parents('td')
            .find('.field-img').fadeOut().end()
            .find('.url').remove().end()
            .find('#cbwp_image-left').val('')

        $('#delete-cbwp_image-left').val('true')               
    })

    $('#cbwp_spread-right-page .delete').click(function(event) {
        event.preventDefault()
        
        $(this).parents('td')
            .find('.field-img').fadeOut().end()
            .find('.url').remove().end()
            .find('#cbwp_image-right').val('').end()
            .find('#delete-cbwp_image-right').val('true')

            $('#delete-cbwp_image-right').val('true')               
    })

    $('#cbwp_toc .delete').click(function(event) {
        event.preventDefault()
        
        $(this).parents('td')
            .find('.field-img').fadeOut().end()
            .find('.url').remove().end()
            .find('#cbwp_image-toc').val('').end()
            .find('#delete-cbwp_image-toc').val('true')

            $('#delete-cbwp_image-toc').val('true')               
    })
})
