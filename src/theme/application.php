<?php
/*
Template Name: Postuler
*/

$error = false;
$success = false;

$errorName = false;
$errorMsg = false;
$errorPhone = false;
$errorPhoneTxt = false;
$errorMail = false;
$errorMailTxt = false;
$errorFile = false;
$errorFileTxt = false;
$errorEmpty = false;
$errorSend = false;

$name = isset($_POST['full_name']) ? sanitize_text_field($_POST['full_name']) : '';
$phone = isset($_POST['tel']) ? sanitize_text_field($_POST['tel']) : '';
$mail = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
$msg = isset($_POST['message']) ? strip_tags(stripslashes($_POST['message'])) : '';
$file = isset($_FILES['offer_file']) ? $_FILES['offer_file'] : '';
$ref = isset($_POST['offer_ref']) ? sanitize_text_field($_POST['offer_ref']) : '';
$spamUrl = isset($_POST['url']) ? strip_tags(stripslashes($_POST['url'])) : '';

$mailto = get_field('emailsOffers', 'options');

if( !function_exists( 'wp_handle_upload' ) ){
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
}

function essor_upload_dir( $param ){
    $param['path'] = ABSPATH . '/candidatures';
    $param['url'] = get_option( 'siteurl' ) . '/candidatures';

    return $param;
}

