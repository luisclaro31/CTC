<?php 
/*
 * Vista Login
 * Excellentiam S.E.
 * Fecha creacion: 12/09/14
 */
include($_SERVER['DOCUMENT_ROOT']."/application/views/funcionesGenericas.php");

$tituloPagina = "Login";
CabeceraLogin($tituloPagina);
echo form_open('login/ValidaUsuario'); 
?>
    
<div id="login">
    <span id="titu">
        Login
    </span>
    <br>
    <div style="color: #003386; text-align: center;margin-left: 29px;">        
            <table style="margin-bottom: 15px;width: 100%;">
                <tr>
                    <td class="tdFormulario">Usuario:</td>
                    <td class="tdFormulario">
                        <input type="text" name="txtUsuario" id="txtUsuario" value="<?php echo set_value('txtUsuario'); ?>" />                               
                    </td>
                </tr>
                <tr>
                    <td class="tdFormulario">Contrase&ntilde;a:</td>
                    <td class="tdFormulario">
                        <input type="password" name="txtPassword" id="txtPassword" value="<?php echo set_value('txtPassword'); ?>" />
                        <input type="hidden" name="token" value="<?php echo $token ?>"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br/>
                        <input type="submit" class="button" value="Ingresar"/>
                        <input type="button" class="button" value="Cancelar"/>                            

                        <div id="divError">
                        <?php                                                 
                        echo form_error('txtPassword');                        
                        echo form_error('txtUsuario');                        
                        
                        if($this->session->flashdata('usuario_incorrecto'))
                        {
                        ?>
                            <?php echo $this->session->flashdata('usuario_incorrecto')?>
                        <?php
                        }
                        ?>
                        </div>
                    </td>
                </tr>
            </table>
    </div>        
</div>
<?php FinalDocumento() ?>