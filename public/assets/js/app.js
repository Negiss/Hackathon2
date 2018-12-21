$(document).ready(function() {

    $(document).on('click', function myfunc (e) {
        $(flash).addClass('is-flashing');
        setTimeout(function () {
        }, 1000);
    });

    $(document).on('click', function () {
        setTimeout(function () {
            if($(".hide").hasClass('hide')){
                document.getElementById('audio').play();
            }
            document.body.className = document.body.className.replace("preaccueil", "accueil");
            setTimeout(function () {
                $(".hide").removeClass('hide')
            }, 500)
        }, 100);
    });

});