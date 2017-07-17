
define(['jquery'], function($){

    return function () {
 		var self = this,
			managerReact = true,
			initialized = false,
			messageBoxIsOpen = false,
			timeoutId = null,
			timeoutSec = 0,
			TIMEOUT_DELAY = 30, // ожидание ответа менеджера (30 сек)
			REQUEST_DELAY = 20, // периодичность запросов к серверу (20 секунд)
			managerId = 0;
		const domainName = 'http://erp.sergeysudakov.ru';

		// отправка ответа на сервер
		self.setLeadStatus = function(leadId, managerId, status, domainName, self, callback) {
			callback = callback || function() {};
			var data = {"manager_id": managerId, "lead_id": leadId, "status": status};
			console.log('Запрос: ' + domainName + '/amo/set-allocation', data);
			self.crm_post(domainName + '/amo/set-allocation', data,
				function (json) {
					if(json.status == 200) {
						console.log('Ответ:', json);
					} else {
						console.log('Ответ с ошибкой:', json);
					}
					callback();
				}, 'json'
			);
		};

		// запрос на наличие заявки для менеджера
		self.watchRequest = function() {
			if (messageBoxIsOpen === true || !initialized) {
				// если виджет еще не инициализирован или открыто диалоговое окно, то не отправляем запрос
				console.log("messageBoxIsOpen, initialized", messageBoxIsOpen, initialized);
				return;
			}
			console.log('Запрос: ' + domainName + '/amo/allocation-request', {"manager_id": managerId});
			//Сделаем запрос на удаленный сервер для проверки появилась ли новая заявка
			self.crm_post(
				domainName + '/amo/allocation-request',
				{"manager_id": managerId},
				function (json) {
					console.log('Ответ:', json);
					if (json.status && json.status == 200) {
						messageBoxIsOpen = true;
						$("#aw-timeout-value").text(TIMEOUT_DELAY);
						$("#aw_lead_id").data("lead_id", json.lead.id);
						$('.newLeadName').html(json.lead.name);
						$('.pop.messagepop').show();
						// отсчитываем 30 секунд
						timeoutSec = 0;
						timeoutId = setInterval(function() {
							if (timeoutSec < TIMEOUT_DELAY) { // если прошло меньше времени, чем требуется, то продолжаем ждать ответ
								timeoutSec++;
								$("#aw-timeout-value").text("(" + (TIMEOUT_DELAY - timeoutSec) + ")");
								return;
							}
							clearTimeout(timeoutId); // удаляем таймер
							// Если менеджер не успел что-то нажать (Да/Нет) то закрываем окно и отправляем пропуск заявки на сервер
							$('.pop.messagepop').hide();
							if (!managerReact) {
								self.setLeadStatus(json.lead.id, managerId, 1, domainName, self, function() {
									managerReact = false;
									messageBoxIsOpen = false;
								});
							}
						}, 1000);
					}
				}, 'json'
			);
		};

		self.callbacks = {

			render: function() {
				console.log('render');
				return true;
			},

			init: function() {
				initialized = true;
				console.log('init', initialized);
				managerId = AMOCRM.constant("user").id;
				console.log('managerId', managerId);
				var selfCode = self.get_settings().widget_code;
				// шаблон диалога
				var template = '\
					<link type="text/css" rel="stylesheet" href="/upl/' + selfCode + '/widget/style.css" >\
					<div class="messagepop pop">\
						<form class="AW-questionForm">\
							<div><div class="AW-leadId" id="aw_lead_id" data-lead_id="0">Поступила новая заявка:\
							 		<div class="newLeadName"></div>\
							 		<div>Принять заявку?</div>\
							 		</div>\
								<div class="aw-buttons">\
									<a href="#!" class="aw-answer-button" data-answer="3">Да</a>\
									<a href="#!" class="aw-answer-button" data-answer="2">Нет</a>\
									<span id="aw-timeout-value">(' + TIMEOUT_DELAY + ')</span>\
								</div>\
							</div>\
						</form>\
					</div>';
				$('body').append(template);
                // Менеджер принял или отказался от заявки на виджете
                $('.aw-answer-button').on("click", function() {
					clearTimeout(timeoutId);
                    var answer = $(this).data("answer"),
						leadId = $("#aw_lead_id").data("lead_id");
                    // Закроем окно
                    $('.messagepop.pop').hide();
					self.setLeadStatus(leadId, managerId, answer, domainName, self, function() {
						managerReact = false;
						messageBoxIsOpen = false;
					});
                    return false;
                });
				return true;
			},

			bind_actions: function() {
				console.log('bind_actions');
				return true;
			},

			settings: function() {
				console.log('settings');
				return true;
			},

			onSave: function() {
				console.log('onSave');
				return true;
			},

			destroy: function() {
				return true;
			},

			contacts: {
				//select contacts in list and clicked on widget name
				selected: function(){
					console.log('contacts');
				}
			},
			leads: {
				//select leads in list and clicked on widget name
				selected: function(){
					console.log('leads');
				}
			},

			tasks: {
				//select taks in list and clicked on widget name
				selected: function(){
					console.log('tasks');
				}
			}
		};

		// периодические запросы к серверу
		if (self.AW_INTERVAL) clearInterval(self.AW_INTERVAL);
		self.AW_INTERVAL = setInterval(self.watchRequest, REQUEST_DELAY * 1000);

		return self;
    };

});