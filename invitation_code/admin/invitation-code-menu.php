<?php

require(plugin_dir_path( __FILE__ ) .'invitation_code/includes/ic-aux-functions.php');

function addInvitationCodeContent() {
    add_menu_page('codigos-invitacion', 'Códigos de Invitación', 'manage_options' ,__FILE__, 'invitationCodeAdminPage', 'dashicons-nametag');
}

function invitationCodeAdminPage() {
    global $wpdb;
	$admin_invitation_code_url = 'admin.php?page=ezcomerce-plugin%2Finvitation_code%2Fadmin%2Finvitation-code-menu.php';
    $table_name = $wpdb->prefix . 'ez_invitation_codes';
    if (isset($_POST['newsubmit'])) {
      $invitation_code = $_POST['new-invitation-code'];
      $user_role = $_POST['new-user-role'];
      $wpdb->query("INSERT INTO $table_name(invitation_code,user_role) VALUES('$invitation_code','$user_role')");
      echo "<script>location.replace('$admin_invitation_code_url');</script>";
    }
    if (isset($_POST['uptsubmit'])) {
      $id = $_POST['upt-id'];
      $invitation_code = $_POST['upt-invitation-code'];
      $user_role = $_POST['upt-user-role'];
      $wpdb->query("UPDATE $table_name SET invitation_code='$invitation_code',user_role='$user_role' WHERE ID='$id'");
      echo "<script>location.replace('$admin_invitation_code_url');</script>";
    }
    if (isset($_GET['del'])) {
      $del_id = $_GET['del'];
      $wpdb->query("DELETE FROM $table_name WHERE ID='$del_id'");
      echo "<script>location.replace('$admin_invitation_code_url');</script>";
    }
    ?>
    <div class="wrap">
            <h2>Códigos de Invitación</h2>
            <table class="wp-list-table widefat striped">
                <thead>
                    <tr>
                        <th width="25%">ID</th>
                        <th width="25%">Codigo de Invitación</th>
                        <th width="25%">Rol</th>
                        <th width="25%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <form action="" method="post">
                        <tr>
                            <td><input type="text" value="Auto Generado" disabled></td>
                            <td><input type="text" id="new-invitation-code" name="new-invitation-code"></td>
							<td>
							<select id="new-user-role" name="new-user-role">
  								<?php 
									$roles_arr = get_role_names();
									foreach($roles_arr as $key => $value) { ?>
    								<option value="<?php echo $key ?>"><?php echo $value ?></option>
  								<?php }?>
							</select>
							</td>
                            <td><button id="newsubmit" name="newsubmit" type="submit">Insertar</button></td>
                        </tr>
                    </form>
                    <?php
                    $result = $wpdb->get_results("SELECT * FROM $table_name");
                    foreach ($result as $print) {
                    echo "
                        <tr>
                        <td width='25%'>$print->ID</td>
                        <td width='25%'>$print->invitation_code</td>
                        <td width='25%'>$print->user_role</td>
                        <td width='25%'><a href='$admin_invitation_code_url&upt=$print->ID'><button type='button'>Actualizar</button></a> <a href= '$admin_invitation_code_url&del=$print->ID'><button type='button'>Eliminar</button></a></td>
                        </tr>
                        ";
                    }
                    ?>
                </tbody>
            </table>
        <br>
        <br>
        <?php
            if (isset($_GET['upt'])) {
            $upt_id = $_GET['upt'];
            $result = $wpdb->get_results("SELECT * FROM $table_name WHERE ID='$upt_id'");
            foreach($result as $print) {
                $invitation_code = $print->invitation_code;
                $user_role = $print->user_role;
            }
			$roles_arr_upt = get_role_names();
			$options = "";
			foreach( $roles_arr_upt as $key => $value ){
				$options .= '<option value="'.$key.'">'.$value.'</option>'."\n";
			}
			echo 
			"
            <table class='wp-list-table widefat striped'>
                    <thead>
                    <tr>
                        <th width='25%'>ID</th>
                        <th width='25%'>Codigo de Invitación</th>
                        <th width='25%'>Rol</th>
                        <th width='25%'>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <form action='' method='post'>
                        <tr>
                        <td width='25%'>$print->ID <input type='hidden' id='upt-id' name='upt-id' value='$print->ID'></td>
                        <td width='25%'><input type='text' id='upt-invitation-code' name='upt-invitation-code' value='$print->invitation_code'></td>
						<td>
						<select id='upt-user-role' name='upt-user-role'>
							$options
						</select>
						</td>
                        <td width='25%'><button id='uptsubmit' name='uptsubmit' type='submit'>Actualizar</button> <a href='$admin_invitation_code_url'><button type='button'>Cancelar</button></a></td>
                        </tr>
                    </form>
                    </tbody>
              </table>
              ";
            }
        ?>
    </div>
    <?php
}