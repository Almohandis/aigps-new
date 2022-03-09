window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
    document.getElementById("logo").style.height = "3.5rem";
    document.getElementById("title").style.marginTop = "13px";
    document.getElementById("title").style.fontSize = "22px";

  } else {
    document.getElementById("logo").style.height = "5.5rem";
    document.getElementById("title").style.marginTop = "22px";
    document.getElementById("title").style.fontSize = "28px";
  }
} 
function Scrolldown() {
  window.scroll(0,300); 
}




console.log (window.location.href)
if(window.location.href == 'http://127.0.0.1:8000/'){

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
}


function viewArticles()
{
    var articles = document.getElementById('slideshow-container');
    articles.style.display="block";
    window.scrollBy(0, 800);
    var footer = document.getElementById('footer');
    footer.style.marginTop ="-0.5rem";
    
}