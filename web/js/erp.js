
jQuery(function($) {

    $(".status-selector-wrap .select-status.selector").hover(function() { }, function() {
        $("a:not(.selected)", this).addClass("hide");
        $(this).closest(".status-selector-wrap").removeClass("open").css("z-index", "");
    });

    $(".status-selector-wrap .select-status.selector a").on("click", function() {
        var status = $(this).data("status"),
            $wrap = $(this).closest(".status-selector-wrap"),
            id = $wrap.data("job_id"),
            url = $wrap.data("status_url");
        if ($wrap.hasClass("open")) {
            if (typeof(status) != 'undefined') {
                if (status == 90 || status == 100) {
                    if (!confirm("После смены статуса эта заявку будет скрыта.\nЗакрыть эту заявку?")) {
                        $wrap.removeClass("open");
                        return false;
                    }
                }
                $wrap.find(".select-status.selector a").removeClass("selected").addClass("hide");
                $(this).addClass("selected").removeClass("hide");
                $.ajax({
                    "url": url,
                    "type": "get",
                    "dataType": "json",
                    "_this": this,
                    "data": {
                        "id": id,
                        "status": status
                    }
                }).done(function(json) {
                    if (json.status) {
                        if (json.status == "success") {

                        } else {

                        }
                    } else {
                        alert("Error on save!");
                    }
                });
            }
            $wrap.removeClass("open");
        } else {
            $("a", $wrap).removeClass("hide");
            $("a.active", $wrap).addClass("selected");
            $wrap.addClass("open").css("z-index", "9000");
        }
        return false;
    });

    $(".adminchek").change(function() {
        id = $(this).data("adm_id");
        url = $(this).data("adm_url");
        if(this.checked) {
            chek = 1;
        }else{
            chek = 0;
        }
            $.ajax({
                "url": url,
                "type": "get",
                "dataType": "json",
                "_this": this,
                "data": {
                    "id": id,
                    "chek": chek
                }
            }).done(function(json) {
                if (json.status) {
                    if (json.status == "success") {
                        alert('Обновлено!');
                    } else {

                    }
                } else {
                    alert("Error on save!");
                }
            });

    });

    // TODO conflict of jquery versions. Yii need 2.2.x but Air need 3.0.0 :(
    $('input[name="JobSearch[deadline]"]').datepicker({
        range: true,
        position: "bottom left",
        multipleDatesSeparator: "-",
        onShow: function(me, animationCompleted) { // doesnt work for v2.0.2
            console.log(me, animationCompleted);
        }
    });
    $('input[name="JobSearch[created_at]"]').datepicker({
        range: true,
        position: "bottom right",
        multipleDatesSeparator: "-",
        onShow: function(me, animationCompleted) {
            console.log(me, animationCompleted);
        }
    });
    $('input[name="JobSearch[finished_at]"]').datepicker({
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
        $("#job-search-form").submit();
        return false;
    });

    $("select#jobsearch-status").multiselect({
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
                        $("select#jobsearch-status").multiselect('deselect', "-1");
                    }
                } else {
                    if ($select.find("option:selected").length == ($select.find("option").length - 1)) {
                        $("select#jobsearch-status").multiselect("select", "-1");
                    }
                }
            }
        },
        onDropdownHidden: function (event) {
            $("#job-search-form").submit();
        }
    });

    // раскрашивание выпадающего списка
    $(".col-status .multiselect-container.dropdown-menu input[type=checkbox]").each(function() {
        var className = "status-" + $(this).val();
        $(this).closest("li").addClass(className);
    });

    $("#job-search-form [name^='JobSearch']").on("keyup", function(e) {
        if (e.keyCode == 13) {
            $("#job-search-form").submit();
        }
        return false;
    });


    var onResize = function() {
        $(".job-table .col-wrap").height( $(".job-table").height() + "px" );
    };
    $(window).on("resize", onResize);
    $(".job-table .header th > div").on("click", function() {
        var $parent = $(this).parent();
        if ($parent.hasClass("col-deadline")) {
            $(".col-deadline-min").removeClass("hide");
            $(".col-deadline").addClass("hide");
        } else if ($parent.hasClass("col-lead")) {
            $(".col-lead-min").removeClass("hide");
            $(".col-lead").addClass("hide");
        } else if ($parent.hasClass("col-status")) {
            $(".col-status-min").removeClass("hide");
            $(".col-status").addClass("hide");
        } else if ($parent.hasClass("col-dates")) {
            $(".col-dates-min").removeClass("hide");
            $(".col-dates").addClass("hide");
        }else if ($parent.hasClass("col-prints")) {
            $(".col-prints-min").removeClass("hide");
            $(".col-prints").addClass("hide");
        } else if ($parent.hasClass("col-deadline-min")) {
            $(".col-deadline").removeClass("hide");
            $(".col-deadline-min").addClass("hide");
        } else if ($parent.hasClass("col-lead-min")) {
            $(".col-lead").removeClass("hide");
            $(".col-lead-min").addClass("hide");
        } else if ($parent.hasClass("col-status-min")) {
            $(".col-status").removeClass("hide");
            $(".col-status-min").addClass("hide");
        } else if ($parent.hasClass("col-dates-min")) {
            $(".col-dates").removeClass("hide");
            $(".col-dates-min").addClass("hide");
        }else if ($parent.hasClass("col-prints-min")) {
            $(".col-prints").removeClass("hide");
            $(".col-prints-min").addClass("hide");
        }
        onResize();
    });

    $(document).on('change', 'input[type=checkbox]', function () {
        var $this = $(this), $chks = $(document.getElementsByName(this.name)), $all = $chks.filter(".chk-all");

        if ($this.hasClass('chk-all')) {
            $chks.prop('checked', $this.prop('checked'));
        } else switch ($chks.filter(":checked").length) {
            case +$all.prop('checked'):
                $all.prop('checked', false).prop('indeterminate', false);
                break;
            case $chks.length - !!$this.prop('checked'):
                $all.prop('checked', true).prop('indeterminate', false);
                break;
            default:
                $all.prop('indeterminate', true);
        }
    });




     

});

// Pass the checkbox name to the function
function getCheckedBoxes(chkboxName) {
    var checkboxes = document.getElementsByClassName(chkboxName);
    var checkboxesChecked = [];
    // loop over them all
    for (var i=0; i<checkboxes.length; i++) {
        // And stick the checked ones onto an array...
        if (checkboxes[i].checked) {
            checkboxesChecked.push(checkboxes[i].value);
        }
    }
    // Return the array if it is non-empty, or null
    return checkboxesChecked.length > 0 ? window.open('/erp/printjob?id=' + checkboxesChecked,'_blank') : alert('Не выбраны сделки');
}