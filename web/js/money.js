var loadingImg = new Image();
loadingImg.src = BASE_URL + "images/loading5.gif";

jQuery(function($) {

	var NAVBAR_HEIGHT = 40,
		TABLES_HEIGHT = $('.js-money-table-clients').outerHeight(),
		HEADER_HEIGHT = $('.js-money-table-row-title:last').outerHeight() + $('.js-money-table-row-header:last').outerHeight() * 2;

	// INIT TABLE
	$('.js-money-layout-real').css("height", TABLES_HEIGHT + "px");
	// create clones of table headers
	$('.money-table').each(function(index, table) {
		var $moneyTable = $(table).clone();
		if ($moneyTable.hasClass('js-money-table-clients')) {
			$('<div class="money-table money-table-clients">').appendTo('.js-money-abs-header'); // empty space as offset (clients header will be places to other container)
			return true;
		} else {
			$moneyTable.find(".money-table-row").not(".money-table-row-title").not(".money-table-row-header").remove();
			$($moneyTable).appendTo('.js-money-abs-header');
		}
	});
	// make clients column fixed
	$(".money-abs-clients-header").append(
		$(".js-money-table-clients").find(".money-table-row-title, .money-table-row-header").clone(true)
	);
	$(".js-money-table-clients").find(".money-table-row-title, .money-table-row-header").remove();
	$(".money-abs-clients").append(
		$(".js-money-table-clients").find(".money-table-row").clone(true)
	);
	$(".js-money-table-clients .money-table-row").remove();

	var $moneyLayout = $(".money-layout"),
		$absClients = $(".js-money-abs-clients"),
		$absHeader = $(".js-money-abs-header"),
		$clientsHeader = $(".money-abs-clients-header"),
		$collapsedColumns = $(".money-table_collapsed .js-money-table-row-title");

	$('html, body').css('width', $('.js-money-layout-real').width() + 'px').css('min-width', '100%');
	$(window).on('scroll', fixTableHeaders);
	fixTableHeaders();

	$('.js-money-table-row-title').on("click", function(e) {
		var className = "." + $(this).data("class");
		$(className).toggleClass("money-table_collapsed");
		if ($(className).hasClass("money-table_collapsed")) {
			$(className + " .js-money-table-row-title").css("height", TABLES_HEIGHT + "px");
		} else {
			$(className + " .js-money-table-row-title").css("height", "");
		}
		$collapsedColumns = $(".money-table_collapsed .js-money-table-row-title");
		$("html, body").css("width", $(".js-money-layout-real").width() + "px").css("min-width", "100%");
		fixTableHeaders();
	});

	function fixTableHeaders ()
	{
		var windowTop = $(window).scrollTop(),
			windowLeft = $(window).scrollLeft(),
			moneyLayoutOffsetTop = $moneyLayout.offset().top,
			bellowTable = windowTop > (moneyLayoutOffsetTop + TABLES_HEIGHT - HEADER_HEIGHT - NAVBAR_HEIGHT) ? true : false;

		if (!bellowTable && windowTop >= (moneyLayoutOffsetTop - NAVBAR_HEIGHT)) {
			$clientsHeader.css("top", NAVBAR_HEIGHT + "px");
		} else {
			$clientsHeader.css("top", (moneyLayoutOffsetTop - windowTop) + "px");
		}
		$absClients.css("top", (HEADER_HEIGHT + moneyLayoutOffsetTop - windowTop) + "px");
		if (windowLeft > 0) {
			$absHeader.css("left", (15 - windowLeft) + "px");
		} else {
			$absHeader.css("left", "15px");
		}
		if (!bellowTable && windowTop >= (moneyLayoutOffsetTop - NAVBAR_HEIGHT)) {
			$absHeader.css("position", 'fixed').show();
		} else {
			$absHeader.css("position", 'relative').hide();
		}
	}

	// update payments status
	$(".first-payment-status, .second-payment-status").on("click", function(e) {
		e.stopPropagation();
	});
	$(".first-payment-status, .second-payment-status").on("change", function(e) {
		var url = $(this).data("url_update"),
			id = $(this).data("id"),
			num = $(this).hasClass("first-payment-status") ? 1 : 2,
			value = $(this).prop("checked") ? '1' : '0';
		$(this).closest(".money-table-cell").append( $('<img src="'+loadingImg.src+'">') );
		$(this).addClass("hide");
		$.ajax({
			"url": url,
			"type": "post",
			"dataType": "json",
			"_checkbox": this,
			"data": {
				"id": id,
				"value": value,
				"num": num,
				"type": "payment_status"
			}
		}).done(function(json) {
			if (json.status != "success") {
				alert(json.message);
			}
			if (typeof(json.color) != "undefined") {
				var $cell = $(this._checkbox).closest(".money-table-cell");
				$cell.find("img").remove();
				$(this._checkbox).removeClass("hide");
				$cell.removeClass("money-table-cell-red").removeClass("money-table-cell-green");
				$cell.addClass("money-table-cell-" + json.color);
				if (typeof(json.attributes) != "undefined") {
					redrawItemRow(json.attributes);
				}
			}
		}).fail(function(xhr, err) {
			alert("Error!");
		});
		return false;
	});

	// update registry status
	$(".registry-check").on("click", function(e) {
		e.stopPropagation();
	});
	$(".registry-check").on("change", function(e) {
		var url = $(this).data("url_update"),
			id = $(this).data("id"),
			value = $(this).prop("checked") ? '1' : '0';
		$.ajax({
			"url": url,
			"type": "post",
			"dataType": "json",
			"data": {
				"id": id,
				"value": value,
				"type": "registry"
			}
		}).done(function(json) {
			if (json.status != "success") {
				alert(json.message);
			}
			if (typeof(json.attributes) != "undefined") {
				redrawItemRow(json.attributes);
			}
		}).fail(function(xhr, err) {
			alert("Error!");
		});
		return false;
	});

	// table rows selection (hightlight)
	$(".money-table-cell:not(.comment-cell):not(.money-total-row)").on("click", function() {
		var $row = $(this).closest(".money-table-row");
		var id = $row.data("id");
		if ($row.hasClass("selected")) {
			$(".money-item-" + id).removeClass("selected");
		} else {
			$(".money-item-" + id).addClass("selected");
		}
	});

	// ttn comment
	$("select.multiselect").multiselect({
		numberDisplayed: 1,
		allSelectedText: 'Все',
		nSelectedText: " выбрано",
		onChange: function (option, checked) {
			var url = $(option).parent().data("url_update"),
				id = $(option).parent().data("id"),
				value = $(option).val();
			$.ajax({
				"url": url,
				"type": "post",
				"dataType": "json",
				"data": {
					"id": id,
					"value": value,
					"type": "bill_comment"
				}
			}).done(function(json) {
				if (json.status != "success") {
					alert(json.message);
				}
			}).fail(function(xhr, err) {
				alert("Error!");
			});
		}
	});

	$("#comment-modal").on('shown.bs.modal', function (e, t) {
		var id = $(e.relatedTarget).closest(".money-table-row").data("id");
		$(this).data("id", id);
		$("#comment_textarea").val(e.relatedTarget.innerText);
		$("#comment_textarea").focus();
	});
	$("#comment-modal .save-btn").on("click", function () {
		var value = $("#comment_textarea").val(),
			id = $("#comment-modal").data("id"),
			url = $("#comment-modal").data("url_update");
		$.ajax({
			"url": url,
			"type": "post",
			"dataType": "json",
			"_item_id": id,
			"data": {
				"id": id,
				"value": value,
				"type": "comment"
			}
		}).done(function(json) {
			if (json.status != "success") {
				alert(json.message);
			} else {
				var id = this._item_id;
				$(".money-table-row.money-item-" + id + " .comment-cell button").text(json.value);
			}
		}).fail(function(xhr, err) {
			alert("Error!");
		});
		$("#comment-modal").modal('hide');
		return false;
	});

	$("#comment-fin-modal").on('shown.bs.modal', function (e, t) {
		var comment = $(e.relatedTarget).closest(".money-table-row").find("span").text();
		$("#comment_fin_text").text(comment);
	});

	// month filter
	$(".date-period-selector").on("change", function() {
		$("select[name='ttn_komment']").prop("disabled", true);
		$("#money-search-form").submit();
	});


	/**
	 * Redraws item row from money table by data
	 * @param data
	 */
	function redrawItemRow(data)
	{
		if (data.id) {
			$.each(data, function (column, value) {
				$column = $(".money-item-" + data.id + " .money-column-" + column);
				if ($column.length > 0) {
					if ($column.hasClass("select-cell")) {
						$column.find("select").val(value);
					} else {
						if ($column.find(".money-column-value").length > 0) {
							$column.find(".money-column-value").text(value);
						} else {
							$column.html(value);
						}
					}
				}
			});
		}
	}

	$('input[name="MoneySearch[first_payment_date]"]').datepicker({
		range: true,
		position: "bottom right",
		multipleDatesSeparator: "-",
		onShow: function(me, animationCompleted) {
			//console.log(me, animationCompleted);
		}
	});
	$('input[name="MoneySearch[second_payment_date]"]').datepicker({
		range: true,
		position: "bottom right",
		multipleDatesSeparator: "-",
		onShow: function(me, animationCompleted) {
			//console.log(me, animationCompleted);
		}
	});
	$('input[name="MoneySearch[goods_bill_date]"]').datepicker({
		range: true,
		position: "bottom right",
		multipleDatesSeparator: "-",
		onShow: function(me, animationCompleted) {
			//console.log(me, animationCompleted);
		}
	});
	$('input[name="MoneySearch[deadline]"]').datepicker({
		range: true,
		position: "bottom right",
		multipleDatesSeparator: "-",
		onShow: function(me, animationCompleted) {
			//console.log(me, animationCompleted);
		}
	});
	$('input[name="MoneySearch[finished_at]"]').datepicker({
		range: true,
		position: "bottom right",
		multipleDatesSeparator: "-",
		onShow: function(me, animationCompleted) {
			//console.log(me, animationCompleted);
		}
	});
	$('input[name="MoneySearch[created_at]"]').datepicker({
		range: true,
		position: "bottom right",
		multipleDatesSeparator: "-",
		onShow: function(me, animationCompleted) {
			//console.log(me, animationCompleted);
		}
	});
	$('<div class="datepicker--bottom-button" style="padding: 10px; background-color: #fffdca; text-align: center;">'
			//+ '<a style="margin-right: 5px;" href="#" title="" class="reset-btn btn btn-sm btn-default">Сбросить</a>'
		+ '<a style="_margin-left: 5px;" href="#" title="" class="send-btn btn btn-sm btn-primary">Показать</a>'
		+ '</div>').insertAfter(".datepickers-container .datepicker .datepicker--content");
	$(".datepickers-container .datepicker .datepicker--bottom-button .send-btn").on("click", function() {
		$("select[name='ttn_komment']").prop("disabled", true);
		$("#money-search-form").submit();
		return false;
	});


	var statusColors = [];
	$("select#lead-status option").each(function(index) {
		var color = $(this).text().split("=#"),
			label = color[0];
		statusColors[index] = "#" + color[1];
		$(this).text(label);
	});
	$("select#lead-status").multiselect({
		numberDisplayed: 1,
		allSelectedText: 'Все',
		nSelectedText: " выбрано",
		nonSelectedText: "-Не выбрано-",
		buttonClass: "btn btn-default lead-status-button",
		templates: {
			ul: '<ul class="multiselect-container dropdown-menu lead-status-container"></ul>',
		},
		onChange: function (option, checked) { },
		onDropdownHidden: function (event) {
			$("select[name='ttn_komment']").prop("disabled", true);
			$("#money-search-form").submit();
		}
	});
	// раскрашивание выпадающего списка
	$(".lead-status-container li").each(function(index) {
		$(this).css("background-color", statusColors[index]);
	});

	$("#money-search-form input[name^='MoneySearch']").on("keyup", function(e) {
		if (e.keyCode == 13) {
			$("select[name='ttn_komment'], .money-table-checkbox").prop("disabled", true);
			$("#money-search-form").submit();
		}
		return false;
	});

	// filter's options
	$(".money-filter-container .btn-filter").on("click", function() {
		// die, die, die fucking filter!


	});
	/*--------------------------------------------------------------------------------------------*/

	$('.update_leads_btn').on('click', function(){
		var start =  false;
		$(this).children("i").addClass("gly-spin");
		var updateMoney = function updating() {
			$.ajax({
				dataType: "json",
				data: {date_period : $('.date-period-selector').val()},
				url: $("#money-search-form").data("url_all_update")
			}).done(function(data) {
				if (data.code == 1) {
					setTimeout(updateMoney, 100);
				} else {
					if (data.code == 0) {
						$(".update_leads_btn i").removeClass("gly-spin");
						jModal.Alert("Обновление успешно завершено", "Завершено");
						setTimeout(function() {
							location.reload();
						}, 1000);
					}
					if (data.code == 2) {
						start = false;
						$(".update_leads_btn i").removeClass("gly-spin");
						jModal.Alert("Нет данных для обновления за этот месяц", "Ошибка");
					}
				}
			});
		};
		if (!start) {
			start = true;
			updateMoney();
		};
		return false;
	})
});
