
window.onscroll = function() {myFunction()};

var header = document.getElementById("main_header");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}


var myCarousel = document.querySelector('#slider_main')
var carousel = new bootstrap.Carousel(myCarousel, {
  interval: 5000,
  wrap: true
})


$(document).ready(function()
{
$("#main_select").select2({
  maximumSelectionLength: 2
});	


/*
=========Counter Area=============*/


$('.counter').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 4000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});

	
});



$(document).ready(function() {
var owl = $('#testimonial-slider');
owl.owlCarousel({
items: 3,
loop: true,
margin: 10,
autoplay: true,
dots: false,
nav : true,
autoplayTimeout: 3000,
autoplayHoverPause: true
});
$('.play').on('click', function() {
owl.trigger('play.owl.autoplay', [3000])
})
$('.stop').on('click', function() {
owl.trigger('stop.owl.autoplay')
})
})










