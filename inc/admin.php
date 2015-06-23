<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'admin_menu', 'apb_add_admin_menu' );
add_action( 'admin_init', 'apb_settings_init' );


function apb_add_admin_menu() {
	$my_options_page = add_options_page( 'Aletheia Project', 'Aletheia Project', 'manage_options', 'aletheia_project', 'apb_options_page' );
    add_action( 'admin_print_scripts-' . $my_options_page, 'apb_load_chosen' );
}

function apb_load_chosen() {
    wp_enqueue_script( 'chosen' );
    wp_enqueue_style( 'chosen' );
    echo "<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('select.chosen').chosen();});</script>";
}

function apb_settings_init() {

	register_setting( 'pluginPage', 'apb_settings' );

	add_settings_section(
		'apb_pluginPage_section',
		__( 'Bible Data', 'apb' ),
		'apb_settings_section_callback',
		'pluginPage'
	);

	add_settings_field(
		'apb_csv_upload',
		__( 'Choose a CSV file', 'apb' ),
		'apb_csv_upload_render',
		'pluginPage',
		'apb_pluginPage_section'
	);

	add_settings_field(
		'apb_language',
		__( 'Language', 'apb' ),
		'apb_language_render',
		'pluginPage',
		'apb_pluginPage_section'
	);

    wp_register_script( 'chosen', plugins_url( '/chosen/chosen.jquery.min.js', __FILE__ ) );
    wp_register_style( 'chosen', plugins_url( '/chosen/chosen.min.css', __FILE__ ) );
}


function apb_csv_upload_render() {
	echo '<input type="file" id="csv" /><br/>';
    echo '<a target="_blank" href="' . plugin_dir_url( __FILE__ ) . 'starter-csv.zip">Download a starter CSV file</a>';
}


