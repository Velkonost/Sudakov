/**
 * jQuery Bootstrap modals (Alert and Question).
 *
 * jModal.Alert("Hello user", "Welcome!");
 * jModal.Question("I'll install some stupid app. Are you agree?", "Ask", ["yes-green","no-red"], function(button, data) {
 *		if (button == "no") {
 *			jModal.Alert("I don't care about your answer " + data.ha + "!", "Warning");
 *		}
 *	}, {"ha":"HAHAHA"});
 *
 * Buttons codes: "ok", "cancel", "yes", "no", "accept", "yes-red", "yes-green", "no-green", "no-red", "delete"
 *
 * @author who cares?
 */
window.jModal = {

    /**
     * Displays Alert message
     */
    "Alert": function(message, title) {
        title = title || "Alert";
        message = message || "empty message";
        if ($("#alertModal").length == 0) {
            $("body").append(
                '<div id="alertModal" class="modal fade">' +
                '<div class="modal-dialog">' +
                '<div class="modal-content">' +
                '<div class="modal-header">' +
                '<h4 class="modal-title">Alert</h4>' +
                '</div>' +
                '<div class="modal-body">' +
                '<p>Message</p>' +
                '</div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-success" data-dismiss="modal">OK</button>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>');
            var $i18n = $("#modals-i18n"); // check i18n tag
            if ($i18n.length > 0) {
                $("#alertModal .modal-footer .btn-success").text($i18n.data("btn_ok"));
            }
        }
        $("#alertModal").find('.modal-title').text(title);
        $("#alertModal").find('.modal-body p').html(message);
        $("#alertModal").modal('show');
    },

    /**
     * Displays Question dialogue (Prompt)
     * @param message
     * @param title
     * @param buttons Minimum 2 buttons names: "ok", "cancel", "yes", "no", "accept", "yes-red", "yes-green", "no-green", "no-red" ...
     */
    "Question": function(message, title, buttons, callback, data) {
        title = title || "Alert";
        message = message || "empty message";
        buttons = $.isArray(buttons) ? buttons : ['ok', 'cancel'];
        jModal.Question.callback = $.isFunction(callback) ? callback : function(button, data) { console.log("You pressed " + button + " button"); };
        jModal.Question.data = data;
        if ($("#questionModal").length == 0) {
            $("body").append(
                '<div id="questionModal" class="modal fade">' +
                '<div class="modal-dialog">' +
                '<div class="modal-content">' +
                '<div class="modal-header">' +
                '<h4 class="modal-title">Question</h4>' +
                '</div>' +
                '<div class="modal-body">' +
                '<p>Message</p>' +
                '</div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-primary btn-ok" data-name="ok">OK</button>' +
                '<button type="button" class="btn btn-primary btn-yes" data-name="yes">Yes</button>' +
                '<button type="button" class="btn btn-danger btn-yes-red" data-name="yes">Yes</button>' +
                '<button type="button" class="btn btn-success btn-yes-green" data-name="yes">Yes</button>' +
                '<button type="button" class="btn btn-success btn-accept" data-name="accept">Accept</button>' +
                '<button type="button" class="btn btn-primary btn-cancel" data-name="cancel">Cancel</button>' +
                '<button type="button" class="btn btn-primary btn-no" data-name="no">No</button>' +
                '<button type="button" class="btn btn-danger btn-no-red" data-name="no">No</button>' +
                '<button type="button" class="btn btn-success btn-no-green" data-name="no">No</button>' +
                '<button type="button" class="btn btn-danger btn-delete" data-name="delete">Delete</button>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>');
            // check i18n
            var $i18n = $("#modals-i18n"); // check i18n tag
            if ($i18n.length > 0) {
                // for example: <meta id="modals-i18n" data-btn_accept="D'accord" data-btn_cancel="Отмена" />
                // for example: <meta id="modals-i18n" data-btn_accept="<?= Yii::t('app', 'Accept') ?>" ... />
                $("#questionModal .modal-footer .btn").each(function(i, btn) {
                    var key = "btn_" + $(btn).data("name");
                    $i18n.data(key) && $(btn).text($i18n.data(key));
                });
            }
            // bind events
            $("#questionModal .btn").on("click", function(){
                var button = $(this).data("name");
                $("#questionModal").modal('hide');
                if ($.isFunction(jModal.Question.callback)) {
                    jModal.Question.callback.call(this, button, jModal.Question.data);
                }
            });
        }
        $("#questionModal").find('.modal-title').text(title);
        $("#questionModal").find('.modal-body p').html(message);
        $("#questionModal").find('.btn').addClass("hide");
        $.each(buttons, function(index, button) {
            $("#questionModal").find('.btn-' + button).removeClass("hide");
        });
        $("#questionModal").modal('show');

    }
};