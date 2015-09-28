$(document).ready(function () {

    var oBasketModal = $('#basket-modal');
    var oCartPreview = $('#topCart');

    $('.add-cart').GProductAddCartButton({
        oBasketModal: oBasketModal,
        oCartPreview: oCartPreview,
        sAddProductFormClass: '.add-to-cart',
        sProductSelector: '#product',
        sQuantitySelector: '#quantity',
        sAttributeSelector: '#attribute',
        sPriceSelector: '#price',
        sAddProductRoute: 'front.cart.add',
        sAttributesSelectClass: '.attribute'
    });

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
