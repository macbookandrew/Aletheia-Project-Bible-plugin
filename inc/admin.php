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
    echo "<script type=\"text/javascript\">(function(){var cTimer = setInterval(function(){if(window.jQuery){jQuery(document).ready(function(){jQuery('select.chosen').chosen();});clearInterval(cTimer);}},100);})();</script>";
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
    echo '<p>Make sure the file is saved with UTF-8 encoding (look in the &ldquo;Save As&hellip;&rdquo; options when saving from Excel or Numbers).</p>';
    echo '<a target="_blank" href="' . plugin_dir_url( __FILE__ ) . 'starter-csv.zip">Download a starter CSV file</a>';
}


function apb_language_render() {

	$options = get_option( 'apb_settings' );

    echo '<select class="chosen" name="apb_settings[\'apb_language\']">
        <option value="af">Afrikaans [af]</option>
        <option value="am">Amharic [am]</option>
        <option value="ar-sa">Arabic (Saudi Arabia) [ar-sa]</option>
        <option value="as">Assamese [as]</option>
        <option value="az-Latn">Azerbaijani (Latin) [az-Latn]</option>
        <option value="be">Belarusian [be]</option>
        <option value="bg">Bulgarian [bg]</option>
        <option value="bn-BD">Bangla (Bangladesh) [bn-BD]</option>
        <option value="bn-IN">Bangla (India) [bn-IN]</option>
        <option value="bs">Bosnian (Latin) [bs]</option>
        <option value="ca">Catalan Spanish [ca]</option>
        <option value="ca-ES-valencia">Valencian [ca-ES-valencia]</option>
        <option value="cs">Czech [cs]</option>
        <option value="cy">Welsh [cy]</option>
        <option value="da">Danish [da]</option>
        <option value="de">German (generic) [de]</option>
        <option value="de-de">German (Germany) [de-de]</option>
        <option value="el">Greek [el]</option>
        <option value="en">English (generic) [en]</option>
        <option value="en-GB">English (United Kingdom) [en-GB]</option>
        <option value="en-US">English (United States) [en-US]</option>
        <option value="es">Spanish (generic) [es]</option>
        <option value="es-ES">Spanish (Spain) [es-ES]</option>
        <option value="es-US">Spanish (United States) [es-US]</option>
        <option value="es-MX">Spanish (Mexico) [es-MX]</option>
        <option value="et">Estonian [et]</option>
        <option value="eu">Basque [eu]</option>
        <option value="fa">Persian [fa]</option>
        <option value="fi">Finnish [fi]</option>
        <option value="fil-Latn">Filipino [fil-Latn]</option>
        <option value="fr">French (generic) [fr]</option>
        <option value="fr-FR">French (France) [fr-FR]</option>
        <option value="fr-CA">French (Canada) [fr-CA]</option>
        <option value="ga">Irish [ga]</option>
        <option value="gd-Latn">Scottish Gaelic [gd-Latn]</option>
        <option value="gl">Galician [gl]</option>
        <option value="gu">Gujarati [gu]</option>
        <option value="ha-Latn">Hausa (Latin) [ha-Latn]</option>
        <option value="he">Hebrew [he]</option>
        <option value="hi">Hindi [hi]</option>
        <option value="hr">Croatian [hr]</option>
        <option value="hu">Hungarian [hu]</option>
        <option value="hy">Armenian [hy]</option>
        <option value="id">Indonesian [id]</option>
        <option value="ig-Latn">Igbo [ig-Latn]</option>
        <option value="is">Icelandic [is]</option>
        <option value="it">Italian (generic) [it]</option>
        <option value="it-it">Italian (Italy) [it-it]</option>
        <option value="ja">Japanese [ja]</option>
        <option value="ka">Georgian [ka]</option>
        <option value="kk">Kazakh [kk]</option>
        <option value="km">Khmer [km]</option>
        <option value="kn">Kannada [kn]</option>
        <option value="ko">Korean [ko]</option>
        <option value="kok">Konkani [kok]</option>
        <option value="ku-Arab">Central Curdish [ku-Arab]</option>
        <option value="ky-Cyrl">Kyrgyz [ky-Cyrl]</option>
        <option value="lb">Luxembourgish [lb]</option>
        <option value="lt">Lithuanian [lt]</option>
        <option value="lv">Latvian [lv]</option>
        <option value="mi-Latn">Maori [mi-Latn]</option>
        <option value="mk">Macedonian [mk]</option>
        <option value="ml">Malayalam [ml]</option>
        <option value="mn-Cyrl">Mongolian (Cyrillic) [mn-Cyrl]</option>
        <option value="mr">Marathi [mr]</option>
        <option value="ms">Malay (Malaysia) [ms]</option>
        <option value="mt">Maltese [mt]</option>
        <option value="nb">Norwegian (Bokmal) [nb]</option>
        <option value="ne">Nepali (Nepal) [ne]</option>
        <option value="nl">Dutch (generic) [nl]</option>
        <option value="nl-BE">Dutch (Netherlands) [nl-BE]</option>
        <option value="nn">Norwegian (Nynorsk) [nn]</option>
        <option value="nso">Sesotho sa Leboa [nso]</option>
        <option value="or">Odia [or]</option>
        <option value="pa">Punjabi (Gurmukhi) [pa]</option>
        <option value="pa-Arab">Punjabi (Arabic) [pa-Arab]</option>
        <option value="pl">Polish [pl]</option>
        <option value="prs-Arab">Dari [prs-Arab]</option>
        <option value="pt-BR">Portuguese (Brazil) [pt-BR]</option>
        <option value="pt-PT">Portuguese (Portugal) [pt-PT]</option>
        <option value="qut-Latn">Kiche [qut-Latn]</option>
        <option value="quz">Quechua (Peru) [quz]</option>
        <option value="ro">Romanian (Romania) [ro]</option>
        <option value="ru">Russian [ru]</option>
        <option value="rw">Kinyarwanda [rw]</option>
        <option value="sd-Arab">Sindhi (Arabic) [sd-Arab]</option>
        <option value="si">Sinhala [si]</option>
        <option value="sk">Slovak [sk]</option>
        <option value="sl">Slovenian [sl]</option>
        <option value="sq">Albanian [sq]</option>
        <option value="sr-Cyrl-BA">Serbian (Cyrillic, Bosnia and Herzegovina) [sr-Cyrl-BA]</option>
        <option value="sr-Cyrl-RS">Serbian (Cyrillic, Serbia) [sr-Cyrl-RS]</option>
        <option value="sr-Latn-RS">Serbian (Latin, Serbia) [sr-Latn-RS]</option>
        <option value="sv">Swedish (Sweden) [sv]</option>
        <option value="sw">Kiswahili [sw]</option>
        <option value="ta">Tamil [ta]</option>
        <option value="te">Telugu [te]</option>
        <option value="tg-Cyrl">Tajik (Cyrillic) [tg-Cyrl]</option>
        <option value="th">Thai [th]</option>
        <option value="ti">Tigrinya [ti]</option>
        <option value="tk-Latn">Turkmen (Latin) [tk-Latn]</option>
        <option value="tn">Setswana [tn]</option>
        <option value="tr">Turkish [tr]</option>
        <option value="tt-Cyrl">Tatar (Cyrillic) [tt-Cyrl]</option>
        <option value="ug-Arab">Uyghur [ug-Arab]</option>
        <option value="uk">Ukrainian [uk]</option>
        <option value="ur">Urdu [ur]</option>
        <option value="uz-Latn">Uzbek (Latin) [uz-Latn]</option>
        <option value="vi">Vietnamese [vi]</option>
        <option value="wo">Wolof [wo]</option>
        <option value="xh">isiXhosa [xh]</option>
        <option value="yo-Latn">Yoruba [yo-Latn]</option>
        <option value="zh-Hans">Chinese (Simplified) [zh-Hans]</option>
        <option value="zh-Hant">Chinese (Traditional) [zh-Hant]</option>
        <option value="zu">isiZulu [zu]</option>
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
