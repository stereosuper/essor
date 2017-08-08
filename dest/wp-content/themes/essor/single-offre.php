<?php

$error = false;
$success = false;

$errorName = false;
$errorMsg = false;
$errorPhone = false;
$errorPhoneTxt = false;
$errorMail = false;
$errorMailTxt = false;
$errorEmpty = false;
$errorSend = false;

$name = isset($_POST['full_name']) ? strip_tags(stripslashes($_POST['full_name'])) : '';
$phone = isset($_POST['tel']) ? strip_tags($_POST['tel']) : '';
$mail = isset($_POST['email']) ? strip_tags(stripslashes($_POST['email'])) : '';
$msg = isset($_POST['message']) ? strip_tags(stripslashes($_POST['message'])) : '';
$spamUrl = isset($_POST['url']) ? strip_tags(stripslashes($_POST['url'])) : '';

//$mailto = get_field('emails', 'options');
$mailto = 'shwarp@live.fr';

if( isset($_POST['submit']) ){
    if( empty($name) ){
        $errorName = true;
        $errorEmpty = true;
        $error = true;
    }

    if( !empty($phone) ){
        if( !(strlen($phone) < 20 && strlen($phone) > 9 && preg_match("/^\+?[^.\-][0-9\.\- ]+$/", $phone)) ){
            $errorPhoneTxt = 'Le numéro de téléphone est invalide.';
            $errorPhone = true;
            $error = true;
        }
    }

    if( empty($mail) ){
        $errorMail = true;
        $errorEmpty = true;
        $error = true;
    }else{
        if( !filter_var($mail, FILTER_VALIDATE_EMAIL) ){
            $errorMailTxt = 'L\'adresse email est invalide.';
            $errorMail = true;
            $error = true;
        }
    }

    if( empty($msg) ){
        $errorMsg = true;
        $errorEmpty = true;
        $error = true;
    }


    if( !$error ){
        if( empty($spamUrl) ){
            $subjectMail = 'Nouveau message provenant de essor.group';
            
            $headers = 'From: "' . $name . '" <' . $mail . '>' . "\r\n" .
                       'Reply-To: ' . $mail . "\r\n";
            
            $content = 'De: ' . $name . "\r\n" .
                       'Email: ' . $mail . "\r\n" .
                       'Téléphone: ' . $phone . "\r\n" .
            	       'Message: ' . $msg;
            
            $sent = wp_mail($mailto, $subjectMail, $content, $headers);
            
            if( $sent ){
                $success = true;
            }else{
                $error = true;
                $errorSend = 'Nous sommes désolés, une erreur est survenue! Merci de réésayer plus tard.';
            }
        }else{
            $success = true;
        }
    }
}

get_header(); ?>

	<?php if ( have_posts() ) : the_post(); ?>

		<div class='container'>
            <div class='wrapper-content-sidebar'>
                <aside>
                    <?php wp_nav_menu( array( 'theme_location' => 'jobs', 'container' => false, 'menu_class' => 'menu-aside' ) ); ?>
                </aside>
                <div class='content-sidebar'>
                    <h1><?php the_title(); ?></h1>
                    <h2>
                        <?php echo get_the_terms( $post->ID, 'contrat' )[0]->name; ?>
                        -
                        <?php echo get_the_terms( $post->ID, 'lieu' )[0]->name; ?>
                    </h2>
                    <?php the_content(); ?>

                    <h3>Postuler</h3>

                    <div class='form-contact'>

                        <?php if( $success ){ ?>
                            <p class='form-success'>
                                Merci, votre message a bien été envoyé!
                                <span>Nous vous répondrons dans les plus bref délais.</span>
                            </p>
                        <?php }else if( $error ){ ?>
                            <p class='form-error'>
                                <?php if( $errorSend ){ ?>
                                    <?php echo $errorSend; ?>
                                <?php }else{ ?>
                                    <?php if($errorEmpty) echo 'Merci de corriger les erreurs ci-dessous.'; ?>
                                    <span><?php if($errorMailTxt) echo $errorMailTxt; ?></span>
                                    <span><?php if($errorPhoneTxt) echo $errorPhoneTxt; ?></span>
                                <?php } ?>
                            </p>
                        <?php } ?>

                        <form method='post' action='<?php the_permalink(); ?>#form' class='<?php if( $success ) echo "success"; ?>' id='form-contact'>
                            <div class='field <?php if($errorName) echo 'error'; ?>'>
                                <label for='name'>Votre prénom et nom</label>
                                <input type='text' name='full_name' id='name' value='<?php echo $name; ?>' placeholder='Alain Deloin' required>
                            </div>

                            <div class='field <?php if($errorMail) echo 'error'; ?>'>
                                <label for='email'>Votre email</label>
                                <input type='email' name='email' id='email' value='<?php echo $mail; ?>' placeholder='alain.deloin@laposte.net' required>
                            </div>

                            <div class='field optional <?php if($errorPhone) echo 'error'; ?>'>
                                <label for='tel'>Votre numéro de téléphone</label>
                                <input type='tel' name='tel' id='tel' value='<?php echo $phone; ?>' placeholder='06 00 00 00 00'>
                                <i>(facultatif)</i>
                            </div>

                            <div class='field field-top <?php if($errorMsg) echo 'error'; ?>'>
                                <label for='message'>Votre message</label>
                                <textarea name='message' id='message' placeholder="J'aime beaucoup ce que vous faites! Laissez moi vous parler de mon incroyabe projet." required><?php echo $msg; ?></textarea>
                            </div>

                            <div class='hidden'>
                                <input type='url' name='url' id='url' value='<?php echo $spamUrl; ?>'>
                                <label for='url'>Merci de laisser ce champ vide.</label>
                            </div>

                            <button class='btn' type='submit' name='submit' form='form-contact'>
                                Envoyer
                                <svg class='icon'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='#icon-right'></use></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
		</div>
	
	<?php else : ?>

		<div class='container-small'>
			<h1>404</h1>
		</div>

	<?php endif; ?>

<?php get_footer(); ?>