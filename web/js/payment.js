
jQuery(function() {

    $("select#payment-status").multiselect({
        numberDisplayed: 1,
        allSelectedText: 'Все',
        nSelectedText: " выбрано",
        onChange: function (option, checked) {
            if ($(option).val() == "-1") {
                if (checked) {
                    $("select#jobsearch-status").multiselect('selectAll', true);
                } else {
                    $("select#jobsearch-status").multiselect('deselectAll', true);
                }
            } else {
                // проверяем какие опции выбраны
                var $select = $(option).parent();
                var $all = $select.find("option[value='-1']");
                if ($all.prop("selected") == true) {
                    if ($select.find("option:selected").length < $select.find("option").length) {
                        $("select#payment-status").multiselect('deselect', "-1");
                    }
                } else {
                    if ($select.find("option:selected").length == ($select.find("option").length - 1)) {
                        $("select#payment-status").multiselect("select", "-1");
                    }
                }
            }
        },
        onDropdownHidden: function (event) {
            // none
            $("#payment-search-form").submit();
        }
    });

    $("#payment-search-form [name^='PaymentSearch']").on("keyup", function(e) {
        if (e.keyCode == 13) {
            $("#payment-search-form").submit();
        }
        return false;
    });

    $("#payment-pnum").on("change", function(e) {
        $("#payment-search-form").submit();
    });

    var onResize = function() {
        $(".payment-table .col-wrap").height( $(".payment-table").height() + "px" );
    };
    $(".payment-table .header th > div").on("click", function() {
        var $parent = $(this).parent();
        // full columns
        if ($parent.hasClass("col-lead")) {
            $(".col-lead-min").removeClass("hide");
            $(".col-lead").addClass("hide");
        } else if ($parent.hasClass("col-account")) {
            $(".col-account-min").removeClass("hide");
            $(".col-account").addClass("hide");
        } else if ($parent.hasClass("col-manager")) {
            $(".col-manager-min").removeClass("hide");
            $(".col-manager").addClass("hide");
        }
        // min columns
        else if ($parent.hasClass("col-lead-min")) {
            $(".col-lead").removeClass("hide");
            $(".col-lead-min").addClass("hide");
        } else if ($parent.hasClass("col-account-min")) {
            $(".col-account").removeClass("hide");
            $(".col-account-min").addClass("hide");
        } else if ($parent.hasClass("col-manager-min")) {
            $(".col-manager").removeClass("hide");
            $(".col-manager-min").addClass("hide");
        }
        onResize();
    });


    $('input[name="PaymentSearch[paid_at]"]').datepicker({
        range: true,
        position: "bottom right",
        multipleDatesSeparator: "-",
        onShow: function(me, animationCompleted) {
            console.log(me, animationCompleted);
        }
    });
    $('input[name="PaymentSearch[created_at]"]').datepicker({
        range: true,
        position: "bottom right",
        multipleDatesSeparator: "-",
        onShow: function(me, animationCompleted) {
            console.log(me, animationCompleted);
        }
    });
    $('<div class="datepicker--bottom-button" style="padding: 10px; background-color: #fffdca; text-align: center;">'
            //+ '<a style="margin-right: 5px;" href="#" title="" class="reset-btn btn btn-sm btn-default">Сбросить</a>'
        + '<a style="_margin-left: 5px;" href="#" title="" class="send-btn btn btn-sm btn-primary">Показать</a>'
        + '</div>').insertAfter(".datepickers-container .datepicker .datepicker--content");
    $(".datepickers-container .datepicker .datepicker--bottom-button .send-btn").on("click", function() {
        $("#payment-search-form").submit();
        return false;
    });

});
