$(document).ready(function() {
    
    
    $('.burger').click(function() {
        $(this).addClass('active');
        $('.menu').fadeIn();
    });

    $('.close-menu, .menu .nav a').click(function() {
        $('.menu').hide();
    });

    $('.slider_1').slick({
        autoplay: true,
        autoplaySpeed: 4800,
        infinite: true,
        arrows: true, 
        //fade: true,
        //cssEase: 'linear',
        dots: true
        
    });

    $('.capability-slider_1').slick({
        autoplay: false,
        arrows: true, 
        //fade: true,
        //cssEase: 'linear',
        dots: true,
        adaptiveHeight: true
        
    });


    $('.mask').mask('+7 (999) 999-99-99');
    
 

});

function modalOpen(element, modalName) {
    $('.btn-callback').on('click', function () {
        $('.modal_callback').fadeTo(300, 1);
    });
}


// Первый дочерний элемент popup !!!
// На входе: 
//     класс элемента, по которому нажимаем для закрытия с кнопки
//     уникальный класс модального окна
function modalClose_ButtonKeyArea(element, modalName) {
    // Закрытие по нажатию на крест
    $(element).on('click', function () {
        $(modalName).fadeOut(500);
    });

    // Закрытие по нажатию на Esc
    $(document).keydown(function (e) {
        if (e.keyCode === 27) {
            e.stopPropagation();
            $(modalName).fadeOut();
        }
    });
    // Закрытие по нажатию вне окна (по темному фону)
    $(modalName).click(function (e) {
        if ($(e.target).closest('.popup').length == 0) {
            $(this).fadeOut();
        }
    });
}

modalOpen('.btn-callback', '.hidden');
modalClose_ButtonKeyArea('.close-popup', '.modal');
modalClose_ButtonKeyArea('.footer-cookie-x', '.footer-cookie');
modalClose_ButtonKeyArea('.footer-cookie-sgl', '.footer-cookie');