// toDo remake in VueJs
let price = $('#price');
let vatPrice = $('#vat_price');
let source = $('#source');
price.on('change', function() {
    countVatPrice();
});
source.on('change', function() {
    countVatPrice();
});
vatPrice.on('change', function() {
    countPrice();
});
function countVatPrice() {
    let newVatPrice = parseFloat(price.val()) * getVat();
    console.log(vatPrice.val())
    vatPrice.val(newVatPrice.toFixed(2));
}
function countPrice() {
    let newPrice = parseFloat(vatPrice.val()) / getVat();
    price.val(newPrice.toFixed(2));
}
function getVat() {
    return parseFloat(source.find(":selected").data('vat'));
}