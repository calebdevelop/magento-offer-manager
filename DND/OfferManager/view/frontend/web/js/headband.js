define(['jquery', 'uiComponent', 'ko', 'mage/url', 'owlcarousel'], function ($, Component, ko, urlBuilder) {
        'use strict';
        return Component.extend({
            defaults: {
                headbands: [],
            },
            initObservable: function () {
                this._super()
                .observe([
                    'headbands'
                ]);
                return this;
            },
            initialize: function () {
                var self = this;
                this._super();

                $.ajax({
                    url: urlBuilder.build('offer/headband/index/category/' + this.category_id),
                    async: false
                }).done(function (data) {
                    self.headbands = data;
                });
                return this;
            },
            getData: function () {
                return this.headbands;
            },
            carousel: function () {
                setTimeout(function () {
                    $('body').find('.owl-carousel').owlCarousel({
                        items: 1,
                        nav: true,
                        navText: [
                            '<i class="owl-prev"></i>',
                            '<i class="owl-next"></i>'
                        ]
                    });
                }, 4000);

            }
        });
    }
);
