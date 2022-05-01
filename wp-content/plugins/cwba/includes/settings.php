<?php
//Settings *************************************************
function home_page_html()
{ ?>
	<div class="settings-cwba">
		<h1 class="title">Configurações da Pagina Inicial</h1>
		<hr>
		<form method="post" action="options.php">
			<?php settings_fields('home_option_grupo'); ?>			

			<!-- Sigla ********************************** -->

			<label>
				<h3 class="title">Sigla do Site: </h3>
				<input type="text" id="home_input_0" name="home_input_0" value="<?php echo get_option('home_input_0'); ?>" />
			</label>			

			<br><br><!-- Name *************************************** -->
			<hr>

			<label>
				<h3 class="title">Título do Site: </h3>
				<input type="text" id="home_input_1" name="home_input_1" value="<?php echo get_option('home_input_1'); ?>" />
			</label>			

			<br><br><!-- Logo *************************************** -->
			<hr>

			<?php
			$home2 = get_option('home_input_2'); ?>
			<h3 class="title">Logo:</h3>
			<table>
				<tr>
					<td><a href="#" onclick="upload_image(1,2);" class="button button-secondary"><?php _e('Upload Image'); ?></a></td>
					<td><input type="text" name="home_input_2" id="home_input_2" value="<?php echo $home2; ?>" /></td>
					<td>&emsp;<a href="<?php echo $home2; ?>" target="_blank"><img style="height:30px" id="preview_home_input_2" alt="preview" title="preview" src="<?php echo $home2; ?>" /></a></td>
				</tr>
			</table>
			<span>(Ideal size: 600x600 px)</span>
			

			<br><br><!-- Slides *************************************** -->
			<hr>

			<h3 class="title">Slides:</h3>

			<?php
			$home31 = get_option('home_input_31'); ?>
			<h3>Slide 1:</h3>
			<table>
				<tr>
					<td><a href="#" onclick="upload_image(1,31);" class="button button-secondary"><?php _e('Upload Image'); ?></a></td>
					<td><input type="text" name="home_input_31" id="home_input_31" value="<?php echo $home31; ?>" /></td>
					<td>&emsp;<a href="<?php echo $home31; ?>" target="_blank"><img style="height:30px" id="preview_home_input_31" alt="preview" title="preview" src="<?php echo $home31; ?>" /></a></td>
				</tr>
				<tr>
					<td>
						<div>Titulo do Slide</div>
					</td>
					<td><input type="text" id="home_input_32" name="home_input_32" value="<?php echo get_option('home_input_32'); ?>" /></td>
				</tr>				
				<tr>
					<td>
						<div>URL do Botão</div>
					</td>
					<td><input type="text" id="home_input_33" name="home_input_33" value="<?php echo get_option('home_input_33'); ?>" /></td>
				</tr>
			</table><br>

			<?php
			$home41 = get_option('home_input_41'); ?>
			<h3>Slide 2:</h3>
			<table>
				<tr>
					<td><a href="#" onclick="upload_image(1,41);" class="button button-secondary"><?php _e('Upload Image'); ?></a></td>
					<td><input type="text" name="home_input_41" id="home_input_41" value="<?php echo $home41; ?>" /></td>
					<td>&emsp;<a href="<?php echo $home41; ?>" target="_blank"><img style="height:30px" id="preview_home_input_41" alt="preview" title="preview" src="<?php echo $home41; ?>" /></a></td>
				</tr>
				<tr>
					<td>
						<div>Titulo do Slide</div>
					</td>
					<td><input type="text" id="home_input_42" name="home_input_42" value="<?php echo get_option('home_input_42'); ?>" /></td>
				</tr>				
				<tr>
					<td>
						<div>URL do Botão</div>
					</td>
					<td><input type="text" id="home_input_43" name="home_input_43" value="<?php echo get_option('home_input_43'); ?>" /></td>
				</tr>
			</table><br>

			<?php
			$home51 = get_option('home_input_51'); ?>
			<h3>Slide 3:</h3>
			<table>
				<tr>
					<td><a href="#" onclick="upload_image(1,51);" class="button button-secondary"><?php _e('Upload Image'); ?></a></td>
					<td><input type="text" name="home_input_51" id="home_input_51" value="<?php echo $home51; ?>" /></td>
					<td>&emsp;<a href="<?php echo $home51; ?>" target="_blank"><img style="height:30px" id="preview_home_input_51" alt="preview" title="preview" src="<?php echo $home51; ?>" /></a></td>
				</tr>
				<tr>
					<td>
						<div>Titulo do Slide</div>
					</td>
					<td><input type="text" id="home_input_52" name="home_input_52" value="<?php echo get_option('home_input_52'); ?>" /></td>
				</tr>				
				<tr>
					<td>
						<div>URL do Botão</div>
					</td>
					<td><input type="text" id="home_input_53" name="home_input_53" value="<?php echo get_option('home_input_53'); ?>" /></td>
				</tr>
			</table><br>

			<br><span>(<b>Slide</b>; Ideal size: 1920x680 px)</span>

			<br><br><!-- Foto Sobre *************************************** -->
			<hr>

			<?php
			$home6 = get_option('home_input_6'); ?>
			<h3 class="title">Foto Sobre:</h3>
			<table>
				<tr>
					<td><a href="#" onclick="upload_image(1,6);" class="button button-secondary"><?php _e('Upload Image'); ?></a></td>
					<td><input type="text" name="home_input_6" id="home_input_6" value="<?php echo $home6; ?>" /></td>
					<td>&emsp;<a href="<?php echo $home6; ?>" target="_blank"><img style="height:30px" id="preview_home_input_6" alt="preview" title="preview" src="<?php echo $home6; ?>" /></a></td>
				</tr>
			</table>
			<span>(Ideal size: 1460x880 px)</span>

			<br><br><!-- Video Sobre *************************************** -->
			<hr>

			<label>
				<h3 class="title">Vídeo Sobre: </h3>
				<input type="text" id="home_input_6_2" name="home_input_6_2" value="<?php echo get_option('home_input_6_2'); ?>" />
			</label>

			<br><br><!-- Texto Sobre ********************************** -->
			<hr>

			<label>
				<h3 class="title">Texto Sobre: </h3>
				<?php
				$home7 = get_option('home_input_7'); 
				wp_editor($home7, 'home_about_box', array('textarea_name' => 'home_input_7'));
				?>
				
			</label>
			
			<br><br><!-- Blocos Contadores ****************************** -->
			<hr>

			<h3 class="title">Blocos Contadores:</h3>
			<label>
				<h3>Bloco 1: </h3><input type="text" id="home_input_8" name="home_input_8" value="<?php echo get_option('home_input_8'); ?>" />
			</label><br>
			<label>
				<h3>Bloco 2: </h3><input type="text" id="home_input_9" name="home_input_9" value="<?php echo get_option('home_input_9'); ?>" />
			</label><br>
			<label>
				<h3>Bloco 3: </h3><input type="text" id="home_input_10" name="home_input_10" value="<?php echo get_option('home_input_10'); ?>" />
			</label><br>
			<label>
				<h3>Bloco 4: </h3><input type="text" id="home_input_11" name="home_input_11" value="<?php echo get_option('home_input_11'); ?>" />
			</label><br>
			<br><span>(Use <b>Icone,Valor,Texto</b> separados por vírgulas. Escolha o ícone <a href="https://icon-sets.iconify.design/bx/" target="_blank">aqui</a>)</span>


			<br><br><!-- Fone *************************************** -->
			<hr>

			<label>
				<h3 class="title">Telefone: </h3><input type="text" id="home_input_12" name="home_input_12" value="<?php echo get_option('home_input_12'); ?>" />
			</label>			

			<br><br><!-- E-Mail *************************************** -->
			<hr>

			<label>
				<h3 class="title">E-Mail: </h3><input type="email" id="home_input_13" name="home_input_13" value="<?php echo get_option('home_input_13'); ?>" />
			</label>							
			
			<br><br><!-- Endereço *************************************** -->
			<hr>

			<label>
				<h3 class="title">Endereço: </h3><input type="text" id="home_input_14" name="home_input_14" value="<?php echo get_option('home_input_14'); ?>" />
			</label>
			
			<br><br><!-- Maps *************************************** -->
			<hr>

			<label>
				<h3 class="title">Mapa: </h3><input type="text" id="home_input_15" name="home_input_15" value="<?php echo get_option('home_input_15'); ?>" />
			</label>
			<br><span>Ex.: https://www.google.com/maps/embed?xxx</span>
			
			
			<br><br><!-- Facebook *************************************** -->
			<hr>

			<label>
				<h3 class="title">Facebook: </h3><input type="text" id="home_input_16" name="home_input_16" value="<?php echo get_option('home_input_16'); ?>" />
			</label>

			<br><br><!-- Instagram *************************************** -->
			<hr>

			<label>
				<h3 class="title">Instagram: </h3><input type="text" id="home_input_17" name="home_input_17" value="<?php echo get_option('home_input_17'); ?>" />
			</label>
			
			<br><br><!-- *************************************** -->
			<hr>		

			<?php submit_button(); ?>
		</form>
	</div>
<?php
}

