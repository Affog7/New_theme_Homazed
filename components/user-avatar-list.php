<div class="avatar-line resume__profile-picture">
	<?php

	if($args["user_avatar"]): ?>
		<img class="resume__image" src="<?php
		if(  !is_array($args["user_avatar"]) && strlen($args["user_avatar"]) > 6){
			echo $args["user_avatar"];
		} else {
			$avatar_ids_array = explode(',', $args["user_avatar"]);

			echo wp_get_attachment_image_src($avatar_ids_array[0], 'large-img-medium');
		} ?>"


			 alt="<?php echo $args["user_first_name"]." ".$args["user_last_name"]." profile image"; ?>"/>
	<?php else: ?>
		<div class="resume__image resume__image--blank flex flex--horizontal-center flex--center">
			<span class="first-letters"><?php echo $args["user_first_name"][0].$args["user_last_name"][0]; ?></span>
		</div>
	<?php endif; ?>
	<a class="avatar-line__name" href="<?php echo $args["user_permalink"]; ?>"><?php echo $args["user_first_name"]." ".$args["user_last_name"]; ?></a>
	<?php if(get_current_user_id() != $args['user_id']): ?>
		<div class="avatar-line__actions btn-group btn-group--related">
			<?php
				$current_user_id = get_current_user_id();

				$i_request_contactlist_users_relationships = get_field("i_request_contactlist_users_relationships", "user_".$current_user_id);
				$i_accept_contactlist_users_relationships = get_field("i_accept_contactlist_users_relationships", "user_".$current_user_id);
				$him_request_contactlist_users_relationships = get_field("i_request_contactlist_users_relationships", "user_".$args["user_id"]);
				$him_accept_contactlist_users_relationships = get_field("i_accept_contactlist_users_relationships", "user_".$args["user_id"]);
				// $i_refused_contactlist_users_relationships = get_field("i_refused_contactlist_users_relationships", "user_".$current_user_id);
				$i_recommend_users_relationships = get_field("i_recommend_users_relationships", "user_".$current_user_id);
				$him_recommend_users_relationships = get_field("users_recommend_me_relationships", "user_".$args["user_id"]);
			?>

			<?php  // $i_refused_this_contact = (!empty($i_refused_contactlist_users_relationships) && in_array($args["user_id"], $i_refused_contactlist_users_relationships)) ? true : false; ?>
			<?php $i_request_this_contact = (!empty($i_request_contactlist_users_relationships) && in_array($args["user_id"], $i_request_contactlist_users_relationships)) ? true : false; ?>
			<?php $i_accept_this_contact = (!empty($i_accept_contactlist_users_relationships) && in_array($args["user_id"], $i_accept_contactlist_users_relationships)) ? true : false; ?>
			<?php $him_request_me = (!empty($him_request_contactlist_users_relationships ) && in_array($current_user_id, $him_request_contactlist_users_relationships )) ? true : false; ?>
			<?php $him_accept_me = (!empty($him_accept_contactlist_users_relationships ) && in_array($current_user_id, $him_accept_contactlist_users_relationships )) ? true : false; ?>
			<?php
			$contact_classes = 'relation_btn relation_btn--contact-list';
			$contact_text = 'Add contact';
			$contact_text_default = 'Add contact';
			$contact_text_requested = 'Contact requested';
			$contact_icon = 'add-square';
			$relation_type = 'request-contact-list';

			if($i_request_this_contact && $i_accept_this_contact && $him_request_me && !$him_accept_me){
				// I request & him did not accept yet [GREEN1]";
				$contact_text = 'Contact requested';
				$contact_classes .= ' relation_btn--contact-requested';
				$contact_icon = 'single-neutral-actions-refresh';
				$relation_type = 'remove-request-contact-list';
			}elseif($i_request_this_contact && $i_accept_this_contact && $him_request_me && $him_accept_me){
				// relation done [RED]";
				$contact_text = 'Contact accepted';
				$contact_classes .= ' relation_btn--contact-relation-done';
				$contact_icon = 'check-circle-1';
				$relation_type = 'refuse-contact-list';
				// alert(are your sure ?)
			}elseif($i_request_this_contact  && !$i_accept_this_contact && $him_request_me && $him_accept_me){
				// He request, I did not accept yet [GREEN2]";
				$contact_text = 'Accept contact';
				$contact_classes .= ' relation_btn--contact-him-requested';
				$contact_icon = 'check-circle-1';
				$relation_type = 'accept-contact-list';
			}elseif(!$i_request_this_contact && !$i_accept_this_contact && !$him_request_me && !$him_accept_me){
				// No request for now [Default & BLACK]";
			}

			?>
			<?php get_template_part( 'components/btn', null,
				array(
					'label' => $contact_text,
					'href' => "/",
					'target' => "_self",
					'skin'  => 'ghost',
					'icon-only'  => false,
					'disabled'  => false,
					'icon-position' => 'left',
					'icon' => $contact_icon,
					'additional-classes' => $contact_classes,
					'data-attribute' => "data-relation-him=" . $args["user_id"] . " data-relation-type=" . $relation_type . " data-request-contact-default=" . rawurlencode($contact_text_default) . "  data-request-contact-requested=" . rawurlencode($contact_text_requested) . "",
					'theme' => "",
				)
			); ?>
			<?php // if($account_type['value'] == "company_user" || $account_type['value'] == "pro_user"): ?>
				<?php $do_i_recommend_him = (!empty($i_recommend_users_relationships) && in_array($args["user_id"], $i_recommend_users_relationships)) ? true : false; ?>
				<?php $is_he_recommended_by_me = (!empty($him_recommend_users_relationships) && in_array($current_user_id, $him_recommend_users_relationships)) ? true : false; ?>

				<?php get_template_part( 'components/btn', null,
					array(
						'label' => 'Recommend',
						'href' => "/",
						'target' => "_self",
						'skin'  => 'ghost',
						'icon-only'  => true,
						'disabled'  => false,
						'icon-position' => '',
						'icon' => 'check-badge',
						'additional-classes' => $do_i_recommend_him ? 'relation_btn relation_btn--recommend relation_btn--checked' : 'relation_btn relation_btn--recommend',
						'data-attribute' => "data-relation-him=" . $args["user_id"] . " data-relation-type='recommend'",
						'theme' => "",
					)
				); ?>
			<?php // endif; ?>
			<?php $do_i_recommend_him = (!empty($i_recommend_users_relationships) && in_array($args["user_id"], $i_recommend_users_relationships)) ? true : false; ?>
			<?php $is_he_recommended_by_me = (!empty($him_recommend_users_relationships) && in_array($current_user_id, $him_recommend_users_relationships)) ? true : false; ?>

			<?php get_template_part( 'components/btn', null,
				array(
					'label' => 'Recommend',
					'href' => "/",
					'target' => "_self",
					'skin'  => 'ghost',
					'icon-only'  => true,
					'disabled'  => false,
					'icon-position' => '',
					'icon' => 'check-badge',
					'additional-classes' => $do_i_recommend_him ? 'relation_btn relation_btn--recommend relation_btn--checked' : 'relation_btn relation_btn--recommend',
					'data-attribute' => "data-relation-him=" . $args["user_id"] . " data-relation-type='recommend'",
					'theme' => "",
				)
			); ?>
		</div>
	<?php endif; ?>
</div>
