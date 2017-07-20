<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'essor');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'root');

/** Adresse de l’hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8mb4');

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'mng_m(!Yw.w(i8W_,$[O(@LM;ui]xIcJ#I(ZgOTT(P:(NZG&2:P>OS2_Mz +.xZt');
define('SECURE_AUTH_KEY',  ']:yvS_F`=x r7E)=gA2;&M%LKptF}Z,z+U0~IEb7nO7bk)0UT>-r$izcTwdD)=Da');
define('LOGGED_IN_KEY',    '$8%xgH`sn3k7,u^oDPNqT$_/=-Q75b1{/Q}#IVViG{#,n5rx+T9QwT(.,#eXc7M$');
define('NONCE_KEY',        'He|QlUreEJ-S.$3uXS^Njtz@SQ` &e{3GoUr4?b4}Jg)6NSe)P+>wZPW1khH9< K');
define('AUTH_SALT',        'f+!4d(9xLj08QNT^$]Wm(tC7@?=,DdCxP}&I&iAl!ip]=pkG`uX<V^yQMBDUZ,h0');
define('SECURE_AUTH_SALT', 'T 29;F@WB]bxUtf%R~vOr>,)f0>cIJW-O9 Z<!#LNVzu%~z@rmoSLERo7vf*Z*?V');
define('LOGGED_IN_SALT',   'u`.+EP#`GFvC7}T8H>[h%u@+%BTo0f?e3Sr._&Mw;(e(KRR!>I?NBV;?19OV+#[e');
define('NONCE_SALT',       'A*ac8bChvb$qB-m1xFg!h*Rco8=U|A^udET/[K_E&(EfkE)Z]*)AT#5Pu,N0Q-}6');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix  = 'essor_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');