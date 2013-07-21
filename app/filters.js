'use strict';

/* Filters */

var app = angular.module('myApp.filters', []);

app.filter('interpolate', ['version', function(version) {
        return function(text) {
            return String(text).replace(/\%VERSION\%/mg, version);
        };
    }]);
app.filter('urlify', function() {
    return function(text) {
        return text.replace(/(^\-+|[^a-zA-Z0-9\/_| -]+|\-+$)/g, '')
                .toLowerCase()
                .replace(/[\/_| -]+/g, '-');
    };
});
app.filter('safetitle', function() {
    return function(text) {
        return text.replace(/(^\-+|[^a-zA-Z0-9\/_| -]+|\-+$)/g, '')
                .toLowerCase()
                .replace(/[\/_| -]+/g, '');
    };
});
app.filter('checkmark', function() {
    return function(input) {
        return Number(input) ? '\u2713' : '\u2718';
    };
});
app.filter('label', function() {
    return function(input, type, text) {
        return input ? '<span class="label label-' + type + '">' + text + '</span>' : '';
    };
});
app.filter('type', function() {
    return function(input) {
        switch (input) {
            case '1' :
                return 'text';
            case '2' :
                return 'number';
            case '3' :
                return 'longtext';
            case '4' :
                return 'datetime';
            case '5' :
                return 'images';
            default :
                return 'unknown';
        }
    };
});
app.filter('images_view', function() {
    return function(input, replication, limit) {
        var replication = replication || 1;
        var limit = limit || 0;
        var images = $.parseJSON(input);
        if (images) {
            var html = '';

            for (var i = 0; i < (limit), i < images.length; i++) {
                var el = images[i];
                html += '<img style="max-width:120px;display:inline-block;margin:10px 0;" class="img-polaroid"  src="' + site.base + el[replication].full_path + '" />';
            }
            ;
            if ((images.length - limit) > 0) {
                html += '<p><small class="text-info">and ' + (images.length - limit) + ' more</small></p>';
            }
            return html;
        }
    };
});
app.filter('images_index', function() {
    return function(input) {
        var images = $.parseJSON(input);
        var html = '<a href="#">' + images.length + (images.length > 1 ? ' images' : ' image') + '</a>';
        return html;
    };
});

app.filter('field_view_41', function() {
    return function(field, keys) {
        var values = [];
        keys = (keys) .split(',');
        keys.forEach(function(k) {
            values.push(field[k] );
        })
        return values.join(' - ');
    };
});




/**
 * Truncate Filter
 * @Param text
 * @Param length, default is 10
 * @Param end, default is "..."
 * @return string
 */
app.filter('truncate', function() {
    return function(text, length, end) {
        text = $(text).text();
        if (isNaN(length))
            length = 10;

        if (end === undefined)
            end = "...";

        if (text.length <= length || text.length - end.length <= length) {
            return text;
        }
        else {
            return String(text).substring(0, length - end.length) + end;
        }

    };
});