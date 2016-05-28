$(document).ready(function () {
    var oBasketModal = $('#basket-modal');
    var oCartPreview = $('#topCart');
    var oAddCartButtonSettings = {
        oBasketModal: oBasketModal,
        oCartPreview: oCartPreview,
        sAddProductFormClass: '.add-to-cart',
        sProductSelector: '#product',
        sVariantSelector: '#variant',
        sQuantitySelector: '#quantity',
        sPriceSelector: '#price',
        sAddProductRoute: 'front.order_cart.add',
        sAttributesSelectClass: '.attribute'
    };

    $('.add-cart').GProductAddCartButton(oAddCartButtonSettings);

    $('.coming-soon').click(function(e){
        e.stopImmediatePropagation();
        $('#coming-soon-modal').modal('show');
        return false;
    });

    $('.cart').GCart({
        sChangeQuantityRoute: 'front.order_cart.edit',
        sQuantitySpinnerClass: 'quantity-spinner'
    });

    $('form#search').GSearch({
        sProductSearchRoute:        'front.search.index',
        sProductLiveSearchRoute:    'front.search.quick',
        sPhraseInputSelector:       '#phrase',
        sSearchResultsSelector:     'div#search-results',
        oAddCartButtonSettings:     oAddCartButtonSettings
    });

    $('.cart .coupon').GCoupon({
        sAddCouponRoute:            'front.coupon.add',
        sRemoveCouponRoute:         'front.coupon.delete',
        sCodeInputIdentifier:       'coupon_code',
        sAddButtonIdentifier:       'use_coupon',
        sRemoveButtonIdentifier:    'remove_coupon'
    });

	$('.push-search, .sliding-search > div').click(function() {
		$('body').toggleClass('sliding-search-is-open');
        $('form#search #phrase').focus();
	});

    $(document).keyup(function(e) {
        if (e.keyCode == 27) {
            if($('body').has('sliding-search-is-open')){
                $('body').removeClass('sliding-search-is-open');
            }
        }
    });

	 $('.sliding-search > div > form').click(function(event){
	     event.stopPropagation();
	 });

    $('.push-hamburger').click(function() {
		$('body').toggleClass('hamburger-is-open');
	});

	$('.modal').prependTo('body');
});
