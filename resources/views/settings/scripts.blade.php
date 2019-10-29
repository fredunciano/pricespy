<script>
    function decreaseValue() {
        let selector = $('#equality-percent');
        let setVal = parseFloat(selector.val()) - 1;
        selector.val(setVal + '%')
    }

    function increaseValue() {
        let selector = $('#equality-percent');
        let setVal = parseFloat(selector.val()) + 1;
        selector.val(setVal + '%')
    }
    window.isSubmitting = false;
</script>