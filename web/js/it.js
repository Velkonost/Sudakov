
$('input[type=radio][name=it-methodAssigmentCheck]').change(function () {
    $.ajax({
        url: $("#it-memberAllocationForm").data("url"),
        dataType: "json",
        method: "post",
        data: {type: 'type', value: this.value},
        success: function (result) {
            if (result.code == 0) {

            }
        }
    })
});

$("input", $("#it-memberAllocationForm")).on("click", function () {
    var id = $(this).parent().parent().attr('id'),
        managerId = id.substr(8),
        field = $(this).attr('name'),
        value = 0;
    if ($(this).prop('type') == 'checkbox') {
        value = $(this).prop('checked') ? 1 : 0;
    } else {
        value = $(this).val();
    }
    sendData(managerId, field, value);
});

$('.it-coefficient').on('change', function (e) {
    var id = $(this).parent().parent().attr('id'),
        managerId = id.substr(8),
        field = $(this).attr('name'),
        value = $(this).val();
    sendData(managerId, field, value);
});

function sendData(managerId, field, value) {
    $.ajax({
        url: $("#it-memberAllocationForm").data("url"),
        dataType: "json",
        method: "post",
        data: {
            manager_id: managerId,
            field: field,
            value: value
        }
    }).done(function (json) {
        if (json.status == 200) {
            $("#saved_status").removeClass("hide");
            setTimeout(function () {
                $("#saved_status").addClass("hide");
            }, 500);
        }
    });
}


