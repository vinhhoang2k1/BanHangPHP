 var slideIndex;
 let times;

 function showSlides() {
     var i;
     var slides = document.getElementsByClassName("slide-item");
     if (slides.length > 0) {
         document.getElementById('slide-current').innerHTML = (slideIndex + 1) + '/' + slides.length
         if (slideIndex > 0)
             slides[slideIndex - 1].classList.remove('active_slide');
         for (i = 0; i < slides.length; i++) {
             slides[i].style.display = "none";
         }
         slides[slideIndex].style.display = 'flex';
         $('.slider-active').text(slideIndex + 1);
         slides[slideIndex].classList.add('active_slide');

         slideIndex++;
         if (slideIndex > slides.length - 1) {
             slideIndex = 0
         }
         times = setTimeout(showSlides, 3000);
     }

 }
 showSlides(slideIndex = 0);

 function currentSlide(n) {
     showSlides(slideIndex = n);
 }

 let prevSlide = document.getElementById('prev-slide');
 let nextSlide = document.getElementById('next-slide');

 prevSlide.onclick = function() {

     clearTimeout(times);
     var slides = document.getElementsByClassName("slide-item");
     slideIndex -= 2;
     if (slideIndex < 0) {

         if (slideIndex == -1) {
             slideIndex = 2;
             slides[0].classList.remove('active_slide');
         } else {
             slideIndex = 0;
             slides[2].classList.remove('active_slide');
         }


     } else {
         slides[slideIndex + 1].classList.remove('active_slide');
     }

     for (i = 0; i < slides.length; i++) {
         slides[i].style.display = "none";
     }
     slides[slideIndex].style.display = 'flex';
     slides[slideIndex].classList.add('active_slide');
     document.getElementById('slide-current').innerHTML = slideIndex + 1 + '/' + slides.length
     showSlides();
 }

 nextSlide.onclick = function() {
     clearTimeout(times);

     var slides = document.getElementsByClassName("slide-item");
     document.getElementById('slide-current').innerHTML = slideIndex + 1 + '/' + slides.length
     if (slideIndex > 0)
         slides[slideIndex - 1].classList.remove('active_slide');
     for (i = 0; i < slides.length; i++) {
         slides[i].style.display = "none";
     }
     slides[slideIndex].style.display = 'flex';
     slides[slideIndex].classList.add('active_slide');
     showSlides();
 }

