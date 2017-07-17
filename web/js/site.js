
jQuery(function($) {

    // for home page
    if ($(".home-tails").length > 0) {
        $(window).on("resize", function() {
            $(".tail").each(function() {
                $(this).height($(this).width());
            });
        });
        $(".tail").each(function() {
            $(this).height($(this).width());
        });
    }

    // create lead
    if ($(".lead-form").length > 0) {
        $("#leadform-phone").mask("+7 (999) 999-99-99");
    }

});


// payment

jQuery(function(){

    $(".add-item").on("click", function() {
        paymentAddItem(false);
        return false;
    });

    $(".price-value, .count-value").on("blur keyup", paymentCalcPrice);

});

function paymentDeleteItem(button)
{
    $(button).closest(".item-block").remove();
    return false;
}

function paymentAddItem(first)
{
    first = first || false;
    var $tmpl = $(".add-form-template").clone();
    if (first) {
        $tmpl.find(".delete-item").remove();
    }
    $tmpl.find("input, textarea").each(function(i, obj){
        $(obj).removeAttr("disabled");
    });
    $tmpl.removeClass("add-form-template");
    $tmpl.find(".price-value, .count-value").on("blur keyup", paymentCalcPrice);
    $(".product-items-list").append($tmpl);
    return false;
}

function paymentCalcPrice()
{
    var sum = 0;
    $(".add-form-items-list .item-block").each(function() {
        var price = $(this).find(".price-value").val().replace(',', '.');
        var count = $(this).find(".count-value").val();
        if (price == "") {
            price = 0;
        } else {
            price = parseFloat(price);
        }
        if (count == "") {
            count = 0;
        } else {
            count = parseInt(count);
        }
        sum += (price * count);
    });
    sum = Math.floor(sum * 100) / 100;
    $(".total-price b").text((sum + "").replace('.', ','));
    $("#payment-sum").val(sum);
}
