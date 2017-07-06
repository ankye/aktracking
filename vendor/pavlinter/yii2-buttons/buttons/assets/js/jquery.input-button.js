(function($) {

    var InputButton = function (element, options) {
        var self = this;
        self.$el = $(element);
        self.init(options);
    }

    InputButton.prototype = {
        constructor: InputButton,
        init: function (options) {
            var self = this, $el = self.$el;
            $el.on("click.inputButton", function(e){
                var $inp = $("#" + options.inputId), $form = $(options.formSelector);
                $inp.remove();
                var submit = false;
                if(options.inputValue !== null){
                    $inp = $(options.inputTemplate);
                    $form.append($inp);
                    $inp.val(options.inputValue);
                    var event = $.Event("change.inputButton");
                    $inp.trigger(event, [self, options]);
                    if(event.result !== false) {

                        submit = true;
                    }
                } else {
                    submit = true;
                }

                if(submit){
                    if(self.hasFormValidation()){
                        if($form[0].checkValidity()){
                            $form.submit();
                        } else {
                            return true;
                        }
                    } else {
                        $form.submit();
                    }
                    return false;
                }
                return false;
            });
        },
        destroy: function () {
            var self = this, $el = self.$element;
            $el.off('.inputButton').removeData('inputButton');
        },
        hasFormValidation: function () {
            return (typeof document.createElement( 'input' ).checkValidity == 'function');
        }
    };

    $.fn.inputButton = function (option) {
        var args = Array.apply(null, arguments);
        args.shift();
        return this.each(function () {
            var $this = $(this),
                data = $this.data("inputButton"),
                options = typeof option === "object" && option;

            if (!data) {
                $this.data("inputButton", (data = new InputButton(this, $.extend({}, $.fn.inputButton.defaults, options, $(this).data()))));
            }

            if (typeof option === "string") {
                data[option].apply(data, args);
            }
        });
    };

    $.fn.inputButton.defaults = {};

})(jQuery);