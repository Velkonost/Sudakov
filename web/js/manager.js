
$(document).ready(function(){

    if ($(".diagram-container").length > 0) {

        $.jsDate.regional['ru'] = {
            monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
            dayNames: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
            dayNamesShort: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
            formatString: '%d-%m-%Y %H:%M:%S'
        };

        // Do not forget to call
        $.jsDate.regional.getLocale();

        $("#custom-period").datepicker({
            timeFormat: "dd.mm.yyyy",
            onHide: function (dp, animationCompleted) {
                if (!animationCompleted) {
                    getLeads();
                    getFacts();
                }
            },
            multipleDatesSeparator: "-",
            range: true
        });

        var globalSeriesLabels,
            showLegend = false;
        if ($("#custom-period").data("date") != "") {
            var dateStrings = explode("-", $("#custom-period").data("date"));
            if (dateStrings.length > 1) {
                // две даты
                var date1 = new Date(parseIDate(dateStrings[0])),
                    date2 = new Date(parseIDate(dateStrings[1]));
                if (dateIsValid(date1) && dateIsValid(date2)) {
                    $("#custom-period").datepicker().data('datepicker').selectDate([date1, date2]);
                    getFacts();
                }
            } else {
                // одна дата
                var date1 = new Date(parseIDate(dateStrings[0]));
                if (dateIsValid(date1)) {
                    $("#custom-period").datepicker().data('datepicker').selectDate(date1);
                    getFacts();
                }
            }
        }

        // На клик чекбокса обновлять графики и изменять цвет самого чекбокса
        $(".mainPage-rightBlock-body-Checkbox").on("change", function () {
            getLeads();
            var id = $(this).attr("color");
            if ($(".ch-" + id).prop("checked")) {
                $(".id-" + id).addClass("color" + id + " colored");
            } else {
                $(".id-" + id).removeClass("color" + id + " colored");
            }
        });
        $(".cb-metriks.ch-1").prop("checked", true);
        $(".cb-metriks.ch-1").trigger("change");

        getFacts();
        // При клике на чекбокс раздела переключаются все дочерние чекбоксы
        $(".caption-checkbox").on("click", function () {
            var name = $(this).attr("id").substr(22);
            $(".cb-" + name).prop("checked", $(this).prop("checked"));
            if ($(this).prop("checked")) {
                $(".cb-" + name).each(function (j, o) {
                    $(o).parent().addClass("color" + $(o).attr("color") + " colored");
                });
            } else {
                $(".cb-" + name).each(function (j, o) {
                    $(o).parent().removeClass("color" + $(o).attr("color") + " colored");
                });
            }
            getLeads();
        });

        // При клике на шапку раздела - схлопываем или расхлопываем её
        $(".main-page-right_block-header").on("click", function (e) {
            var $i = $(this).find("i");
            if ($i.hasClass("fa-caret-down")) {
                $i.removeClass("fa-caret-down").addClass("fa-caret-up");
            } else {
                $i.removeClass("fa-caret-up").addClass("fa-caret-down");
            }
            $(this).parent().find(".main-page-right_block-body").slideToggle();
        });

        // Нажата кнопка выбора периода
        $(".diagram_buttons button.period-buttons").on('click', function () {
            // Buttons now stay active after clicked
            if (!$(this).hasClass("active")) {
                $(".diagram_buttons button.period-buttons").each(function () {
                    $(".diagram_buttons button.period-buttons").removeClass('active');
                });
                $(".datepicker-here").val("");
                $(this).addClass("active");
            }
            getLeads();
            getFacts();
        });

        // прячем легенду если по ней кликнуть (для мобильных)
        $("body").on("click", "table.jqplot-table-legend", function () {
            $("table.jqplot-table-legend").hide();
            return false;
        });

        //Group dropdown list item selected
        $(".group_by").on("click", function () {
            var $diagram_toggle = $(".diagram-dropdown-toggle");
            $diagram_toggle.html($(this).html() + ' <span class="caret"></span>');
            $(".group_by").removeClass('active');
            $(this).addClass("active");
            getLeads();
        });

        function getLeads() {
            $.ajax({
                url: $(".diagram-container").data("url"),
                dataType: "json",
                data: getDiagramParamsToSent(),
                success: function (data) {
                    if (data.code == 0) {
                        allData = data.result;
                        isSameDay = data.is_same_day;
                        if (plot3 == null) {
                            createPlot3(data.start, data.finish);
                            for (var i = 0; i < data.labels.length; i++) {
                                data.labels[i] = {label: data.labels[i]};
                            }
                            globalSeriesLabels = data.labels;
                        } else {
                            for (var i = 0; i < data.labels.length; i++) {
                                data.labels[i] = {label: data.labels[i]};
                            }
                            plot3.replot({
                                data: data.result,
                                axes: {
                                    xaxis: {
                                        min: data.start,
                                        max: data.finish,
                                        tickOptions: {
                                            formatString: isSameDay ? "%H час" : "%d-%m-%Y"
                                        },
                                    },
                                    yaxis: {
                                        min: 0,
                                        max: 100
                                    }
                                },
                                series: data.labels,
                                seriesColors: data.colors,
                                legend: {show: showLegend}
                            });
                            globalSeriesLabels = data.labels;
                            $(".jqplot-table-legend").addClass("hidden");
                        }
                        refreshAxisGroups();
                    } else {

                        console.error('При загрузке данных диаграммы произошла непредвиденная ошибка');
                    }
                }
            });
        }

        function getSelectedPeriod() {
            var $period = $(".diagram_buttons button.active");
            return ($period.length > 0) ? $period.attr('period') : $("#custom-period").val();
        }

        // Центр обработки параметров для ajax запросов
        function getDiagramParamsToSent() {
            return {
                period: getSelectedPeriod(),
                group_by: $(".group_by.active").attr('id') != undefined ? ($(".group_by.active").attr('id')).substr(12) : 'day',
                type: $("#right_block_form").serializeArray()
            };
        }

        var allData = [], isSameDay = false;
        //var plot3 = null;
        window.plot3 = null; // for tests

        var refreshAxisGroups = function () {
            if (plot3 !== null) {
                plot3.axisGroups = [];
                var s, temp = [], ax, i = 0;
                for (; i < plot3.series.length; i++) {
                    s = plot3.series[i];
                    ax = s.xaxis + ',' + s.yaxis;
                    if ($.inArray(ax, temp) == -1) {
                        temp.push(ax);
                    }
                }
                for (i = 0; i < temp.length; i++) {
                    plot3.axisGroups.push(temp[i].split(','));
                }
            }
        };

        function createPlot3(startDate, finishDate) {
            // @see web/js/jqplot/src/jqPlotOptions.txt
            plot3 = $.jqplot("main_chart", [[[["2000", 2], ["2016", 40]]]], {
                //height: 400,
                width: "100%",
                title: "",
                series: [{label: 'Лиды'}],
                seriesColors: ["#372a79"],
                dataRenderer: function () {
                    return allData;
                },
                seriesDefaults: {
                    showMarker: false,
                    shadow: false,
                    lineWidth: 1.6
                },
                grid: {
                    background: "#fff",
                    shadow: false,
                    borderWidth: 0.3
                },
                // gridPadding: {
                //     top: 20,
                //     bottom: 20,
                //     left: 20,
                //     right: 20
                // },
                axes: {
                    xaxis: {
                        renderer: $.jqplot.DateAxisRenderer,
                        tickOptions: {
                            formatString: isSameDay ? "%H час" : "%d-%m-%Y"
                        },
                        min: startDate,
                        max: finishDate
                    },
                    yaxis: {
                        forceTickAt0: true,
                        pad: 0,
                        tickInterval: 10,
                        tickOptions: {
                            formatString: function () {
                                return '%s';
                            },
                            formatter: $.jqplot.LabelFormatter
                        },
                        min: 0,
                        max: 100,
                        showMinorTicks: true
                    }
                },
                legend: {
                    show: false,
                    location: 's',
                    placement: 'outside',
                    fontSize: '11px'
                },
                cursor: {
                    show: false,
                    //zoom: true,
                    tooltipOffset: 10,
                    tooltipLocation: 'nw'
                }
            });
            plot3.axes.yaxis.tickOptions.showGridline = true;
            refreshAxisGroups();
        }

        $(window).on("resize", function () {
            plot3.replot();
        });

        $.jqplot.LabelFormatter = function (format, val) {
            return (parseInt(val) > 0) ? parseInt(val) : 0;
        };

        var myDotsCanvas = null
        setDot = function (x, y, color, radius) {
            if (myDotsCanvas === null) {
                myDotsCanvas = $(".jqplot-series-canvas")[0].getContext('2d');
            }
            radius = radius || 20;
            color = color || "#003300";
            myDotsCanvas.beginPath();
            myDotsCanvas.arc(x, y, radius, 0, 2 * Math.PI, false);
            //myDotsCanvas.fillStyle = color;
            //myDotsCanvas.fill();
            myDotsCanvas.lineWidth = 2;
            myDotsCanvas.strokeStyle = color;
            myDotsCanvas.stroke();
        },
            setLine = function (x, color, lineWidth) {
                if (myDotsCanvas === null) {
                    myDotsCanvas = $(".jqplot-series-canvas")[0].getContext('2d');
                }
                color = color || "#555555";
                myDotsCanvas.beginPath();
                myDotsCanvas.lineWidth = lineWidth || 2;
                myDotsCanvas.strokeStyle = color;
                myDotsCanvas.moveTo(x, 0);
                myDotsCanvas.lineTo(x, myDotsCanvas.canvas.height);
                myDotsCanvas.stroke();
            },
            resetDots = function () {
                if (myDotsCanvas === null) return;
                myDotsCanvas.clearRect(0, 0, myDotsCanvas.canvas.width, myDotsCanvas.canvas.height);
            };

        getLeads();

        $("#main_chart").on('jqplotMouseLeave', function (event, gridpos, datapos, neighbor, plot) {
            plot.legend.show = false;
            plot.redraw();
        });

        $("#main_chart").on('jqplotMouseMove', function (event, gridpos, datapos, neighbor, plot) {
            // определяем ближайшую дату к курсору
            var s = "", axes, i = 0, j, formatter, format;
            if (plot.axisGroups.length > 0) {
                for (; i < plot.axisGroups.length; i++) {
                    s = "";
                    axes = plot.axisGroups[i];
                    for (j = 0; j < axes.length; j++) {
                        if (j > 0) s += ', ';
                        formatter = plot.axes[axes[j]]._ticks[0].formatter;
                        //format = plot.axes[axes[j]]._ticks[0].formatString; // old
                        format = isSameDay ? "%d-%m-%Y %H:00" : "%d-%m-%Y";
                        s += formatter(format, datapos[axes[j]]);
                    }
                }
            }
            if (s != "") {
                var dateX = s.split(",")[0],
                    valueY = s.split(",")[1];
                if (!showLegend) {
                    plot.legend.show = true;
                    plot.redraw();
                    showOfLegend = true;
                }
                // ищем нужный индекс в массиве
                var pointIndex = -1, datum, date, thisDate = "", mydots = [];
                if (plot.data.length > 0) {
                    // TODO очищаем все легенды
                    for (var k = 0; k < plot.data.length; k++) {
                        for (i = 0; i < plot.data[k].length; i++) {
                            if (plot.data[k].length > 0 && typeof plot.data[k][i][0] != "undefined") {
                                format = isSameDay ? "%d-%m-%Y %H:00" : "%d-%m-%Y";
                                if(plot.data[k][i][3] !== undefined) {
                                    date = $.jsDate.strftime(plot.data[k][i][0], format);
                                    if (date == dateX) {
                                        pointIndex = i;
                                        thisDate = plot.data[k][i][3];
                                    }
                                }else{
                                    date = $.jsDate.strftime(plot.data[k][i][0], format);
                                    if (date == dateX) {
                                        pointIndex = i;
                                        thisDate = date.split("-").join(".");
                                    }
                                }
                            }
                        }
                        plot.legend._series[k].label = globalSeriesLabels[k].label + ": 0";
                        if (pointIndex >= 0) {
                            if (typeof plot.data[k][pointIndex] != "undefined") {
                                date = plot.data[k][pointIndex][0];
                                var value = typeof plot.data[k][pointIndex][2] == "undefined" ? "0" : plot.data[k][pointIndex][2];
                                plot.legend._series[k].label = globalSeriesLabels[k].label + ": " + value;
                                var mydot = plot.series[k].gridData[pointIndex];
                                mydot.color = plot.series[k].color;
                                mydots.push(mydot);
                            }
                        }
                        pointIndex = -1;
                    }
                    plot.redraw();
                    // отрисовываем точки
                    if (mydots.length > 0) {
                        for (var d = 0; d < mydots.length; d++) {
                            if (d == 0) { // todo line
                            }
                            setDot(mydots[d][0], mydots[d][1], mydots[d].color, 3);
                        }
                        setLine(mydots[0][0], "#777777", 1);
                    }
                    if (thisDate != "") {
                        $(".jqplot-table-legend tbody").prepend("<tr><td colspan='2' style='text-align: center'>" + thisDate + "</td></tr>");
                    }
                } else {
                    plot.legend.show = false;
                    plot.redraw();
                }
                // корректируем позицию легенды
                var $legend = $(".jqplot-table-legend"),
                    width = $(this).width(),
                    left = $(this).offset().left,
                    topOffset = $(this).height(),
                    leftOffset = (event.pageX - left - ($legend.width() / 2));
                if ((leftOffset + $legend.width()) > (left + width)) {
                    leftOffset = left + width - $legend.width();
                }
                if (leftOffset < left) {
                    leftOffset = left;
                }
                $legend.css({"top": topOffset + "px", "left": leftOffset + "px"});
            }
        });

        // обновляет столбец "факт"
        function getFacts() {
            $.ajax({
                url: $("#right_block_form").data("url"),
                dataType: "json",
                data: {period: getSelectedPeriod()},
                success: function (data) {
                    if (data.code == 0) {
                        var facts = data.result;
                        //if(data.result['trade_leads']!=0) {
                        //    facts['trade_CV'] = parseInt(parseFloat(data.result['trade_trade']) * 100 / parseInt(data.result['trade_leads'])) + "%";// Если CV в продажи
                        //}
                        for (var i in facts) {
                            switch (i) {
                                case "money_summary":
                                case "money_bso":
                                case "money_cash":
                                case "money_account":
                                case "money_card":
                                case "money_ya-money":
                                    facts[i] += " Р";
                                    break;

                            }
                            $(".fv_" + i).html(facts[i]);
                        }

                        for (var i in data.result_average) {
                            $(".av_" + i).html(data.result_average[i]);
                        }
                        // Добавляем плановые изменения
                        for (var i in data.changes) {
                            data.changes[i] = data.changes[i] > 0 ? "+" + data.changes[i] : data.changes[i];
                            var $stastusBlock = $(".fc_" + i);
                            $stastusBlock.removeClass("red green");
                            switch (i) {
                                case 'trade_lost':
                                    (data.changes[i] > 0) ? $stastusBlock.addClass("red") : $stastusBlock.addClass("green");
                                    break;
                                default:
                                    (data.changes[i] < 0) ? $stastusBlock.addClass("red") : $stastusBlock.addClass("green");
                            }
                            $(".fc_" + i).html(data.changes[i]);
                        }
                        // Добавляем лиды в города
                        for (var i in data.cities_plan) {
                            var $stastusPlanBlock = $(".fpc_" + i);
                            data.cities_plan[i].changes < 0 ? $stastusPlanBlock.addClass("red") : $stastusPlanBlock.addClass("green");
                            $(".fpv_" + i).html(data.cities_plan[i].value);
                            $stastusPlanBlock.html(data.cities_plan[i].change);
                        }
                        // Процент
                        for (var i in data.ratio) {
                            $(".ratio_" + i).html(data.ratio[i] + " %");
                        }
                    }
                }
            });
        }

        $('<div class="datepicker--bottom-button" style="padding: 10px; background-color: #fffdca; text-align: center;">'
            + '<a style="_margin-left: 5px;" href="#" title="" class="send-btn btn btn-sm btn-primary">Показать</a>'
            + '</div>')
            .insertAfter(".datepickers-container .datepicker .datepicker--content");
        $(".datepicker--bottom-button .send-btn").on("click", function () {
            var myDatepicker = $('#custom-period').datepicker().data('datepicker');
            $(".period-buttons").removeClass("active");
            myDatepicker.hide();
            getLeads();
            getFacts();
            return false;
        });

        function explode(delimiter, string) {
            var emptyArray = {0: ''};
            if (arguments.length != 2
                || typeof arguments[0] == 'undefined'
                || typeof arguments[1] == 'undefined') {
                return null;
            }
            if (delimiter === ''
                || delimiter === false
                || delimiter === null) {
                return false;
            }
            if (typeof delimiter == 'function'
                || typeof delimiter == 'object'
                || typeof string == 'function'
                || typeof string == 'object') {
                return emptyArray;
            }
            if (delimiter === true) {
                delimiter = '1';
            }
            return string.toString().split(delimiter.toString());
        }

        function dateIsValid(d) {
            if (Object.prototype.toString.call(d) === "[object Date]") {
                // it is a date
                if (isNaN(d.getTime())) {  // d.valueOf() could also work
                    // date is not valid
                    return false;
                }
                else {
                    // date is valid
                    return true;
                }
            }
            else {
                // not a date
                return false;
            }
        }

        function parseIDate(date) {
            var dates = explode(".", date);
            date = new Date(dates[1] + "." + dates[0] + "." + dates[2]);
            return date;
        }
    }
});
/**
 * Created by denis on 21.11.2016.
 */
