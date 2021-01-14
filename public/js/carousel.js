
const carousel = document.querySelector(".main-carousel");

var flkty = new Flickity( carousel, {
    // options
  
  autoPlay: true,
  wrapAround: true,
  groupCells: 1,
  initialIndex: 2,
  pageDots: false
});


document.querySelector(".carouselContain").classList.add("show");