<?php

function addPriceByRoleContent() {
    add_menu_page('precio-por-rol', 'Precios por Rol', 'manage_options' ,__FILE__, 'priceByRoleAdminPage', 'dashicons-money');
}

function priceByRoleAdminPage() {
    global $wpdb;
	$admin_price_by_role_url = 'admin.php?page=ezcomerce-plugin%2Fprice_by_role%2Fadmin%2Fprice-by-role-menu.php';
    $table_name = $wpdb->prefix . 'ez_price_by_role';
    if (isset($_POST['newsubmit'])) {
      $discount_percentage = $_POST['new-discount-percentage'];
      $user_role = $_POST['new-user-role'];
      $wpdb->query("INSERT INTO $table_name(discount_percentage,user_role) VALUES('$discount_percentage','$user_role')");
      echo "<script>location.replace('$admin_price_by_role_url');</script>";
    }
    if (isset($_POST['uptsubmit'])) {
      $id = $_POST['upt-id'];
      $discount_percentage = $_POST['upt-discount-percentage'];
      $user_role = $_POST['upt-user-role'];
      $wpdb->query("UPDATE $table_name SET discount_percentage='$discount_percentage',user_role='$user_role' WHERE ID='$id'");
      echo "<script>location.replace('$admin_price_by_role_url');</script>";
    }
    if (isset($_GET['del'])) {
      $del_id = $_GET['del'];
      $wpdb->query("DELETE FROM $table_name WHERE ID='$del_id'");
      echo "<script>location.replace('$admin_price_by_role_url');</script>";
    }
    ?>
    <div class="wrap">
            <h2>Descuentos por Rol</h2>
            <table class="wp-list-table widefat striped">
                <thead>
                    <tr>
                        <th width="25%">ID</th>
                        <th width="25%">Porcentaje de descuento %</th>
                        <th width="25%">Rol</th>
                        <th width="25%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <form action="" method="post">
                        <tr>
                            <td><input type="text" value="Auto Generado" disabled></td>
                            <td><input type="text" id="new-discount-percentage" name="new-discount-percentage"></td>
							<td>
							<select id="new-user-role" name="new-user-role">
  								<?php 
									$roles_arr = get_available_role_names();
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
                        <td width='25%'>$print->discount_percentage</td>
                        <td width='25%'>$print->user_role</td>
                        <td width='25%'><a href='$admin_price_by_role_url&upt=$print->ID'><button type='button'>Actualizar</button></a> <a href= '$admin_price_by_rol_url&del=$print->ID'><button type='button'>Eliminar</button></a></td>
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
                $discount_percentage = $print->discount_percentage;
                $user_role = $print->user_role;
            }
			$roles_arr_upt = get_available_role_names();
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
                        <th width='25%'>Porcentaje de descuento %</th>
                        <th width='25%'>Rol</th>
                        <th width='25%'>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <form action='' method='post'>
                        <tr>
                        <td width='25%'>$print->ID <input type='hidden' id='upt-id' name='upt-id' value='$print->ID'></td>
                        <td width='25%'><input type='text' id='upt-invitation-code' name='upt-invitation-code' value='$print->discount_percentage'></td>
						<td>
						<select id='upt-user-role' name='upt-user-role'>
							$options
						</select>
						</td>
                        <td width='25%'><button id='uptsubmit' name='uptsubmit' type='submit'>Actualizar</button> <a href='$admin_price_by_role_url'><button type='button'>Cancelar</button></a></td>
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