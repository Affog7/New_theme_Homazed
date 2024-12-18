<?php
/**
* Template Name: Congratulations
*
* by oasiscrea.com
* -> contact@oasiscrea.com
*/

get_header(); ?>

<main class="main main--congrats" role="main" data-barba="container" data-barba-namespace="form" data-theme="theme-light">
	<div class="container container--default">

		<div class="card-form" data-barba-prevent="all" style="margin:40px">
			<h3 class="h2 card-form__title">
				<?php $current_user = wp_get_current_user(); ?>
				Account registration
			</h3>
			<h4 class="h4" style="text-align: justify;">Hi <span style="color: #33a5ff;">
    <?php $firstname = htmlspecialchars($_GET['firstname'] ?? 'Dear user'); echo "$firstname"; ?>
    </span>, thank you for joining the homazed family!</h4> <br/>
			<h3 class="h4" style="text-align: justify;">You’ll receive an email from us shortly.</h3><br/>
			<div class="congrats__profile-link"></div>
			<div class="congrats__actions">
				<p class="" style="text-align: justify;">Once it arrives, simply paste the code into the box below
					to complete your registration. You’ll then have full access
					to your Profile and all the features of Homazed</p> <br/>

					<input type="text" name="code" id="code" placeholder="Code" style="display: block; margin: 0 auto; width: 300px;text-align: center;" class="input" value="" size="20" autocapitalize="off" autocomplete="code" required="required" /><br/>
					<p id="successMessage" style="color: green; display: none;margin-bottom:30px"></p>
                    <p id="errorMessage" style="color: red; display: none;margin-bottom:30px"></p>

					<p class="submit">
				<input type="button" onclick="verifyCode()" name="wp-submit" style="display: block; margin: -22px auto 0; width: 300px;outline: 1px solid black;border-radius: 5px;background-color: white; color: black;" id="wp-submit" class="button button-primary button-large" value="Continue"/>
			</p> <br/>

			<p style="font-size: 0.9em;">No email received? <a href="https://homazed.oasiscrea.com/congratulations/"><span style="color: #000000; font-weight: bold;font-size:16px">Resend</span></a></p>

			</div>
		</div>
	</div>
</main>

<script>

function verifyCode() {
    if (typeof pageData === 'undefined' || !pageData.welcomePageUrl) {
        console.error("pageData is not defined or welcomePageUrl is missing");
        alert("Redirection page not found. Please try again later.");
        return;
    }

    console.log("Redirection URL:", pageData.welcomePageUrl); // Debugging

    const generatedCode = "<?php echo htmlspecialchars($_GET['code'] ?? ''); ?>";
    const userCode = document.getElementById("code").value;
    const successMessage = document.getElementById("successMessage");
    const errorMessage = document.getElementById("errorMessage");

    successMessage.style.display = "none";
    errorMessage.style.display = "none";

    if (userCode === generatedCode) {
        successMessage.textContent = "Congratulations! The code is correct.";
        successMessage.style.display = "block";

        // Redirigez vers la page de bienvenue
        console.log("Redirecting to:", pageData.welcomePageUrl);

        console.log(pageData.welcomePageUrl);
        window.location.href = pageData.welcomePageUrl;
    } else {
        errorMessage.textContent = "Incorrect code, please try again.";
        errorMessage.style.display = "block";
    }
}

/*function verifyCode() {
    if (typeof pageData === 'undefined' || !pageData.welcomePageUrl) {
        console.error("pageData is not defined or welcomePageUrl is missing");
        alert("Redirection page not found. Please try again later.");
        return;
    }

    console.log("Redirection URL:", pageData.welcomePageUrl); // Debugging

    const userCode = document.getElementById("code").value;
    const successMessage = document.getElementById("successMessage");
    const errorMessage = document.getElementById("errorMessage");

    successMessage.style.display = "none";
    errorMessage.style.display = "none";

    // Envoyer la requête AJAX pour valider le code
    jQuery.ajax({
    url: '/wp-admin/admin-ajax.php',
    type: 'POST',
    data: {
        action: 'verify_activation_code',
        key: jQuery('#code').val(),
    },
    success: function(response) {
        if (response.success) {
            console.log('Success:', response.data);
        } else {
            console.error('Error:', response.data);
        }
    },
    error: function(xhr, status, error) {
        console.error('AJAX Error:', status, error);
    }
});

}
*/


</script>



<?php get_footer();
