$('#shop-select').on('change', function() {
    var url = location.protocol + '//' + location.host + location.pathname;
    var value = $(this).val();
    if (value !== '') {
        url += '?s=' + value;
    }
    window.location.href = url;
});