var slideIndex = 0;


function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.opacity = "0";
      slides[i].style.transition ="opacity 3s 1s  ease-in-out"; 
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  slides[slideIndex-1].style.opacity = "1";
  setTimeout(showSlides, 12000); // Change image every 2 seconds
} 

window.addEventListener("load", function() {
  showSlides();
},false);