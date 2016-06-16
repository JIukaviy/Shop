/**
 * Created by Никита on 14.06.2016.
 */

var api = (function () {
    "use strict";
    function set_listeners(promise) {
        var dfd = $.Deferred();
        promise.done(function (data) {
            if (data['success']) {
                dfd.resolve(data['data']);
            } else {
                dfd.reject(data['error']);
            }
        }).fail(function () {
            dfd.reject('Сервер не отвечает');
        });
        return dfd.promise();
    }
    return {
        get_items_info : function (id) {
            return set_listeners($.ajax({
                method: "POST",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                url: "/api/get_item_info",
                data: JSON.stringify({'data': id})
            }));
        },
        add_order : function (order) {
            return set_listeners($.ajax({
                method: "POST",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                url: "/api/add_order",
                data: JSON.stringify({'data': order})
            }));
        }
    }
})();