function home_options_page()
{
	add_submenu_page('options-general.php', 'Pagina Inicial', 'Pagina Inicial', 'edit_posts', 'home_page', 'home_page_html',0);
}
add_action('admin_menu', 'home_options_page');



//************************ DB Fields

function home_settings0()
{
	add_option('home_input_0');
	register_setting('home_option_grupo', 'home_input_0');
}
add_action('admin_init', 'home_settings0');

function home_settings1()
{
	add_option('home_input_1');
	register_setting('home_option_grupo', 'home_input_1');
}
add_action('admin_init', 'home_settings1');

function home_settings2()
{
	add_option('home_input_2');
	register_setting('home_option_grupo', 'home_input_2');
}
add_action('admin_init', 'home_settings2');

function home_settings31()
{
	add_option('home_input_31');
	register_setting('home_option_grupo', 'home_input_31');
}
add_action('admin_init', 'home_settings31');

function home_settings32()
{
	add_option('home_input_32');
	register_setting('home_option_grupo', 'home_input_32');
}
add_action('admin_init', 'home_settings32');

function home_settings33()
{
	add_option('home_input_33');
	register_setting('home_option_grupo', 'home_input_33');
}
add_action('admin_init', 'home_settings33');

function home_settings41()
{
	add_option('home_input_41');
	register_setting('home_option_grupo', 'home_input_41');
}
add_action('admin_init', 'home_settings41');

