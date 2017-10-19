/**
 * GoMage LegalPerson Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2017 GoMage (https://www.gomage.com)
 * @author       GoMage
 * @license      https://www.gomage.com/license-agreement/  Single domain license
 * @terms of use https://www.gomage.com/terms-of-use
 * @version      Release: 1.0.0
 * @since        Class available since Release 1.0.0
 */
if (typeof GoMage == 'undefined') GoMage = {};

GoMage.LegalPerson = function (config, wrapper, countryElementId) {
    'use strict';
    this.config = config;
    this.wrapper = wrapper;
    this.countryElementId = countryElementId;
    this.switchersEvents = [];
    this.initSwitchersEvents();
};

GoMage.LegalPerson.prototype = {

    initSwitchersEvents: function () {
        $$('.' + this.config.switcher.name).each(function (switcher) {
            this.bindSwitcherEvent(switcher);
        }.bind(this));
    },
    bindSwitcherEvent: function (switcher) {
        if (this.switchersEvents.indexOf(switcher.id) == -1) {
            this.switchersEvents.push(switcher.id);
            switcher.observe('change', function (e) {
                var elm = e.target || e.srcElement;
                this.change(elm);
            }.bind(this));
        }
    },
    onAddressCountryChanged: function (countryElement) {
        var switcher = $(countryElement.id.replace(this.countryElementId, this.config.switcher.name));
        if (switcher) {
            this.bindSwitcherEvent(switcher);
            if (this.config.countries.indexOf(countryElement.value) != -1) {
                this.showField(switcher.id, this.config.switcher.required);
                this.change(switcher);
            }
            else {
                this.hideField(switcher.id);
                this.config.natural.each(function (field) {
                    this.hideField(countryElement.id.replace(this.countryElementId, field.name));
                }.bind(this));
            }
        }
    },
    hideField: function (fieldId) {
        var field = $(fieldId);
        if (field) {
            while (field.hasClassName('required-entry')) {
                field.removeClassName('required-entry');
            }
            field.disable();
            field.up(this.wrapper).hide();
        }
    },
    showField: function (fieldId, required) {
        var field = $(fieldId);
        if (field) {
            field.enable();
            field.up(this.wrapper).show();
            var requiredElement = field.up(1).down('label > span.required') ||
                field.up(1).down('label > em');
            if (required) {
                field.addClassName('required-entry');
                if (requiredElement) {
                    requiredElement.show();
                    requiredElement.up('label').addClassName('required');
                }
            } else {
                while (field.hasClassName('required-entry')) {
                    field.removeClassName('required-entry');
                }
                if (requiredElement) {
                    requiredElement.hide();
                    while (requiredElement.up('label').hasClassName('required')) {
                        requiredElement.up('label').removeClassName('required');
                    }
                }
            }
        }
    },
    change: function (switcher) {
        var fields = [];
        if (parseInt(switcher.value) == 1) {
            //LEGAL
            fields = this.config.legal;
        } else {
            //NATURAL
            fields = this.config.natural;
        }
        fields.each(function (field) {
            var fieldId = switcher.id.replace(this.config.switcher.name, field.name);
            if (field.enabled) {
                this.showField(fieldId, field.required);
            } else {
                this.hideField(fieldId);
            }
        }.bind(this));
    }

};