if( isset($_POST['submit']) ){

    if( !isset($_POST['essor_offer_nonce']) || !wp_verify_nonce($_POST['essor_offer_nonce'], 'essor_offer') ){

        $error = true;
        $errorSend = 'Nous sommes désolés, une erreur est survenue! Merci de réssayer plus tard.';
    
    }else{

        if( empty($name) ){
            $errorName = true;
            $errorEmpty = true;
            $error = true;
        }

        if( empty($phone) ){
            $errorPhone = true;
            $errorEmpty = true;
            $error = true;
        } else {
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

        if( empty($file) ){
            $errorFile = true;
            $errorEmpty = true;
            $error = true;
        }else{
            if( $file['error'] ){
                $errorFileTxt = 'Le fichier fourni est invalide.';
            }else{

                if( in_array(pathinfo($file['name'])['extension'], ['pdf', 'PDF']) ){

                    if( $file['size'] <= 1258292 ){
                        add_filter('upload_dir', 'essor_upload_dir');
                        $upload = wp_handle_upload( $file, array('test_form' => false) );
                        remove_filter('upload_dir', 'essor_upload_dir');

                        if( isset($upload['error']) || !isset($upload['file']) ){
                            $errorFileTxt = 'Nous sommes désolés, le fichier n\'a pas pu être uploadé. Merci de réessayer plus tard!';
                        }
                    }else{
                        $errorFileTxt = 'Le fichier fourni est trop lourd. Merci de ne pas dépasser 1.2Mo.';
                    }

                }else{
                    $errorFileTxt = 'L\'extension du fichier n\'est pas autorisée. Merci d\'utiliser un PDF.';
                }
            }

            if( $errorFileTxt ){
                $errorFile = true;
                $errorEmpty = true;
                $error = true;
            }
        }


        if( !$error ){
            if( empty($spamUrl) ){
                $subjectMail = 'Nouveau message provenant de essor.group';

                $headers = 'From: "' . $name . '" <' . $mail . '>' . "\r\n" .
                           'Reply-To: ' . $mail . "\r\n";

                $content = 'De: ' . $name . "\r\n" .
                           'Email: ' . $mail . "\r\n" .
                           'Téléphone: ' . $phone . "\r\n\r\n" .
                           'Offre: ' . $ref . "\r\n\r\n" .
                           'Message: ' . $msg;

                $sent = wp_mail($mailto, $subjectMail, $content, $headers, $upload['file']);


                $subjectMail2 = 'Essor - Votre candidature';

                $headers2 = 'From: "Groupe Essor" <' . $mailto . '>' . "\r\n" .
                           'Reply-To: ' . $mailto . "\r\n";

                $content2 = 'Bonjour ' . $name . "\r\n\r\n\r\n" .
                'Nous accusons réception de votre candidature et nous vous remercions de l’intérêt que vous portez à notre société.' . "\r\n\r\n" .
                'Nous allons l’étudier avec la plus grande attention et nous ne manquerons pas de vous contacter si votre profil répond à nos attentes.'. "\r\n\r\n" .
                'Sans nouvelle de notre part dans un délai d’un mois à compter d’aujourd’hui, veuillez considérer que nous ne sommes pas en mesure de répondre favorablement à votre candidature.'. "\r\n\r\n" .
                'Sauf avis contraire de votre part, nous nous permettons de conserver dans notre base de données votre candidature transmise afin de vous faire part d’opportunités futures susceptibles de vous intéresser.'. "\r\n\r\n\r\n" .
                'Bien cordialement,'. "\r\n\r\n" .
                'Le service Ressources Humaines';

                wp_mail($mail, $subjectMail2, $content2, $headers2);

                if( $sent ){
                    $success = true;
                }else{
                    $error = true;
                    $errorSend = 'Nous sommes désolés, une erreur est survenue! Merci de réssayer plus tard.';
                }
            }else{
                $success = true;
            }
        }

    }
}

get_header(); ?>

	<?php if ( have_posts() ) : the_post(); ?>

		<div class='container'>
            <div class='wrapper-content-sidebar'>
                <aside class='wrapper-sticky'>
                    <div id='blockSticky'>
                        <div class='wrapper-menu-aside'>
                            <?php wp_nav_menu( array( 'theme_location' => 'jobs', 'container' => false, 'menu_class' => 'menu-aside' ) ); ?>
                        </div>
                    </div>
                </aside>
                <div class='content-sidebar'>
                    <h1 id='form'><?php the_title(); ?></h1>
                    <?php the_content(); ?>

                    <div class='form-offer'>

                        <?php if( $success ){ ?>
                            <p class='form-success'>
                                Merci, votre candidature a bien été envoyée!
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
                                    <span><?php if($errorFileTxt) echo $errorFileTxt; ?></span>
                                <?php } ?>
                            </p>
                        <?php } ?>

                        <form method='post' action='<?php the_permalink(); ?>#form' class='<?php if( $success ) echo "success"; ?>' id='form-offer' enctype='multipart/form-data'>
                            <div class='field <?php if($errorName) echo 'error'; ?>'>
                                <label for='name'>Votre prénom et nom</label>
                                <input type='text' name='full_name' id='name' value='<?php echo esc_attr( $name ); ?>' placeholder='Jean Dupont' required>
                            </div>

                            <div class='field <?php if($errorMail) echo 'error'; ?>'>
                                <label for='email'>Votre email</label>
                                <input type='email' name='email' id='email' value='<?php echo esc_attr( $mail ); ?>' placeholder='jean.dupont@laposte.net' required>
                            </div>

                            <div class='field <?php if($errorPhone) echo 'error'; ?>'>
                                <label for='tel'>Votre numéro de téléphone</label>
                                <input type='tel' name='tel' id='tel' value='<?php echo esc_attr( $phone ); ?>' placeholder='06 00 00 00 00' required>
                            </div>

                            <div class='field optional'>
                                <label for='offer_ref'>Référence de l'offre</label>
                                <input type='text' name='offer_ref' id='offer_ref' value='<?php echo esc_attr( $ref ); ?>'>
                                <i>(facultatif)</i>
                            </div>

                            <div class='field field-top <?php if($errorMsg) echo 'error'; ?>'>
                                <label for='message'>Votre message</label>
                                <textarea name='message' id='message' placeholder="J'aime beaucoup ce que vous faites! Laissez moi vous parler de mon incroyable projet." required><?php echo esc_textarea( $msg ); ?></textarea>
                            </div>

                            <div class='field <?php if($errorFile) echo 'error'; ?>'>
                                <label for='file'>CV / Lettre de motivation</label>
                                <input type='hidden' name='MAX_FILE_SIZE' value='1258292'>
                                <input type='file' name='offer_file' id='file' accept='.pdf,.PDF,application/pdf' required>
                                <span>Format PDF de moins de 1.2Mo</span>
                            </div>

                            <div class='hidden'>
                                <input type='url' name='url' id='url' value='<?php echo esc_url( $spamUrl ); ?>'>
                                <label for='url'>Merci de laisser ce champ vide.</label>
                            </div>

                            <?php wp_nonce_field( 'essor_offer', 'essor_offer_nonce' ); ?>

                            <button class='btn' type='submit' name='submit' form='form-offer'>
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