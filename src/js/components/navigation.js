
const Navigation_Init = () => {
	function getCurrentURL () {
		return window.location.href
	}
	
	// Example
	const url = getCurrentURL();
	var act_for_items = document.querySelectorAll(".act-for");
	var url_comp = url.split("/");
	var page =  url_comp[url_comp.length - 2];
	
	act_for_items.forEach((act_for_item) => {
    	act_for_item.classList.remove("active");
	});

	var current_page_active_el = document.querySelector(".act-for-" + page);

	if(current_page_active_el){
		current_page_active_el.classList.add("active");
	}
}

export default Navigation_Init;
