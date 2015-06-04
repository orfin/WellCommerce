$(document).ready(function () {
    $('.add-cart').click(function (e) {
        e.stopImmediatePropagation();
        GAjaxRequest($(this).attr('href'), $(this).data(), function(oResponse){
            $('#basket-modal').html(oResponse.basketModalContent).modal('show');
            $('#topCart').html(oResponse.cartPreviewContent);
        });

        return false;
    });

    $('.coming-soon').click(function(e){
        e.stopImmediatePropagation();
        $('#coming-soon-modal').modal('show');
        return false;
    });
});