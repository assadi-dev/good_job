
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



function onClickBtn() {

  let spanCount = this.document.querySelector(".favoris_btn")
  let icone = this.document.querySelector("i");

  if (icone.classList.contains("fas")) {
    icone.classList.replace("fas", "far")
    icone.classList.remove("addedFavorie")
  } else {
    icone.classList.replace("far", "fas")
    icone.classList.add("addedFavorie")
  }
    
  
}

document.querySelectorAll(".linkAddFavori").forEach((link) => {
  
  link.addEventListener('click',onClickBtn)
})
