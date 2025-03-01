import AddressManager from "./profile_location_plus";

const Profile_Init = (data) => {

  document.addEventListener('DOMContentLoaded', function () {
    if (window.jQuery) {


      jQuery(document).on('gform_page_loaded', function (event, form_id, current_page) {
        const profileElement = document.querySelectorAll(".address-manager");
        if (profileElement.length) {
          [...profileElement].map((el) => new AddressManager(el));
        }
      });


      const profileElement = document.querySelectorAll(".address-manager");
      if (profileElement.length) {
        [...profileElement].map((el) => new AddressManager(el));
      }

    }
  });

};

export default Profile_Init;
