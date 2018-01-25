<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'grishagv_hse');


/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '[4#1Imw8IKQ.{?D1:Ei5`$k}R]wu9L^: j_fKN?x.H8^ Om&=?-wf.~rJ&hv|UTu');
define('SECURE_AUTH_KEY',  '|e538~1;sF;/Vo{yL)pv6tNjs&_^xU)=@y$3xIZa4TM+<G(O@foMm:p2lIM_1cWp');
define('LOGGED_IN_KEY',    'C%@p$^)(A&BGym qEj&ip:eSx%f#^jjc*;Nd2Ls6DDDD$QXCLz7$YA:8T <xp:HJ');
define('NONCE_KEY',        ' Pj`*&^6F/Ev:vVNO:n-|g_>&BIv<9e1 Mv4;8[UU:.~#b3L4*].G/&II|;:Rn#h');
define('AUTH_SALT',        '7SLCt>}_a9w}vK&$kO?+nl&FnFGutt?rF^.]bRX/ZL[i(`xAmpq3WPUT7f1o|,X2');
define('SECURE_AUTH_SALT', ':o+>0cu@5sL`%ZPB6uy8tSKQ2*_0W?jI.sUzQU %wp$}/Ww(&U}sW8qj9oo_JQ--');
define('LOGGED_IN_SALT',   'R,_]X7AR#Q=_}m6z_R?1|49Fmph )?.0G_$ahTta{v,x3:Rb-w{R].-h-H-)*JzE');
define('NONCE_SALT',       '2{>mJvKpp-AXORF _<JAELuqnm )Z8vI4;;!:ylLUwqDeyq1)D7BfLA{>RArNXK%');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
