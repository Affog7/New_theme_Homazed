import Glide from '@glidejs/glide'

const Carrousel_Init = (data) => {
	class Caroussel {
		constructor(el) {
			this.el = el;
			this.glide = null;
			console.log(this.el);
			this.glide__track = this.el.querySelector(".glide__track");
			var glide_el = this.el;
			var mainArgs = {
				type: 'carousel',
				hoverpause: false,
				autoplay: false,
				animationDuration: 550,
				bound: true,
				perTouch: 1,
				heightRatio : 0.5625
				// classes: {
				// 	direction: {
				// 		ltr: 'carrousel--ltr',
				// 		rtl: 'carrousel--rtl'
				// 	},
				// 	slider: 'carrousel--slider',
				// 	carousel: 'carrousel--carousel',
				// 	swipeable: 'carrousel--swipeable',
				// 	dragging: 'carrousel--dragging',
				// 	cloneSlide: 'carrousel__slide--clone',
				// 	activeNav: 'carrousel__bullet--active',
				// 	active: 'carrousel__bullet--active',
				// 	activeSlide: 'carrousel__slide--active',
				// 	disabledArrow: 'carrousel__arrow--disabled'
				// }
			}

			var SpecificArgs = {
				startAt: 0,
				perView: 1,
			}

			var args = {};
			args = jsonConcat(args, mainArgs);
			args = jsonConcat(args, SpecificArgs);

			this.glide = new Glide(glide_el, args );

      try {
        this.glide.mount();
      } catch (e) {

      }


			const observer = new IntersectionObserver((entries, _observer) => {
				entries.forEach(entry => {
					if(entry.isIntersecting) {
						this.glide.on('build.after', function() {
							var slideHeight = glide_el.querySelector(".glide__slide--active").getBoundingClientRect().height;
							var glideTrack = glide_el.querySelector(".glide__track").getBoundingClientRect().height;
							if (slideHeight != glideTrack) {
								var newHeight = slideHeight;
								glide_el.querySelector(".glide__track").style.height  = newHeight  + 'px';
							}
						});

						this.glide.on('run.after', function() {
							var slideHeight = glide_el.querySelector(".glide__slide--active").getBoundingClientRect().height;
							var glideTrack = glide_el.querySelector(".glide__track").getBoundingClientRect().height;
							if (slideHeight != glideTrack) {
								var newHeight = slideHeight;
								glide_el.querySelector(".glide__track").style.height  = newHeight  + 'px';
							}
						})
						this.glide.update();
					}
				});
			});

			observer.observe(glide_el);

			function jsonConcat(o1, o2) {
				for (var key in o2) {
				 o1[key] = o2[key];
				}
				return o1;
			}
		}
	}

	const caroussels = data.container.querySelectorAll(".carrousel");

	if (caroussels.length) {
	  [...caroussels].map((caroussel) => new Caroussel(caroussel));
	}
}

export default Carrousel_Init;
