<?php get_template_part("components/btn", null,
	array(
		'label' => 'Share by message',
		'href' => "",
		'target' => "_self",
		'skin'  => 'secondary',
		'icon-only'  => false,
		'disabled'  => false,
		'icon-position' => '', // left or right
		'icon' => '',
		'additional-classes' => 'w-100',
		'data-attribute' => 'data-close-modal',
		'theme' => "",
	)
); ?>
<div class="copy-paste-wrapper">
	<?php get_template_part( 'components/copy-paste', null,
		array(
			'label' => 'Copy post link',
			'copyValue' => $args['post_permalink'],
			"iteration" => $args["post_id"]
		)
	); ?>
</div>
<p>Share on social medias</p> <br>
<?php /**
 * todo_augustin share
 *
 *  */ ?>
<div class="iconss">
	<a href="mailto:?subject=Regardez%20ce%20contenu&body=Voici%20le%20lien:%20<?php  echo $args['post_permalink']; ?>" id="Email">
		<img src="https://img.icons8.com/ios-glyphs/30/email.png" alt="Email">
	</a>
	<a href="https://m.me/?link=<?php  echo $args['post_permalink']; ?>" id="Messenger">
		<img src="https://img.icons8.com/ios-glyphs/30/facebook-messenger.png" alt="Messenger">
	</a>
	<a href="https://www.instagram.com/sharer/sharer.php?u=<?php  echo $args['post_permalink']; ?>" id="Instagram">
		<img src="https://img.icons8.com/ios-glyphs/30/instagram-new.png" alt="Instagram">
	</a>
	<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php  echo $args['post_permalink']; ?>&title=<?php  echo $args['post_permalink']; ?>&summary=INVITATION&source=/" id="LinkedIn">
		<img src="https://img.icons8.com/ios-glyphs/30/linkedin.png" alt="LinkedIn">
	</a>
	<a href="https://wa.me/?text=<?php  echo $args['post_permalink']; ?>" id="WhatsApp">
		<img src="https://img.icons8.com/ios-glyphs/30/whatsapp.png" alt="WhatsApp">
	</a>
	<a href="https://twitter.com/intent/tweet?url=<?php  echo $args['post_permalink']; ?>&text=<?php  echo $args['post_permalink']; ?>" id="Twitter">
		<img src="https://img.icons8.com/ios-glyphs/30/twitter.png" alt="Twitter">
	</a>
</div>
