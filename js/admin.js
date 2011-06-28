jQuery(document).ready(function($) {

    $('#cbqc_spread-left-page .delete').click(function(event) {
        event.preventDefault()
        
        $(this).parents('td').find('.field-img').fadeOut()
        $(this).parents('td').find('.url').remove()
        $(this).parents('td').find('#cbqc_image-left').val('')
    })

})