function apb_language_render() {

	$options = get_option( 'apb_settings' );

    echo '<select class="chosen" name="apb_settings[\'apb_language\']">
        <option value="af">Afrikaans</option>
        <option value="am">Amharic</option>
        <option value="ar-sa">Arabic (Saudi Arabia)</option>
        <option value="as">Assamese</option>
        <option value="az-Latn">Azerbaijani (Latin)</option>
        <option value="be">Belarusian</option>
        <option value="bg">Bulgarian</option>
        <option value="bn-BD">Bangla (Bangladesh)</option>
        <option value="bn-IN">Bangla (India)</option>
        <option value="bs">Bosnian (Latin)</option>
        <option value="ca">Catalan Spanish</option>
        <option value="ca-ES-valencia">Valencian</option>
        <option value="cs">Czech</option>
        <option value="cy">Welsh</option>
        <option value="da">Danish</option>
        <option value="de">German (Germany)</option>
        <option value="de-de">German (Germany)</option>
        <option value="el">Greek</option>
        <option value="en-GB">English (United Kingdom)</option>
        <option value="en-US">English (United States)</option>
        <option value="es">Spanish (Spain)</option>
        <option value="es-ES">Spanish (Spain)</option>
        <option value="es-US">Spanish (United States)</option>
        <option value="es-MX">Spanish (Mexico)</option>
        <option value="et">Estonian</option>
        <option value="eu">Basque</option>
        <option value="fa">Persian</option>
        <option value="fi">Finnish</option>
        <option value="fil-Latn">Filipino</option>
        <option value="fr">French (France)</option>
        <option value="fr-FR">French (France)</option>
        <option value="fr-CA">French (Canada)</option>
        <option value="ga">Irish</option>
        <option value="gd-Latn">Scottish Gaelic</option>
        <option value="gl">Galician</option>
        <option value="gu">Gujarati</option>
        <option value="ha-Latn">Hausa (Latin)</option>
        <option value="he">Hebrew</option>
        <option value="hi">Hindi</option>
        <option value="hr">Croatian</option>
        <option value="hu">Hungarian</option>
        <option value="hy">Armenian</option>
        <option value="id">Indonesian</option>
        <option value="ig-Latn">Igbo</option>
        <option value="is">Icelandic</option>
        <option value="it">Italian (Italy)</option>
        <option value="it-it">Italian (Italy)</option>
        <option value="ja">Japanese</option>
        <option value="ka">Georgian</option>
        <option value="kk">Kazakh</option>
        <option value="km">Khmer</option>
        <option value="kn">Kannada</option>
        <option value="ko">Korean</option>
        <option value="kok">Konkani</option>
        <option value="ku-Arab">Central Curdish</option>
        <option value="ky-Cyrl">Kyrgyz</option>
        <option value="lb">Luxembourgish</option>
        <option value="lt">Lithuanian</option>
        <option value="lv">Latvian</option>
        <option value="mi-Latn">Maori</option>
        <option value="mk">Macedonian</option>
        <option value="ml">Malayalam</option>
        <option value="mn-Cyrl">Mongolian (Cyrillic)</option>
        <option value="mr">Marathi</option>
        <option value="ms">Malay (Malaysia)</option>
        <option value="mt">Maltese</option>
        <option value="nb">Norwegian (Bokmal)</option>
        <option value="ne">Nepali (Nepal)</option>
        <option value="nl">Dutch (Netherlands)</option>
        <option value="nl-BE">Dutch (Netherlands)</option>
        <option value="nn">Norwegian (Nynorsk)</option>
        <option value="nso">Sesotho sa Leboa</option>
        <option value="or">Odia</option>
        <option value="pa">Punjabi (Gurmukhi)</option>
        <option value="pa-Arab">Punjabi (Arabic)</option>
        <option value="pl">Polish</option>
        <option value="prs-Arab">Dari</option>
        <option value="pt-BR">Portuguese (Brazil)</option>
        <option value="pt-PT">Portuguese (Portugal)</option>
        <option value="qut-Latn">Kiche</option>
        <option value="quz">Quechua (Peru)</option>
        <option value="ro">Romanian (Romania)</option>
        <option value="ru">Russian</option>
        <option value="rw">Kinyarwanda</option>
        <option value="sd-Arab">Sindhi (Arabic)</option>
        <option value="si">Sinhala</option>
        <option value="sk">Slovak</option>
        <option value="sl">Slovenian</option>
        <option value="sq">Albanian</option>
        <option value="sr-Cyrl-BA">Serbian (Cyrillic, Bosnia and Herzegovina)</option>
        <option value="sr-Cyrl-RS">Serbian (Cyrillic, Serbia)</option>
        <option value="sr-Latn-RS">Serbian (Latin, Serbia)</option>
        <option value="sv">Swedish (Sweden)</option>
        <option value="sw">Kiswahili</option>
        <option value="ta">Tamil</option>
        <option value="te">Telugu</option>
        <option value="tg-Cyrl">Tajik (Cyrillic)</option>
        <option value="th">Thai</option>
        <option value="ti">Tigrinya</option>
        <option value="tk-Latn">Turkmen (Latin)</option>
        <option value="tn">Setswana</option>
        <option value="tr">Turkish</option>
        <option value="tt-Cyrl">Tatar (Cyrillic)</option>
        <option value="ug-Arab">Uyghur</option>
        <option value="uk">Ukrainian</option>
        <option value="ur">Urdu</option>
        <option value="uz-Latn">Uzbek (Latin)</option>
        <option value="vi">Vietnamese</option>
        <option value="wo">Wolof</option>
        <option value="xh">isiXhosa</option>
        <option value="yo-Latn">Yoruba</option>
        <option value="zh-Hans">Chinese (Simplified)</option>
        <option value="zh-Hant">Chinese (Traditional)</option>
        <option value="zu">isiZulu</option>
    </select>';
}


function apb_settings_section_callback() {
	echo __( 'Upload a CSV file and choose the language', 'apb' );
}


function apb_options_page() {
	?>
	<form action='options.php' method='post'>

		<h2>Aletheia Project</h2>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>

	</form>
	<?php

}
