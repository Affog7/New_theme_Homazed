<div id="map-popup-profile" class="other_popup-type default-bckg map-slate">
    <a href="#" class="map-slate--link flex">
        <div class="map-slate__image">
            <!-- <img src="" alt=""> -->
        </div>
        <div class="map-slate__content">
            <div class="post-details card__header__item flex flex--justify-between">
                <h2 class="h4 post-profile">Profile</h2>
            </div>
            <div class="post-details_project_category card__header__item flex flex--justify-between">Address</div>
            <div class="post-details card__header__item flex flex--justify-between">
                <ul class="post-details__caracteristics flex flex--vertical-center">
                        <li class=" category">
                            <span class="value">X</span>
                        </li>
                </ul>
            </div>
        </div>

        <div class="sidebar-icons">
            <div class="icon"  >
				<svg width="25" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Edit / Add_Plus_Circle"> <path id="Vector" d="M8 12H12M12 12H16M12 12V16M12 12V8M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
            </div>
            <div class="icon favoriteButon">
            <?php
                echo file_get_contents(get_stylesheet_directory().'/src/images/icons/badge-check-verified.svg');
            ?>

            </div>
            <div class="icon shareButon">
				<svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M6.19043 17.5151L6.19043 9.64014" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
					<path d="M1.69043 13.5776L1.69043 17.5151" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
					<path fill-rule="evenodd" clip-rule="evenodd" d="M13.5029 2.89014L13.5029 1.26638C13.5034 1.15572 13.5686 1.05558 13.6696 1.01033C13.7706 0.965083 13.8888 0.983095 13.9717 1.05639L18.3427 4.94214C18.4007 4.99347 18.4348 5.0665 18.4371 5.14391C18.4394 5.22133 18.4096 5.29623 18.3547 5.35089L13.9837 9.72264C13.9031 9.80274 13.7822 9.82661 13.6772 9.78319C13.5722 9.73977 13.5035 9.63754 13.5029 9.52389L13.5029 7.39014L7.87793 7.39014C4.00568 7.39014 1.69043 8.46114 1.69043 13.5776L1.69043 6.67764C1.69043 4.02489 3.38768 2.88789 5.48018 2.88789L13.5029 2.89014Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
				</svg>
            </div>
        </div>

    </a>
</div>
