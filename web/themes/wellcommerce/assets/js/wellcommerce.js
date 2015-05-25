$(document).ready(function () {
    $('.add-cart').click(function (e) {
        e.stopImmediatePropagation();
        GAjaxRequest($(this).attr('href'), $(this).data(), function(oResponse){
            $('#basket-modal').html(oResponse).modal('show');
        });

        return false;
    });
});