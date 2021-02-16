$(document).ready(function(){
    $('.editProfile').on('click', function(e) {
        e.preventDefault();

        $(this).fadeOut(renderSubmitButton());

        $(".editCred").fadeOut(function() {
            $(".profileInput").fadeIn();
        });

        $(".editCred").children().fadeOut();

        $(this).remove();
    });

    function renderSubmitButton()
    {
        $('#updateProfile').append(`
            <div class="form-group row">
                <div class="col-sm-12">
                    <input type="submit" value="submit" class="col-xs-2 col-xs-offset-5 btn btn-primary">
                </div>
            </div>
        `);
    }
});