function home_settings42()
{
	add_option('home_input_42');
	register_setting('home_option_grupo', 'home_input_42');
}
add_action('admin_init', 'home_settings42');

function home_settings43()
{
	add_option('home_input_43');
	register_setting('home_option_grupo', 'home_input_43');
}
add_action('admin_init', 'home_settings43');

function home_settings51()
{
	add_option('home_input_51');
	register_setting('home_option_grupo', 'home_input_51');
}
add_action('admin_init', 'home_settings51');

function home_settings52()
{
	add_option('home_input_52');
	register_setting('home_option_grupo', 'home_input_52');
}
add_action('admin_init', 'home_settings52');

function home_settings53()
{
	add_option('home_input_53');
	register_setting('home_option_grupo', 'home_input_53');
}
add_action('admin_init', 'home_settings53');

function home_settings6()
{
	add_option('home_input_6');
	register_setting('home_option_grupo', 'home_input_6');
}
add_action('admin_init', 'home_settings6');

function home_settings6_2()
{
	add_option('home_input_6_2');
	register_setting('home_option_grupo', 'home_input_6_2');
}
add_action('admin_init', 'home_settings6_2');

function home_settings7()
{
	add_option('home_input_7');
	register_setting('home_option_grupo', 'home_input_7');
}
add_action('admin_init', 'home_settings7');

function home_settings8()
{
	add_option('home_input_8');
	register_setting('home_option_grupo', 'home_input_8');
}
add_action('admin_init', 'home_settings8');

function home_settings9()
{
	add_option('home_input_9');
	register_setting('home_option_grupo', 'home_input_9');
}
add_action('admin_init', 'home_settings9');

function home_settings10()
{
	add_option('home_input_10');
	register_setting('home_option_grupo', 'home_input_10');
}
add_action('admin_init', 'home_settings10');

function home_settings11()
{
	add_option('home_input_11');
	register_setting('home_option_grupo', 'home_input_11');
}
add_action('admin_init', 'home_settings11');

function home_settings12()
{
	add_option('home_input_12');
	register_setting('home_option_grupo', 'home_input_12');
}
add_action('admin_init', 'home_settings12');

function home_settings13()
{
	add_option('home_input_13');
	register_setting('home_option_grupo', 'home_input_13');
}
add_action('admin_init', 'home_settings13');

function home_settings14()
{
	add_option('home_input_14');
	register_setting('home_option_grupo', 'home_input_14');
}
add_action('admin_init', 'home_settings14');

function home_settings15()
{
	add_option('home_input_15');
	register_setting('home_option_grupo', 'home_input_15');
}
add_action('admin_init', 'home_settings15');

function home_settings16()
{
	add_option('home_input_16');
	register_setting('home_option_grupo', 'home_input_16');
}
add_action('admin_init', 'home_settings16');

function home_settings17()
{
	add_option('home_input_17');
	register_setting('home_option_grupo', 'home_input_17');
}
add_action('admin_init', 'home_settings17');