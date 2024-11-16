const scrollTo = (next) => {
	const queryString = window.location.search;
	var inputSubmit = document.querySelector(".frm_submit input");

	if(queryString){
		const urlParams = new URLSearchParams(queryString);
		const scrollto = urlParams.get('scrollto')
		var scrollTo__el = document.querySelector("." + scrollto);
		if(scrollTo__el) {
			var scrollTo__el_y = scrollTo__el.offsetTop;
			window.scrollTo({
				top: scrollTo__el_y - 24,
				behavior: 'smooth',
			});
		}
	}

	// avoid scrollTo after submitting a form
	if(inputSubmit){
		inputSubmit.addEventListener('click', function(e) {
			let url = new URL(window.location.href);
			let scrolltoParam = url.searchParams.get('scrollto');
			if (scrolltoParam) {
				url.searchParams.delete('scrollto');
				history.replaceState(history.state, '', url.href);
			}
		});
	}

}

const getOffset = (element, horizontal = false) => {
	if(!element) return 0;
	return getOffset(element.offsetParent, horizontal) + (horizontal ? element.offsetLeft : element.offsetTop);
}

export default scrollTo;