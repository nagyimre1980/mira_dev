(function($) {
    // Ellenőrizzük, hogy a Select2 be van-e töltve
    if (!$.fn.select2 || !$.fn.select2.amd) {
        console.error("Select2 nincs betöltve! A select2-emre-tweaks.js-t a select2.js után kell betölteni.");
        return;
    }

    // Rácsatlakozunk a Select2 belső moduljaira (hozzáadva a SelectAdapter a javításhoz)
    $.fn.select2.amd.require([
        'select2/results',
        'select2/dropdown/attachBody',
        'select2/dropdown/search',
        'select2/selection/single',
        'select2/selection/multiple',
        'select2/core',
        'select2/utils',
        'select2/data/select' 
    ], function (Results, AttachBody, Search, SingleSelection, MultipleSelection, Select2Core, Utils, SelectAdapter) {

        // --- 1. Mouseup helyett Click a listaelemeknél (és Toggle javítás) ---
        var origResultsBind = Results.prototype.bind;
        Results.prototype.bind = function (container, $container) {
            origResultsBind.apply(this, arguments);

            var self = this;
            this.$results.off('mouseup', '.select2-results__option--selectable');
            
            this.$results.on('click', '.select2-results__option--selectable', function (evt) {
                var $this = $(this);
                var data = Utils.GetData(this, 'data');

                if ($this.hasClass('select2-results__option--selected')) {
                    if (self.options.get('multiple')) {
                        self.trigger('unselect', { originalEvent: evt, data: data });
                    } else {
                        self.trigger('close', {});
                    }
                    return;
                }
                self.trigger('select', { originalEvent: evt, data: data });
            });

            container.on('results:toggle', function () {
                var $highlighted = self.getHighlightedResults();
                if ($highlighted.length > 0) {
                    $highlighted.trigger('click');
                }
            });
        };

        // --- 2. Dropdown pozicionálás (Ne ragadjon be felfelé) ---
        var origPositionDropdown = AttachBody.prototype._positionDropdown;
        AttachBody.prototype._positionDropdown = function () {
            this.$dropdown[0].classList.remove('select2-dropdown--above');
            origPositionDropdown.apply(this, arguments);
        };

        // --- 3. Margin-top átemelése az eredeti elemről ---
        var origPlaceContainer = Select2Core.prototype._placeContainer;
        Select2Core.prototype._placeContainer = function ($container) {
            origPlaceContainer.apply(this, arguments);
            var margin_top = this.$element.css('margin-top');
            if (margin_top != null && margin_top !== '0px') {
                $container.css('margin-top', margin_top);
            }
        };

        // --- 4. Keresőmező maxlength, name attribútum, és UI Tooltip törlése ---
        var origSearchRender = Search.prototype.render;
        Search.prototype.render = function (decorated) {
            var $rendered = origSearchRender.apply(this, arguments);
            var maxLen = this.options.get('maximumInputLength');
            if (maxLen > 0) {
                this.$search.attr('maxlength', maxLen);
            }
            this.$search.attr('name', 'select2_search');
            return $rendered;
        };

        var origSearchBind = Search.prototype.bind;
        Search.prototype.bind = function (decorated, container, $container) {
            origSearchBind.apply(this, arguments);
            this.$search.on('keyup input', function () {
                $('.ui-tooltip').remove();
            });
        };

        // --- 5. Tooltip (title) letiltása, ha nincs kifejezetten megadva ---
        var origSingleUpdate = SingleSelection.prototype.update;
        SingleSelection.prototype.update = function (data) {
            origSingleUpdate.apply(this, arguments);
            if (data.length === 0) return;
            var selection = data[0];
            if (!selection.title) {
                this.$selection.find('.select2-selection__rendered').removeAttr('title');
            }
        };

        var origMultipleUpdate = MultipleSelection.prototype.update;
        MultipleSelection.prototype.update = function (data) {
            origMultipleUpdate.apply(this, arguments);
            var $choices = this.$selection.find('.select2-selection__choice');
            for (var d = 0; d < data.length; d++) {
                if (!data[d].title) {
                    $choices.eq(d).removeAttr('title');
                }
            }
        };

        // --- 6. Select2 4.1.0 AJAX normalizációs gyári bug javítása ---
        SelectAdapter.prototype._normalizeItem = function (item) {
            if (item !== Object(item)) {
                item = { id: item, text: item };
            }
            item = $.extend({}, { text: '' }, item);
            var defaults = { selected: false, disabled: false };
            
            if (item.id != null) { item.id = item.id.toString(); }
            if (item.text != null) { item.text = item.text.toString(); }

            // BIZTONSÁGI JAVÍTÁS: Ellenőrizzük a 'this' meglétét, mielőtt a container-re hivatkozunk
            if (this && item._resultId == null && item.id && this.container != null) {
                item._resultId = this.generateResultId(this.container, item);
            }

            if (item.children) {
                // Átadjuk a biztonságos kontextust a beágyazott elemekhez is
                var self = this || {};
                item.children = item.children.map(function(child) {
                    return SelectAdapter.prototype._normalizeItem.call(self, child);
                });
            }

            return $.extend({}, defaults, item);
        };

    });
})(jQuery);