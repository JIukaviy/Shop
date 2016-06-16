/**
 * Created by Никита on 14.06.2016.
 */

var cart = (function () {
    "use strict";
    var cache;
    var onchange_listener = function () {};
    var onempty_listener = function () {};
    function compose_listeners(c1, c2) {
        return function () {
            c1();
            c2();
        }
    }
    return {
        get_items : function () {
            return Cookies.getJSON('cart');
        },
        set_items : function (items) {
            Cookies.set('cart', items);
            if (onchange_listener) {
                onchange_listener();
            }
            if (cart.unique_count() == 0) {
                onempty_listener();
            }
        },
        add_item : function (item_id, count) {
            if (!count) {
                count = 1;
            }
            var c = cart.get_items();
            if (!c) {
                c = {};
            }
            if (c[item_id]) {
                c[item_id] += count;
            } else {
                c[item_id] = count;
            }
            cart.set_items(c);
        },
        set_item : function (item_id, count) {
            var c = cart.get_items();
            c[item_id] = count;
            cart.set_items(c);
        },
        remove_item : function (item_id) {
            var c = cart.get_items();
            delete c[item_id];
            cart.set_items(c);
        },
        clear : function () {
            Cookies.remove('cart');
            cache = undefined;
            onchange_listener();
            onempty_listener();
        },
        unique_count : function () {
            var items = cart.get_items();
            if (items) {
                return Object.keys(items).length;
            } else {
                return 0;
            }
        },
        count : function () {
            var items = cart.get_items();
            if (items) {
                let res = 0;
                for (let key in items) {
                    if (items.hasOwnProperty(key)) {
                        res += +items[key];
                    }
                }
                return res;
            } else {
                return 0;
            }
        },
        get_items_info () {
            var dfd = $.Deferred();
            var items = cart.get_items();
            if (items == undefined || Object.keys(items).length == 0) {
                dfd.reject('Корзина пуста');
            } else if (cache) {
                let items_info = {};
                for (let i in items) {
                    if (items.hasOwnProperty(i)) {
                        items_info[i] = cache[i];
                        items_info[i]['count'] = items[i];
                    }
                }
                dfd.resolve(items_info);
            } else {
                var request_data = [];
                for (let i in items) {
                    if (items.hasOwnProperty(i)) {
                        request_data.push({'id': i});
                    }
                }
                api.get_items_info(request_data).done(function (data) {
                    cache = {};
                    for (let i in data) {
                        if (data.hasOwnProperty(i)) {
                            cache[i] = data[i];
                        }
                    }
                    dfd.resolve(data);
                }).fail(function (message) {
                    dfd.reject(message);
                });
            }
            return dfd;
        },
        confirm_order : function () {
            if (cart.is_empty()) {
                return $.Deferred().reject('Корзина пуста').promise();
            }
            var items = cart.get_items();
            return api.add_order(items);
        },
        is_empty : function () {
            var items = cart.get_items();
            return items == undefined || Object.keys(items).length == 0;
        },
        get_cart_info : function () {
            var dfd = $.Deferred();
            if (cart.is_empty()) {
                dfd.resolve(0, 0);
            } else {
                cart.get_items_info().done(function (items_info) {
                    var total_price = 0;
                    for (let i in items_info) {
                        if (items_info.hasOwnProperty(i)) {
                            total_price += +items_info[i]['price'] * +items_info[i]['count'];
                        }
                    }
                    dfd.resolve(cart.count(), total_price);
                }).fail(function (message) {
                    dfd.reject(message);
                });
            }
            return dfd;
        },
        draw : function (parent, template, custom_draw_func) {
            let dfd = $.Deferred();
            if (cart.is_empty()) {
                onempty_listener();
            } else {
                cart.get_items_info().done(function (data) {
                    let items_info = data;
                    var items = cart.get_items();
                    for (let item_id in items_info) {
                        if (items_info.hasOwnProperty(item_id)) {
                            let new_item_row = template.clone();
                            let item_info = items_info[item_id];

                            item_info['count'] = +items[item_id];

                            custom_draw_func(new_item_row, item_info);

                            new_item_row.css("display", "block");
                            new_item_row.appendTo(parent);
                        }
                    }
                    dfd.resolve();
                }).fail(function (message) {
                    dfd.reject(message);
                });
            }
            return dfd.promise();
        },
        onchange : function (event_listener) {
            return onchange_listener = compose_listeners(onchange_listener, event_listener);
        },
        onempty : function (event_listener) {
            return onempty_listener = compose_listeners(onempty_listener, event_listener);
        },
        dispatch_onchange : function () {
            onchange_listener();
        }
    }
})();
