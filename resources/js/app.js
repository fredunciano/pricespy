/*

/!**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 *!/

require('./bootstrap');

window.Vue = require('vue');

/!**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 *!/

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});
*/

/*
$(".progressbar > span").each(function() {
    $(this)
        .data("origWidth", $(this).width())
        .width(0)
        .animate({
            width: $(this).data("origWidth")
        }, 1200);
});*/

require('./modules/uiTables');

window.getCsrf = function () {
    return $('meta[name=csrf-token]').attr('content');
};

$(document).on('click', '[data-toggle="lightbox"]', function (event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});

//$('.alert').fadeOut(2000);

// @toDo defer it into a module script
const Alert = {
    //var alert, error, info, success, warning, _container;
    info(message, title, options) {
        return this.notify("info", message, title, "icon-info-sign", options);
    },
    warning(message, title, options) {
        return this.notify("warning", message, title, "icon-warning-sign", options);
    },
    error(message, title, options) {
        return this.notify("error", message, title, "icon-minus-sign", options);
    },
    success(message, title, options) {
        return this.notify("success", message, title, "icon-ok-sign", options);
    },
    notify(type, message = '', title, icon, options) {
        var alertElem, messageElem, titleElem, iconElem, innerElem, _container;
        if (typeof options === "undefined") {
            options = {};
        }
        options = $.extend({}, Alert.defaults, options);
        if (!_container) {
            _container = $("#alerts");
            if (_container.length === 0) {
                _container = $("<ul>").attr("id", "alerts").appendTo($("body"));
            }
        }
        if (options.width) {
            _container.css({
                width: options.width
            });
        }
        alertElem = $("<li>").addClass("alert").addClass("alert-" + type);
        setTimeout(function () {
            alertElem.addClass('alert-open');
        }, 1);
        if (icon) {
            iconElem = $("<i>").addClass(icon);
            alertElem.append(iconElem);
        }
        innerElem = $("<div>").addClass("alert-block");
        alertElem.append(innerElem);
        if (title) {
            titleElem = $("<div>").addClass("alert-title").append(title);
            innerElem.append(titleElem);
        }
        if (message) {
            messageElem = $("<div>").addClass("alert-message").append(message);
            innerElem.append(messageElem);
        }
        if (options.displayDuration > 0) {
            setTimeout((function () {
                leave();
            }), options.displayDuration);
        } else {
            innerElem.append("<em>Click to Dismiss</em>");
        }
        alertElem.on("click", function () {
            leave();
        });

        function leave() {
            alertElem.removeClass('alert-open');
            alertElem.one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
                return alertElem.remove();
            });
        }

        return _container.prepend(alertElem);
    }
};

Alert.defaults = {
    width: "",
    icon: "",
    displayDuration: 7500,
    pos: ""
};

['info', 'error', 'success', 'warning'].forEach(key => {
    let obj = $('#alert-' + key);
    if (obj.length) {
        Alert.notify(key, obj.html(), obj.data('title') + '!');
    }
});


$(document).ready(function ($) {
    toggle()
    $(window).resize(function () {
        toggle();
    });

    $('#sidebar-logo-toggle').on('click', function () {
        setTimeout(function () {
            let sidebarWidth = $('#sidebar-scroll').width()
            if ($('#page-container').hasClass('sidebar-visible-xs')) {
                $('#mini-logo').css({'display': 'inline-block'});
                $('#mini-logo-width').css({'display': 'inline-block', 'width': sidebarWidth - 30 + 'px'})
                $('#nav-mobile-logo').hide()
            } else {
                $('#mini-logo').hide();
                $('#nav-mobile-logo').show()
            }
        }, 50)
    })

    if ($(window).width() < 767) {

        $('#page-content').on('click', function () {
            let selector = $('#page-container');
            if (selector.hasClass('sidebar-visible-xs')) {
                selector.removeClass('sidebar-visible-xs')
            }
        })

    }
});

var smallBreak = 767;

function toggle() {
    if ($(window).width() < smallBreak) {
        $('#rightSideTopDropdown').hide();
        $('#user-locale-desktop').hide()
        $('#user-locale').show()
        $('#copyright').hide()
        $('#mobile-sidebar-user-section').show()
        $('#mobile-logout-option').show()
        $('#mobile-settings-nav').show()
        $('#desktop-settings-nav').hide()
        $('#nav-mobile-logo').show();
        $('#sidebar-extra-info').hide();

    } else {
        $('#mini-logo').hide();
        $('#mobile-sidebar-user-section').hide()
        $('#mobile-logout-option').hide()
        $('#mobile-settings-nav').hide()
        $('#user-locale').hide()
        $('#rightSideTopDropdown').show();
        $('#user-locale-desktop').show()
        $('#copyright').show()
        $('#desktop-settings-nav').show()
        $('#nav-mobile-logo').hide()
        $('#sidebar-extra-info').show();
    }
}

"use strict";
(() => {

    const modified_inputs = new Set;
    const defaultValue = "defaultValue";
    // store default values
    addEventListener("beforeinput", (evt) => {
        const target = evt.target;
        if (!(defaultValue in target || defaultValue in target.dataset)) {
            target.dataset[defaultValue] = ("" + (target.value || target.textContent)).trim();
        }
    });
    // detect input modifications
    addEventListener("input", (evt) => {
        const target = evt.target;
        let original;
        if (defaultValue in target) {
            original = target[defaultValue];
        } else {
            original = target.dataset[defaultValue];
        }
        if (original !== ("" + (target.value || target.textContent)).trim()) {
            if (!modified_inputs.has(target)) {
                modified_inputs.add(target);
            }
        } else if (modified_inputs.has(target)) {
            modified_inputs.delete(target);
        }
    });

    $('form').submit(function () {
        window.isSubmitting = true
    })
    addEventListener("beforeunload", (evt) => {
        if (!window.isSubmitting && modified_inputs.size) {
            const unsaved_changes_warning = "You have some unsaved changes";
            evt.returnValue = unsaved_changes_warning;
            return unsaved_changes_warning;
        }
    });


})();
