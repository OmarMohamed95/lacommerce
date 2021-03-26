$(document).ready(function(){
    // check all
    $('#allCheckbox').on('change', function(){
        $(".singleCB").prop('checked', this.checked);
    });

    //update state of single order
    $('.state_single').on('change', function() {
        var url = $(this).attr('data-url'),
            status = $(this).val();

        axios.put(url, {
            status: status
        })
        .then(function (response) {})
        .catch(function (error) {
            console.log(error)
        })
    });
});