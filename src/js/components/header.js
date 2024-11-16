import { makeRelationBtw } from '../functional/relations';

const Init_Header = () => {
		var current_user_id = document.querySelector(".current_user_id");
		var contactBtnsResponse = document.querySelectorAll('.relation_btn--contact-list-response');
        contactBtnsResponse.forEach(contactBtnResponse => {
            contactBtnResponse.addEventListener("click", (e) => {
                e.preventDefault();
                e.stopPropagation();
                console.log(e.currentTarget.getAttribute("data-relation-type"));
                makeRelationBtw(current_user_id.getAttribute("data-u-id"), e.currentTarget.getAttribute("data-relation-him"), e.currentTarget.getAttribute("data-relation-type"), e.currentTarget);
            });
        });
}

export default Init_Header;
