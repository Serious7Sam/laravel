require('./bootstrap');

new Vue({
    el: '#products',
    methods: {
        buy: function(productId) {
            $.get('/api/v1/product/buy/' + productId + '/', function(result) {
                window.location.reload();
            });
        }
    }
});
