/**
 * Loading Indicator
 * 
 * @author Maikel Daloo
 * @date 12th March 2013
 * 
 * Creates a new module and intercepts all ajax requests.
 * Every time a request is sent, we display the loading message and increment
 * the enable_counter variable. Then when requests complete (whether success or error)
 * we increment the disable_counter variable and we only hide the loading message
 * when the enable/disable counters are equal.
 * 
 * @example
 * All that is required to get this working is to inject this module into your main
 * module. E.g.
 *     var app = angular.module('my-app', ['LoadingIndicator']);
 * Then the script will look for the element specified in the LoadingIndicatorHandler object
 * and show/hide it.
 */
var module = angular.module('LoadingIndicator', []);

module.config(['$httpProvider', function($httpProvider) {
        var interceptor = ['$q', 'LoadingIndicatorHandler', function($q, LoadingIndicatorHandler) {
                return function(promise) {
                    LoadingIndicatorHandler.enable();

                    return promise.then(
                            function(response) {
                                LoadingIndicatorHandler.disable();
                                return response;
                            },
                            function(response) {

                                LoadingIndicatorHandler.disable();

                                // Reject the reponse so that angular isn't waiting for a response.
                                return $q.reject(response);
                            }
                    );
                };
            }];

        $httpProvider.responseInterceptors.push(interceptor);
    }]);

/**
 * LoadingIndicatorHandler object to show a loading animation while we load the next page or wait
 * for a request to finish.
 */
module.factory('LoadingIndicatorHandler', function()
{
    // The element we want to show/hide.
    var $element = $('#loading-indicator');
    var $progress = $element.children('.progress-bar');
    return {
        // Counters to keep track of how many requests are sent and to know
        // when to hide the loading element.
        enable_count: 0,
        disable_count: 0,
        /**
         * Fade the blocker in to block the screen.
         *
         * @return {void}
         */
        enable: function() {
            this.enable_count++;
            if ($element.length) {
                $element.show();
                //$progress.width('5%').animate({width: '100%'}, 'slow');
            }
        },
        /**
         * Fade the blocker out to unblock the screen.
         *
         * @return {void}
         */
        disable: function() {
            this.disable_count++;
            if (this.enable_count === this.disable_count) {
                if ($element.length) {
                  //  $progress.width('100%');
                    $element.hide();
                }
            }else{
                $element.show();
            }
        }
    }
});