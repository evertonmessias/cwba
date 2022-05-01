<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

define('WP_HOME','https://wordpress.evertonm.com/');
define('WP_SITEURL','https://wordpress.evertonm.com/');
define('FS_METHOD','direct');
define( 'WP_MEMORY_LIMIT', '1024M' );

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'cwba' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'root' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', 'efc;2505xx' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'zN7hc%R2D5z.l;(m~u@y{h]T0[>2E||Q?<Uw%>HEp|xGWH;>lc-12=.MijsU=daD' );
define( 'SECURE_AUTH_KEY',  '+Y/Xs29Wl|#xpDb=G{+a[tnX_hau6ith]#6O1u^vu*P{2_i]$/FT`Kp$z?_5/VYv' );
define( 'LOGGED_IN_KEY',    'plRoBC8FiA&s>rWBvW4G.8)h.BoMdj]I0TJ4ZC>/G1+l.;L!6B,IjTy=& R1wp9T' );
define( 'NONCE_KEY',        ']pjn<r7H*N|z>&{yiTq^FdysD}h5fy]Jb[iIt;IVFBf foFv*Y(DyU[1QUmr4aOz' );
define( 'AUTH_SALT',        'qx(-0J!ErmYFHD7@u-EcQu!Jq)awP&Ne&;Wi;w}b&tqn1S{aXaaYk0Z?<RzficO5' );
define( 'SECURE_AUTH_SALT', 'LYMdd@XzC]ud-i7g8oL0u_ebWL!tGtnC9Sy*F<{t$2 tgaRX*R]Iq7P= ZRsu ug' );
define( 'LOGGED_IN_SALT',   '^+#: -Y(_tN34Q8JAfz$CLxIBd3GdOMF]$-1W-)A0$UJxdu$uc8r?a{EcQT8`y+G' );
define( 'NONCE_SALT',       'jCp7>>=Qvy!tg<HCM!KV5d7V2ZLXc_yJixXbdNwm++|v%oMrX)9V^]6z5p03a,]W' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* Adicione valores personalizados entre esta linha até "Isto é tudo". */



/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';
