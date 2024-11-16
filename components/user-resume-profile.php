<?php
$user_id = $args["user"]->ID;
$first_name = ucfirst($args["user"]->user_firstname);
$last_name = ucfirst($args["user"]->user_lastname);
$account_type = get_field("user_account_type", "user_".$user_id);

$user_location_address = get_field("user_location_address", "user_".$user_id);
$user_location_zip = get_field("user_location_zip", "user_".$user_id);
$user_location_city = get_field("user_location_city", "user_".$user_id);
$user_location_country = get_field("user_location_country", "user_".$user_id);

$work_position = get_field("user_current_work_position", "user_".$user_id);
$avatar_ids = get_field("user_avatar_ids", "user_".$user_id);
$user_permalink = get_permalink($user_id);
?>

<div class="resume <?php if ( $args['additional-classes'] ) { echo $args['additional-classes']; }?>">

	<?php get_template_part("components/user-avatar", null,
		array( 
			'image' => $avatar_ids,
			'first_name' => $first_name,
			'last_name' => $last_name
		)
	); ?>

	<div class="resume__data">
		<h2 class="resume__name card-form__title"><?php echo $first_name." ".$last_name; ?></h2>
		<div class="resume__username">
			<?php
			if(!empty($account_type)):
				echo $account_type["label"];
			endif;
			?>
		</div>

		<ul class="resume__account-creation">
			<li>
				<?php if(!empty($user_location_address)): ?><?php echo $user_location_address; ?><?php endif; ?>
				<?php if(!empty($user_location_zip) && !empty($user_location_city)): ?><?php echo ", " . $user_location_zip . " " . $user_location_city; ?><?php endif; ?>
				<?php if(!empty($user_location_country)): ?><?php echo ", " . $user_location_country; ?><?php endif; ?>
			</li>
			<li>
				<a class="btn btn--transparent--inline" href="<?php echo $user_permalink; ?>">See profile</a>
			</li>
		</ul>
	</div>
</div>

