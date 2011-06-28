jQuery(document).ready(function($) {

    $('.delete').click(function() {
        // var image = $(this).parent().find('img')
        // image.fadeOut()
        // 
        // var url = $(this).parent().find('.url')
        // url.remove()   
        // 
        var itemID = $(this).parent().parent().find('label').attr('for')
        console.log('itemID=' + itemID)   
        var postID = $('.post-id').value()
        console.log('postID = ' + postID)
    })

})
