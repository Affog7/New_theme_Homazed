const Slider_map_search_init = () => {
  class Init {
    constructor(el) {
      this.el = el;
      this.sliderWrapper  = this.el.querySelector(".slider-wrapper_a");
      this.slides = this.el.querySelectorAll(".slider-slide_a");
      this.prevButton = this.el.querySelector(".slider-control_a.prev");
      this.nextButton = this.el.querySelector(".slider-control_a.next");

      this.currentIndex = 0;

      if(this.nextButton && this.prevButton) {
        // Ajouter des événements aux boutons
        this.nextButton.addEventListener("click", (e) => {
          e.preventDefault();
          e.stopPropagation();
          this.showNextSlide()
        });
        this.prevButton.addEventListener("click", (e) => {
          e.preventDefault();
          e.stopPropagation();
          this.showPrevSlide()
        });
      }

      this.updateSlider();

    }


    updateSlider() {
      this.sliderWrapper.style.transform = `translateX(-${this.currentIndex * 100}%)`
    }

    showNextSlide() {
      this.currentIndex = (this.currentIndex + 1) % this.slides.length;
      this.updateSlider();
    }

    showPrevSlide() {
      this.currentIndex = (this.currentIndex - 1 + this.slides.length) % this.slides.length;
      this.updateSlider();
    }

  }

  const sliderWrappers = document.querySelectorAll('.image-slider_a');



  // const slides = document.querySelectorAll(".slider-slide_a");
  // const prevButton = document.querySelector(".slider-control_a.prev");
  // const nextButton = document.querySelector(".slider-control_a.next");
  //
  // let currentIndex = 0;
  //
  // function updateSlider() {
    if (sliderWrappers.length) {
      [...sliderWrappers].map((wrap) =>    new Init(wrap));
    }
    // Déplacer le wrapper vers l'image actuelle
   // sliderWrapper.style.transform = `translateX(-${currentIndex * 100}%)`;
  // }

  // function showNextSlide() {
  //   currentIndex = (currentIndex + 1) % slides.length;
  //   updateSlider();
  // }
  //
  // function showPrevSlide() {
  //   currentIndex = (currentIndex - 1 + slides.length) % slides.length;
  //   updateSlider();
  // }
  //
  // if(nextButton && prevButton) {
  //   // Ajouter des événements aux boutons
  //   nextButton.addEventListener("click", (e) => {
  //     e.preventDefault();
  //     e.stopPropagation();
  //     showNextSlide()
  //   });
  //   prevButton.addEventListener("click", (e) => {
  //     e.preventDefault();
  //     e.stopPropagation();
  //     showPrevSlide()
  //   });
  //}



  // Initialiser le slider
  // updateSlider();
}

export default Slider_map_search_init;


