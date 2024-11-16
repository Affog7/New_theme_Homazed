const Tabs_Init = (data) => {
	class TabsGroup {
		constructor(el) {
			this.el = el;
            var tab__buttons = this.el.querySelectorAll(".tab-button");
            var tab__contents = this.el.querySelectorAll(".tab-content");

            tab__buttons.forEach(btn => {
                btn.addEventListener("click", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const id = e.target.getAttribute("data-tabs-id");
                    tab__buttons.forEach(tab__button => {
                        tab__button.classList.remove("active");
                    });
                    e.target.classList.add("active");

                    tab__contents.forEach(content => {
                        content.classList.add("hide");
                    });
                    const element = document.getElementById(id);
                    console.log(id);
                    console.log(element);
                    element.classList.remove("hide");
                });
            });
		}
	}
	
	const tabs_group = data.container.querySelectorAll(".tabs-group");
	
	if (tabs_group.length) {
	  [...tabs_group].map((tabs) => new TabsGroup(tabs));
	}
}

export default Tabs_Init;