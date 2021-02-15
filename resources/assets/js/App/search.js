$(document).ready(function(){
    var timeout = null;
    $('#searchInput').on('keyup', function(e) {
        clearTimeout(timeout)
        timeout = setTimeout(function() {
            clearMenu();
            axios.get(`/api/search?q=${$('#searchInput').val()}`)
            .then(function (response) {
                response.data[0].forEach(result => {
                    $('#searchResultsMenu').append(`<a href='/product/${result.id}'><li>${result.name} in <span class="bold">${result.category.name}<span></li></a>`)
                });
            })
            .catch(function (error) {
                console.log(error);
            })
        }, 200)
    })

    $('#searchInput').on('click', function() {
        showMenu()
    })

    $('body').on('click', function(e) {
        if (e.target.id == "searchResultsMenu" || e.target.id == "searchInput" || $(e.target).closest('#searchResultsMenu').length) {
            return;
        }             

        hideMenu();
    });

    function clearMenu() {
        $('#searchResultsMenu').children().remove();
    }

    function hideMenu() {
        $('#searchResultsMenu').hide();
    }

    function showMenu() {
        $('#searchResultsMenu').show();
    }
});