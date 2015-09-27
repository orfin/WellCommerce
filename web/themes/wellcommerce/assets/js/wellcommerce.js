$(document).ready(function () {

    var oBasketModal = $('#basket-modal');
    var oCartPreview = $('#topCart');

    $('.add-cart').GProductAddCartButton({
        oBasketModal: oBasketModal,
        oCartPreview: oCartPreview
    });

    var fProductAddCartFormHandler = function(oObject){
        oObject.GProductAddCartForm({
            oProduct: $('#product', oObject),
            oQuantity: $('#quantity', oObject),
            oAttributes: $('.attributes', oObject),
            oBasketModal: oBasketModal,
            oCartPreview: oCartPreview
        });
    };

    oBasketModal.on('shown.bs.modal', function (e) {
        var oSelector = $(this).find('.add-to-cart');
        if(oSelector.length){
            fProductAddCartFormHandler(oSelector);
        }
    });

    fProductAddCartFormHandler($('.product-details .add-to-cart'));

    $('.coming-soon').click(function(e){
        e.stopImmediatePropagation();
        $('#coming-soon-modal').modal('show');
        return false;
    });

    $('.cart').GCart({
        sChangeQuantityRoute: 'front.cart.edit',
        sQuantitySpinnerClass: 'quantity-spinner'
    });


    $('.push-hamburger').click(function() {
		$('body').toggleClass('hamburger-is-open');
	});

	$('.modal').prependTo('body');
});
