$(document).ready(function() {
    // image slide show arrows
    var i = 0;
    var imgCount = $('.productImgShowSlide').length;
    var noOfImagesToDisplay = 2;

    $('.productImgShowSlide').slice(noOfImagesToDisplay).hide();

    function up() {
        if (i >= imgCount - noOfImagesToDisplay) {
            return false;
        }

        $('#'+i).hide(200);
        $('#'+parseFloat(i + noOfImagesToDisplay)).show(200);

        i = i + 1;
        
    }

    function down() {
        if (i === 0) {
            return false;
        }

        $('#'+parseFloat(i + 1)).hide(200);
        $('#'+parseFloat(i - 1)).show(200);

        i = i - 1;
        
    }

    $('#up').on('click', function() {
        up();
        $(this).animate({ "color": "#ddd" },100)
        .delay(1)
        .animate({ "color": '#636b6f' },100);
    });

    $('#down').on('click', function() {
        down();
        $(this).animate({ "color": "#ddd" },100)
        .delay(1)
        .animate({ "color": '#636b6f' },100);
    });

    // image slide show
    var productImgShow = $('.productImgShow');
    $('.productImgShowSlide').on('mouseenter', function() {
        $(productImgShow).children().remove();
        $(this).clone().removeClass('productImgShowSlide').appendTo(productImgShow);
    });

    $('.productImgShowSlide').first().trigger('mouseenter');
});