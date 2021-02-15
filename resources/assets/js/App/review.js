$(document).ready(function() {
    $('#review').on('submit',function(e) {
        e.preventDefault();
        var content = $('textarea[name="content"]').val(),
            url = $(this).attr('action');

        axios.post(url, {
            content: content,
        })
        .then(function(response) {
            $('#errorMsg').hide();

            var review = response.data.review,
                date = dateToStr(review.created_at);

            renderReview(review, date);
        })
        .catch(function(error) {
            if (error.response.status === 422) {
                showErrorMessage(error.response.data.content[0])
            } else if (error.response.status === 401) {
                showErrorMessage('Please login to be able to review the product')
            }
        });
    });

    function showErrorMessage(message)
    {
        $('#errorMsg').show();
        $('#errorMsg').addClass('alert alert-danger text-center').text(message);
    }

    function dateToStr(date)
    {
        var date = new Date(date),
            options = { weekday: 'short', month: 'long', day: 'numeric', year: 'numeric' };
        
        return date.toLocaleDateString(false, options);
    }

    function renderReview(review, date)
    {
        $('.showReviews').prepend(`
            <div class='singleReview'>
                <p class='pull-right'>${date}</p> 
                <p class='reviewName'>${review.user.name}</p> 
                <p>${review.content}</p>
            </div>
        `);
    }
});