<?php
$user_id = $args["user"]->ID;
$first_name = ucfirst($args["user"]->user_firstname);
$last_name = ucfirst($args["user"]->user_lastname);

$account_type = get_field("user_account_type", "user_".$user_id);
$avatar_ids = get_field("user_avatar_ids", "user_".$user_id);
$user_permalink = get_permalink("602")."?user_id=".$user_id;
?>

<a href="<?php echo $user_permalink; ?>" class="resume resume-on-post flex flex--vertical-center <?php if ( $args['additional-classes'] ) { echo $args['additional-classes']; }?>">

	<?php get_template_part("components/user-avatar", null,
		array(
			'image' => $avatar_ids,
			'first_name' => $first_name,
			'last_name' => $last_name
		)
	); ?>
<?php
/**
 * todo_augustin
 */
?>
<?php
	// ID de l'auteur du post
	$post_author_id = $user_id;/* ID de l'auteur du post, récupéré depuis la base de données ou autre source */;

	// ID de l'utilisateur actuellement connecté
	$current_user_id = get_current_user_id();

	// Vérifiez si le post appartient à l'utilisateur connecté
	$is_own_post = ($post_author_id === $current_user_id);
?>

<div class="resume__data flex flex--vertical-center" style="justify-content: space-between; align-items: center;">
    <div style="display: contents">
        <span class=""><?php echo $first_name . " " . $last_name; ?></span>
        <?php if ($account_type): ?>
            <p class="resume__account_type"><?php echo $account_type['label'] ?></p>
        <?php endif; ?>
    </div>


<?php
$i_request_contactlist_users_relationships = get_field("i_request_contactlist_users_relationships", "user_".$current_user_id);
$i_request_this_contact = (!empty($i_request_contactlist_users_relationships) && in_array($post_author_id, $i_request_contactlist_users_relationships)) ? true : false;

?>

    <!-- Bouton Ajouter Contact uniquement si ce n'est pas mon post -->
    <?php if (!$is_own_post): ?>
        <button class=" add-contact-btn_" data-c ="<?php var_dump($i_request_contactlist_users_relationships); ?>" data-request-contact-default="Add contact"  data-relation-him="<?php echo $post_author_id; ?>" data-u-id="<?php echo wp_get_current_user()->ID; ?>" >
            Add contact
        </button>
    <?php endif; ?>
</div>

</a>

