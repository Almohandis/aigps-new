window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
    document.getElementById("header").style.fontSize = "30px";
  } else {
    document.getElementById("header").style.fontSize = "90px";
  }
} 

var slideIndex = 1;
showSlides(slideIndex,'slide-left');

function plusSlides(n, animate) {
  showSlides(slideIndex += n, animate);
} 

function showSlides(n,animate) {
  var i;
  //var slides = document.getElementsByClassName("mySlides");
  var slides = document.getElementById("slideshow-container").getElementsByClassName('slideshow-container__slides');

  if (n > slides.length) {
    slideIndex = 1
  }
  if (n < 1) {
    slideIndex = slides.length
  }
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }

  slides[slideIndex - 1].style.display = "block";
  slides[slideIndex - 1].classList.remove('slide-left');
  slides[slideIndex - 1].classList.remove('slide-right');
  slides[slideIndex - 1].classList.add(animate);
}