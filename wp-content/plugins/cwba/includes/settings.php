<?php
//Settings *************************************************
function portal_page_html()
{ ?>
	<div class="settings-cwba">
		<h1 class="title">Configurações da Página Inicial</h1><br>
		<hr>
		<form method="post" action="options.php">
			<?php settings_fields('portal_option_grupo'); ?>


			<!-- Nome ********************************** -->
			<label>
				<h3 class="title">Nome do Site: </h3><input type="text" id="portal_input_0" name="portal_input_0" value="<?php echo get_option('portal_input_0'); ?>" />
			</label>


			<br><br><!-- Logo *************************************** -->
			<hr>
			<?php
			$image1 = get_option('portal_input_1');
			?>
			<h3 class="title">Logo:</h3>
			<table>
				<tr>
					<td><a href="#" onclick="upload_image(1,1);" class="button button-secondary"><?php _e('Upload Image'); ?></a></td>
					<td><input type="text" name="portal_input_1" id="portal_input_1" placeholder="Logo Principal" value="<?php echo $image1; ?>" /></td>
					<td>&emsp;<a href="<?php echo $image1; ?>" target="_blank"><img style="height:30px" id="preview_portal_input_1" alt="preview" title="preview" src="<?php echo $image1; ?>" /></a></td>
				</tr>
			</table>
			<span>(Ideal size: 100x80 px)</span>


			<br><br><!-- Slide *************************************** -->
			<hr>
			<?php
			$image2 = get_option('portal_input_2'); ?>
			<h3 class="title">Slide:</h3>
			<table>
				<tr>
					<td><a href="#" onclick="upload_image(1,2);" class="button button-secondary"><?php _e('Upload Image'); ?></a></td>
					<td><input type="text" name="portal_input_2" id="portal_input_2" placeholder="Banner Principal" value="<?php echo $image2; ?>" /></td>
					<td>&emsp;<a href="<?php echo $image2; ?>" target="_blank"><img style="height:30px" id="preview_portal_input_2" alt="preview" title="preview" src="<?php echo $image2; ?>" /></a></td>
				</tr>
			</table>
			<span>(Ideal size: 1920x10 px)</span>


			<br><br><!-- Descrição *************************************** -->
			<hr>
			<label>
				<h3 class="title">Descrição do Site: </h3><input type="text" id="portal_input_3" name="portal_input_3" value="<?php echo get_option('portal_input_3'); ?>" />
			</label>

			
			<br><br><!-- Sobre ********************************** -->
			<hr>

			<label>
				<h3 class="title">Sobre: </h3>
				<?php
				$portal4 = get_option('portal_input_4'); 
				wp_editor($portal4, 'portal_about_box', array('textarea_name' => 'portal_input_4'));
				?>
				
			</label>


			<br><br><!-- Whatsapp *************************************** -->
			<hr>
			<label>
				<h3 class="title">Whatsapp: </h3><input type="text" id="portal_input_5" name="portal_input_5" value="<?php echo get_option('portal_input_5'); ?>" />
			</label>
			<br><span>(99999999999)</span>


			<br><br><!-- E-Mail *************************************** -->
			<hr>
			<label>
				<h3 class="title">E-Mail: </h3><input type="email" id="portal_input_6" name="portal_input_6" value="<?php echo get_option('portal_input_6'); ?>" />
			</label>
			<br><span>(only one)</span>			
								
			
			<br><br><!-- *************************************** -->
			<hr>	

			<?php submit_button(); ?>
		</form>
	</div>
<?php
}

function portal_options_page()
{
	add_submenu_page('cwba', 'Pagina Inicial', 'Pagina Inicial', 'edit_posts', 'pagina-inicial', 'portal_page_html', 1);
}
add_action('admin_menu', 'portal_options_page');



//************************ DB Fields

function portal_settings0()
{
	add_option('portal_input_0');
	register_setting('portal_option_grupo', 'portal_input_0');
}
add_action('admin_init', 'portal_settings0');

function portal_settings1()
{
	add_option('portal_input_1');
	register_setting('portal_option_grupo', 'portal_input_1');
}
add_action('admin_init', 'portal_settings1');

function portal_settings2()
{
	add_option('portal_input_2');
	register_setting('portal_option_grupo', 'portal_input_2');
}
add_action('admin_init', 'portal_settings2');

function portal_settings3()
{
	add_option('portal_input_3');
	register_setting('portal_option_grupo', 'portal_input_3');
}
add_action('admin_init', 'portal_settings3');

function portal_settings4()
{
	add_option('portal_input_4');
	register_setting('portal_option_grupo', 'portal_input_4');
}
add_action('admin_init', 'portal_settings4');

function portal_settings5()
{
	add_option('portal_input_5');
	register_setting('portal_option_grupo', 'portal_input_5');
}
add_action('admin_init', 'portal_settings5');

function portal_settings6()
{
	add_option('portal_input_6');
	register_setting('portal_option_grupo', 'portal_input_6');
}
add_action('admin_init', 'portal_settings6');