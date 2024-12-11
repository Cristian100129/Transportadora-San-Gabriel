const carouselItems = document.querySelectorAll('.carousel-item');
let currentItemIndex = 0;

setInterval(() => {
  carouselItems[currentItemIndex].style.display = 'none';
  currentItemIndex = (currentItemIndex + 1) % carouselItems.length;
  carouselItems[currentItemIndex].style.display = 'block';
}, 20000); 