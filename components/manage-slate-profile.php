
<div class="card-form" style="border: 2px solid #7e7c804d">
    <div class="post-container">
        <div class="post-header">
            <h1>PROFILE</h1>
            <div class="options">
                <button id="" class="premium-toggle premium-button">Premium</button>
                <button id="" style="display: <?php echo (($args['event_type'] != "None") ? "block" : "none"); ?>" class="event-toggle event-button">Event</button>
            </div>
        </div>
        <div class="row">
            <div>
                <strong>  <?php
                    $author_id = get_post_field('post_author', $args["id"]);

                    $account_category = get_field("account_category", "user_".$author_id);

                    if($account_category == "pro-user"){
                        get_first_element(  $args["post_home_Jobs_title"]);
                    } else {
                        get_first_element(  $args["post_home_sector_activity"]);
                    }
                    ?>
                </strong>
            </div>
            <div>
                <b><?php echo $account_category;?></b>
            </div>
            <div>
                <a href="<?php echo esc_url(get_permalink($args['id'])); ?>">
                    <i>Go to Post Creation ></i>
                </a>
            </div>
        </div>
        <hr>

        <!-- Premium Info -->
        <div class="premium-info">
            <div class="premium-header">
                <img class="premium-image" src="<?php echo esc_url($args['avatar']); ?>" alt="Main Picture" />
                <div class="premium-details" style="display: ">
                    <p>Premium duration: <span style="font-weight: 800;"><b><?php echo($args['post_premium_duration']); ?></b></span></p>
                    <p>Premium from: <span style="font-weight: 800;"><b>28 AUG 2025</b></span></p>
                    <p>Remaining time: <span style="font-weight: 800;"><b>12 days 13 hours</b></span></p>
                </div>
            </div>
            <hr />
            <div class="premium-options">
                <label class="custom-checkbox">
                    <input type="checkbox" class="premium_renewal" data-null="" data-id="<?php echo $args['id']; ?>" name="post_Is_Automatic_Renewal" value="Automatic Renewal" <?php echo $args['renewal'] ? "checked" : ""; ?> />
                    <span class="checkmark"></span> <b>Premium Post - Automatic Renewal</b>
                </label>
            </div>
            <hr />
            <div class="premium-footer" style="display: none">
                <a class="see-stats" href="#">See statistics</a>
                <div class="statistics-container" style="display: none;">
                    <h3>Statistics</h3>
                    <div id="view-count">
                        <p><strong>Number of views on this post:</strong> <span>0</span></p>
                    </div>
                    <div id="event-info-stats">
                        <p><strong>Event Stats:</strong></p>
                        <ul>
                            <li>Event Start Date: <span id="event-start-date"></span></li>
                            <li>Event End Date: <span id="event-end-date"></span></li>
                            <li>Number of people attended: <span id="event-attendees">0</span></li>
                        </ul>
                    </div>
                    <div id="follow-us-stats">
                        <p><strong>Follow Us Clicks:</strong> <span>0</span></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Premium Info -->

        <!-- Event Info -->
        <div id="" class="event-info info-section" style="display: none;">
            <div class="premium-header">
                <img class="premium-image" src="<?php echo esc_url($args['avatar']); ?>" alt="Main Picture" />
                <div class="premium-details" style="display: ">
                    <p>Event Type: <span style="font-weight: 800;"><b><?php echo esc_html($args['event_type']); ?></b></span></p>
                    <p>Title 1: <span style="font-weight: 800;"><b><?php echo esc_html($args['event_text_1']); ?></b></span></p>
                    <p>Title 2: <span><b><?php echo esc_html($args['event_text_2']); ?></b></span></p>
                </div>
            </div>
            <hr>
            <div class="premium-options">
                <label class="custom-checkbox">
                    <input type="checkbox" name="post_home_event_type" class="premium_renewal" data-null="None" data-id="<?php echo $args['id']; ?>" value="<?php echo ($args['event_type']); ?>" <?php echo ($args['event_type'] != "None") ? "checked" : ""; ?>>
                    <span class="checkmark"></span> <b>Active Event</b>
                </label>
            </div>
            <hr>
            <div class="row">
                <div></div>
            </div>
            <div class="premium-footer" style="display: none">
                <a class="see-stats" href="#">See statistics</a>
                <div class="statistics-container" style="display: none; margin-top: 20px; border-top: 2px solid #ccc; padding-top: 20px;">
                    <h3>Statistics</h3>
                    <div id="view-count">
                        <p><strong>Number of views on this event:</strong> <span id="post-views">0</span></p>
                    </div>
                    <div id="follow-us-stats">
                        <p><strong>Event Clicks:</strong> <span id="follow-us-clicks">0</span></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Event Info -->
    </div>
</div>
