var slideIndex = 0;


function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  if (slides.length != 0)
  {
	  for (i = 0; i < slides.length; i++) {
		slides[i].style.opacity = "0";
		  slides[i].style.transition ="opacity 3s 1s  ease-in-out";
	  }
	  slideIndex++;
	  if (slideIndex > slides.length) {slideIndex = 1}
	  console.log(slideIndex);
	  slides[slideIndex-1].style.opacity = "1";
		setTimeout(showSlides, 2000); // Change image every 2 seconds
  }
  else
	  setTimeout(showSlides, 1000);
}

window.addEventListener("load", function() {
  showSlides();
},false);
