<?php
class Conexion{
    public function  conectar(){
       return $conexion= new PDO('mysql:host=localhost; dbname=bd_asociacion_creo_en_ti' , 'root' , '');
    }
    
}
include("conexion_BD.php");

class EVENT_BITACORA{ 
    //===================================================================================
    //===================================================================================

    public function login(){
        
        $model = new conexion();
        $conexion = $model->conectar();
        $sql = "SELECT * FROM tbl_ms_usuario where Usuario=:usuario AND Contraseña=:contra AND Estado_Usuario ='ACTIVO'";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':usuario',$this->usuario,PDO::PARAM_STR);
        $consulta->bindParam(':contra',$this->contra,PDO::PARAM_STR);
        $consulta->execute();
        $total = $consulta->rowCount();
        if($total ==0){
            ?>

            <?php
        }else{
            $fecha = date("Y-m-d h:i:s");
            $hora = date("H:i:s");
            
            $fila = $consulta->fetch();

            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha,ID_Usuario,ID_Objeto,Accion,Descripcion) VALUES(NULL,'$fecha', '".$fila['ID_Usuario']."',16,'Inicio de sesion','Entro al sistema')";
            #$sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha,ID_Usuario,ID_Objeto,Accion,Descripcion) VALUES(NULL,'$fecha', '".$fila['ID_Usuario']."','".$fila['ID_Objeto']."','Inicio de secion','Entro al sistema')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();

            session_start();
            $_SESSION['IDUsuario'] = $fila['ID_Usuario'];
            ?>

        <?php
        }
    }
    
    //===================================================================================
    //===================================================================================
    public function entrarbitacora(){
        
        $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Entró a la pantalla Bitacora" ;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '16', 'Entrar a Bitacora', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();                 
        ?>
    <?php
    }
    public function entrarhome(){
        
        $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Entró a la pantalla Home" ;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '16', 'Entrar a Home', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();                 
        ?>
    <?php
    }
    public function Cerrarlogin(){
        
        $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Salió del sistema" ;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '16', 'Cerrar sesión', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();                 
        ?>
    <?php
    }
    
    public function entrarusuario(){
        $IDGlobal=$_SESSION['ID_User'];
            $model = new conexion();
            $conexion = $model->conectar();
            $Descripcion = "Entró a la pantalla Usuarios" ;
            $fecha = date("Y-m-d h:i:s");
            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
            VALUES (NULL,'$fecha', '$IDGlobal', '1', 'Entrar a Usuarios', '$Descripcion')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();                 
            ?>
        <?php
    }

    //===================================================================================
    //===================================================================================
    #registro usuario
    public function RegInsert(){
        session_start();
        $IDGlobal=$_SESSION['ID_User'];
        $_SESSION['IDUsuarioBitacora'];
            $model = new conexion();
            $conexion = $model->conectar();
            $Accion = "Creacion de usuario";
            $IDU =  $_SESSION['IDUsuarioBitacora'];
            $Usuario = $_SESSION['UsuarioBitacora'];
            $Descripcion = "Nuevo usuario agregado: " .$Usuario;
            $fecha = date("Y-m-d h:i:s");

            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
            VALUES (NULL,'$fecha', '$IDGlobal', '1', 'Creacion de usuario', '$Descripcion')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();
    
            
          
            ?>
    
        <?php
    
        

    }
    
    //===================================================================================
    //===================================================================================
    public function RegautoInsert(){
        session_start();
        $IDGlobal= $_SESSION['IDUsuarioBitacora'];
            $model = new conexion();
            $conexion = $model->conectar();
            $Accion = "Creacion de usuario";
            $IDU =  $_SESSION['IDUsuarioBitacora'];
            $Usuario = $_SESSION['UsuarioBitacora'];
            $Descripcion = "Se autoregistro el usuario: " .$Usuario;
            $fecha = date("Y-m-d h:i:s");
            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
            VALUES (NULL,'$fecha', '$IDGlobal', '1', 'creacion de usuario', '$Descripcion')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();
    
            
          
            ?>
    
        <?php
    
        

    }


    //===================================================================================
    //===================================================================================
    #update usuario

    public function RegUptusu(){
        session_start();

        $IDGlobal=$_SESSION['ID_User'];


            $model = new conexion();
            $conexion = $model->conectar();
            $userName = $_SESSION['UsuarioBitUP'];
            $Descripcion = "Se modifico el usuario: ".$userName;
            $fecha = date("Y-m-d h:i:s");
            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
            VALUES (NULL,'$fecha', $IDGlobal , '1', 'Modificacion de usuario', '$Descripcion')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();
    
            
          
            ?>
    
        <?php
    
        

    }


    //===================================================================================
    //===================================================================================

    public function RegDelete(){
        session_start();
        $IDGlobal=$_SESSION['ID_User'];
            $model = new conexion();
            $conexion = $model->conectar();
            $IDDEL= $_SESSION['IDUsuarioBitacoraDELETE'];
            $Nombre_Usuario = $_SESSION['UsuarioBitacoraDELETE'];
            $Descripcion = "Se elimino el usuario con ID: " .$Nombre_Usuario;
            $fecha = date("Y-m-d h:i:s");
            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
            VALUES (NULL,'$fecha', $IDGlobal, '1', 'Eliminacion de usuario', '$Descripcion')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();
          
            ?>
    
        <?php
    }

    //===================================================================================

    public function regNuevoUser(){
        $model = new conexion();
        $conexion = $model->conectar();
        $sql = "SELECT * FROM tbl_ms_usuario where Usuario=:R_usuario AND Contraseña=:R_contra AND Estado_Usuario ='ACTIVO'";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':R_usuario',$this->R_usuario,PDO::PARAM_STR);
        $consulta->bindParam(':R_contra',$this->R_contra,PDO::PARAM_STR);
        $consulta->execute();
        $total = $consulta->rowCount();
        if($total ==0){
            ?>


            <?php
        }else{
            $fecha = date("Y-m-d h:i:s");
            $hora = date("H:i:s");
            
            $fila = $consulta->fetch();

            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha,ID_Usuario,ID_Objeto,Accion,Descripcion) VALUES(NULL,'$fecha', '".$fila['ID_Usuario']."','".$fila['16']."','Creacion de Usuario Nuevo','El usuario fue creado')";
            #$sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha,ID_Usuario,ID_Objeto,Accion,Descripcion) VALUES(NULL,'$fecha', '".$fila['ID_Usuario']."','".$fila['ID_Objeto']."','Inicio de secion','Entro al sistema')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();

            session_start();
            $_SESSION['IDUsuario'] = $fila['ID_Usuario'];
            ?>

        <?php
        }


    }
    //===================================================================================
    //===================================================================================


#entrar fondos
public function EntrarFondo(){
    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Entró a la pantalla de fondo" ;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '7', 'Entrar a fondo', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
}
##Insert fondos
public function RegaInsertFondo(){
    session_start();

    $IDGlobal=$_SESSION['ID_User'];

    $Nombre_del_Objeto=$_SESSION['nFondoBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Accion = "Creacion de usuario";
        $Descripcion = "Se Ingreso el fondo: " .$Nombre_del_Objeto;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '7', 'Ingreso de fondo', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();

        
      
        ?>

    <?php

    

}

    //===================================================================================
    //===================================================================================
#Delete Fondos
public function DeleteFondo(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
   $Fondo=$_SESSION['IDFondoBitacoraDELETE'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se elimino el fondo: " .$Fondo;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', $IDGlobal, '7', 'Eliminacion de fondo', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
    

        
      
        ?>

    <?php

    

}

    //===================================================================================
    //===================================================================================
# Registro de Fondos
public function RegUptFondo(){
    session_start();
    $Nombre_del_Objeto= $_SESSION['IDFondoBitacoraUP'];
    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $_SESSION['IDUsuario'] = $fila['ID_Usuario'];
        $id =  $_SESSION['IDUsuarioBitacoraUP'];
        $user = $_SESSION['UsuarioBitacoraUP'];
        $Descripcion = "Se modifico el fondo: " .$Nombre_del_Objeto;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal ', '7', 'Modificacion de fondo', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();

        
      
        ?>

    <?php

    

}

     //===================================================================================
    //===================================================================================
      #entrar voluntario
      public function entrarvol(){

        $IDGlobal=$_SESSION['ID_User'];

            $model = new conexion();
            $conexion = $model->conectar();
            $Descripcion = "Entró a la pantalla Voluntarios";
            $fecha = date("Y-m-d h:i:s");
            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
            VALUES (NULL,'$fecha', '$IDGlobal', '9', 'Entrar a voluntario', '$Descripcion')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();         
            ?> 
        <?php
    }
    #registro voluntario
    public function RegInsertvol(){
        session_start();
        $IDGlobal=$_SESSION['ID_User'];
     $voluntario=$_SESSION['nombreVolBitacora'];
            $model = new conexion();
            $conexion = $model->conectar();
            $Accion = "Creacion de Voluntario";
            $Descripcion = "Nuevo Voluntario agregado: ".$voluntario;
            $fecha = date("Y-m-d h:i:s");
            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
            VALUES (NULL,'$fecha', '$IDGlobal', '9', 'Creacion de voluntario', '$Descripcion')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();
    
            
          
            ?>
    
        <?php
    
        

    }
 //===================================================================================
    //===================================================================================
    #delete voluntario
    public function DeleteVol(){
        session_start();
        $IDGlobal=$_SESSION['ID_User'];
       $idvol=$_SESSION['idVolBitacoraDELETE'];
       $voldelete= $_SESSION['NombreVolBitacoraDELETE'];
            $model = new conexion();
            $conexion = $model->conectar();
            $Descripcion = "Se elimino el Voluntario: ".$idvol;
            $fecha = date("Y-m-d h:i:s");
            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
            VALUES (NULL,'$fecha', $IDGlobal, '9', 'Eliminacion de voluntario', '$Descripcion')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();
        
            ?>
    
        <?php
    
        
    
    }
    #update voluntario
    public function RegUptVol(){
        session_start();

        $IDGlobal=$_SESSION['ID_User'];
       $Voluntarioup= $_SESSION['VOLBitacoraUP'];
            $model = new conexion();
            $conexion = $model->conectar();
            $Descripcion = "Se modifico el voluntario: " .$Voluntarioup;
            $fecha = date("Y-m-d h:i:s");
            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
            VALUES (NULL,'$fecha', '$IDGlobal ', '9', 'Modificacion de voluntario', '$Descripcion')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();
    
            
          
            ?>
    
        <?php
    
        
    
    }
     //===================================================================================
    //===================================================================================
    #entrar pago
    public function entrarPago(){
        $IDGlobal=$_SESSION['ID_User'];
            $model = new conexion();
            $conexion = $model->conectar();
            $Descripcion = "Entró a la pantalla pago ";
            $fecha = date("Y-m-d h:i:s");
            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
            VALUES (NULL,'$fecha', '$IDGlobal', '10', 'Entrar a Pago', '$Descripcion')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();     
            ?>
        <?php
    }
#registro pago
    public function RegInsertPago(){
        session_start();
        $IDGlobal=$_SESSION['ID_User'];
       $idpago= $_SESSION['IDpagoBitacora'];
            $model = new conexion();
            $conexion = $model->conectar();
            $Accion = "Creacion de Pago";
            $Descripcion = "Nuevo Pago agregado: ".$idpago;
            $fecha = date("Y-m-d h:i:s");
            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
            VALUES (NULL,'$fecha', '$IDGlobal', '10', 'Creacion de Pago', '$Descripcion')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();
    
            
          
            ?>
    
        <?php
    
        

    }

     //===================================================================================
    //===================================================================================
    

     //===================================================================================
    //===================================================================================
    #update pago
    public function RegUptpag(){
        session_start();
        $IDGlobal=$_SESSION['ID_User'];
        $ID_Pago=$_SESSION['idpagoBitacoraUP'];
        $Monto= $_SESSION['pagoBitacoraUP'];
            $model = new conexion();
            $conexion = $model->conectar();       
            $Descripcion = "Se modifico el pago a: " . $Monto ." con ID: ".$ID_Pago;
            $fecha = date("Y-m-d h:i:s");
            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
            VALUES (NULL,'$fecha', '$IDGlobal ', '10', 'Modificacion de pago', '$Descripcion')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();
    
            
          
            ?>
    
        <?php
    
        
    
    }
        //===================================================================================
#delete pago
    public function DeletePagos(){
        session_start();

        $IDGlobal=$_SESSION['ID_User'];
        $idpago= $_SESSION['idPagoBitdel'];
            $model = new conexion();
            $conexion = $model->conectar();
            $Descripcion = "Se elimino el Pago con ID: ".$idpago;
            $fecha = date("Y-m-d h:i:s");
            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
            VALUES (NULL,'$fecha', $IDGlobal, '10', 'Eliminacion de Pago', '$Descripcion')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();
            ?>
    
        <?php
    }

      //===================================================================================
    //===================================================================================
    #registro donante
public function entrarDon(){
    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Entró a la pantalla donantes";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '8', 'Entrar a Donantes', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();   
        ?>
    <?php
  }
#registro donante
public function RegInsertDon(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
  $donante= $_SESSION['DonanteBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Nuevo Donante agregado: ".$donante;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '8', 'Creacion de Donante', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();

        
      
        ?>

    <?php
  }
     //===================================================================================
#delete donante
public function DeleteDon(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
  $iddonante=  $_SESSION['IDdonanteBitacoraDELETE'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se elimino el Donante con ID: ".$iddonante;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', $IDGlobal, '8', 'Eliminacion de Donante', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
    

        
      
        ?>

    <?php
}
       //===================================================================================
    //===================================================================================
    #update donante
    public function RegUptdon(){
        session_start();

        $IDGlobal=$_SESSION['ID_User'];
        $Nombredonante=$_SESSION['donanteBitacoraUP'];
            $model = new conexion();
            $conexion = $model->conectar();      
            $Descripcion = "Se modifico el donante: " .$Nombredonante;
            $fecha = date("Y-m-d h:i:s");
            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
            VALUES (NULL,'$fecha', '$IDGlobal ', '8', 'Modificacion de donante', '$Descripcion')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();
    
            
          
            ?>
    
        <?php
    
        
    
    }

  //===================================================================================
  #entrar SAR   
public function entrarSar(){

    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Entró a la pantalla SAR";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '11', 'Entrar a SAR', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();   
        ?>
    <?php
  }
#registro SAR   
public function RegInsertSar(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    
    $RTN= $_SESSION['RTNSarBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Registro SAR agregado con RTN: ".$RTN;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '11', 'Creacion de registro SAR', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();   
        ?>
    <?php
  }

   //===================================================================================
    #update SAR 
    public function RegUptSar(){
        session_start();
        $IDGlobal=$_SESSION['ID_User'];
        $RTN=$_SESSION['$RTNsarBitUP'];
            $model = new conexion();
            $conexion = $model->conectar();      
            $Descripcion = "Se modifico el registro SAR con RTN: ".$RTN;
            $fecha = date("Y-m-d h:i:s");
            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
            VALUES (NULL,'$fecha', '$IDGlobal ', '11', 'Modificacion de SAR', '$Descripcion')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();
            ?>
        <?php    
    }
      //===================================================================================
#delete SAR 
public function DeleteSar(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $id_sar=$_SESSION['IDSarBitacoraDELETE'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se elimino el registro SAR con ID: ".$id_sar;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', $IDGlobal, '11', 'Eliminacion de SAR', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
      
        ?>

    <?php
}
  //===================================================================================
  #Entrar Rol
public function entrarRol(){
    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Entró a la pantalla roles";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '5', 'Entrar a Roles', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
#registro Rol
public function RegInsertRol(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $nombreRol= $_SESSION['RolBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Registro Rol agregado: ".$nombreRol;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '5', 'Creacion de Rol', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
   //===================================================================================
    #update Rol
    public function RegUptRol(){
        session_start();
        $IDGlobal=$_SESSION['ID_User'];
        $nombreRol=$_SESSION['RolBitUP'];
            $model = new conexion();
            $conexion = $model->conectar();      
            $Descripcion = "Se modifico el Rol: " .$nombreRol;
            $fecha = date("Y-m-d h:i:s");
            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
            VALUES (NULL,'$fecha', '$IDGlobal ', '5', 'Modificacion de Rol', '$Descripcion')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();  
            ?>
        <?php  
    }
   //===================================================================================
#delete Rol
public function DeleteRol(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $ID_Rol=$_SESSION['IDRolDELETE'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se elimino el Rol: ".$ID_Rol;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', $IDGlobal, '5', 'Eliminacion de Rol', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();   
        ?>
    <?php
}
 //===================================================================================
 #entrar preguntas
public function entrarpreg(){
    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Entró a la pantalla Preguntas ";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '4', 'Entrar a preguntas', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
#registro preguntas
public function RegInsertpreg(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $pregunta= $_SESSION['pregbit'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Pregunta agregada: ".$pregunta;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '4', 'Creacion de pregunta', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
   //===================================================================================
    #update pregunta
    public function RegUptpreg(){
        session_start();
        $IDGlobal=$_SESSION['ID_User'];
        $pregunta=$_SESSION['pregbitUP'];
            $model = new conexion();
            $conexion = $model->conectar();      
            $Descripcion = "Se modifico La pregunta: " .$pregunta;
            $fecha = date("Y-m-d h:i:s");
            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
            VALUES (NULL,'$fecha', '$IDGlobal ', '4', 'Modificacion de pregunta', '$Descripcion')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();  
            ?>
        <?php  
    }
          //===================================================================================
#delete preguntas
public function Deletepreg(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $ID_Pregunta=$_SESSION['IDpregDELETE'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se elimino la pregunta: ".$ID_Pregunta;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', $IDGlobal, '4', 'Eliminacion de pregunta', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
      
        ?>

    <?php
}
#entrar parametro
public function entrarpara(){
    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Entró a la pantalla Parametros";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '3', 'Entrar aparametros', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
#registro parametro
public function RegInsertpara(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $Nombre_Parametro= $_SESSION['parabit'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Agrego el parametro: ".$Nombre_Parametro;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '3', 'Creacion de parametro', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
   //=======
   //===================================================================================
    #update parametro
    public function RegUptpara(){
        session_start();
        $IDGlobal=$_SESSION['ID_User'];
        $Parametro=$_SESSION['paraBitUP'];
            $model = new conexion();
            $conexion = $model->conectar();      
            $Descripcion = "Se modifico el parametro: " .$Parametro;
            $fecha = date("Y-m-d h:i:s");
            $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
            VALUES (NULL,'$fecha', '$IDGlobal ', '3', 'Modificacion de parametro', '$Descripcion')";
            $consulta2= $conexion->prepare($sql2);
            $consulta2->execute();  
            ?>
        <?php  
    }

        #entrar Tipo de Fondo
public function entrarTFondo(){
    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Entró a la pantalla Tipo Fondo";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '13', 'Entrar a Tipo Fondo', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
    #registro Tipo de Fondo
public function RegInsertTFondo(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];

    $nombre_T_Fondo= $_SESSION['nombreTFondoBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Agrego el Tipo de Fondo: ".$nombre_T_Fondo;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '13', 'Creacion de Tipo Fondo', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

     #UPDATE Tipo de Fondo
public function UPInsertTFondo(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];

    $nombre_T_Fondo= $_SESSION['nombreTFondoBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se modifico el Tipo de Fondo: ".$nombre_T_Fondo;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '13', 'Modificacion de Tipo Fondo', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

      #Delete Tipo de Fondo
public function DELInsertTFondo(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $ID_T_Fondo= $_SESSION['IDTFondoBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se elimino el Tipo de Fondo con ID: ".$ID_T_Fondo;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '13', 'Eliminacion de Tipo Fondo', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
 #entrar Area de trabajo
 public function entrarAreaT(){
    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Entró a la pantalla Area de Trabajo";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '14', 'Entrar a area de trabajo', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
  #Insert Area de trabajo
public function InsertAreaT(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $nombre_Area_Trabajo= $_SESSION['nareaBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Ingreso el area de trabajo: ".$nombre_Area_Trabajo;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '14', 'Agregar area de trabajo', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

   #UPDATE Area de trabajo
public function UPAreaT(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $nombre_Area_Trabajo= $_SESSION['nareaBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Modifico el area de trabajo: ".$nombre_Area_Trabajo;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '14', 'Modificacion area de trabajo', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

    #DELETE Area de trabajo
public function DELAreaT(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $ID_Area_Trabajo= $_SESSION['IDareaBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se elimino el area de trabajo con ID: ".$ID_Area_Trabajo;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '14', 'Eliminacion area de trabajo', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

    #entrar Voluntario Projecto
public function entrarVOLPRO(){
    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Entró a la pantalla vinculacion de voluntarios";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '15', 'Entrar a Vinculacion de voluntario', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
     #Insert Voluntario Projecto
public function InsertVOLPRO(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $ID_Voluntario= $_SESSION['IDvolproBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se Vinculo el voluntario con ID: ".$ID_Voluntario;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '15', 'Vinculacion de voluntario', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

      #UPDATE Voluntario Projecto
public function UPVOLPRO(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $ID_Vinculacion_Proy= $_SESSION['IDvolproBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se modifico el voluntario vinculado con ID: ".$ID_Vinculacion_Proy;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '15', ' Modidicacion voluntario vinculado', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

  #DELETE Voluntario Projecto
public function DELVOLPRO(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $ID_Vinculacion_Proy= $_SESSION['IDvolproBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se elimino el voluntario vinculado con ID: ".$ID_Vinculacion_Proy;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '15', 'Eliminacion voluntario vinculado', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

    #Entrar gestor Projecto
public function entrarGProj(){
    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Entró a la pantalla Gestion de Proyectos";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '6', 'Entrar a Gestion de Proyecto', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
    #Entrar Projecto
public function entrarProj(){
    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Entró a la pantalla Proyectos";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '6', 'Entrar a proyecto', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
  #Insert Projecto
public function InsertProj(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $nomb_proyec= $_SESSION['projectBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se creo el proyecto: ".$nomb_proyec;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '6', 'Creacion de proyecto', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

   #Insert Projecto
public function UPTProjec(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $nomb_proyec= $_SESSION['projectBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se modificó el proyecto: ".$nomb_proyec;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '6', 'Modificacion de proyecto', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

     #Insert Projecto
public function DELProj(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $ID_proyecto= $_SESSION['IDprojectBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se eliminó el proyecto con ID: ".$ID_proyecto;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '6', 'Eliminacion de proyecto', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

    #entrarTipo Pago
public function entrarTPago(){
    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Entró a la pantalla Tipo de Pago";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '17', 'Entrar a Tipo Pago', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
      #Insert Tipo Pago
public function InsertTPago(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $Nombre= $_SESSION['nombtpagoBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se agrego el tipo pago: ".$Nombre;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '17', 'Ingreso Tipo Pago', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

      #UPT Tipo Pago
public function UPTTPago(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $Nombre= $_SESSION['nombtpagoBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se modificó el tipo pago: ".$Nombre;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '17', 'Modificacion Tipo Pago', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

     #Delete Tipo Pago
public function DELTPago(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $ID_T_pago= $_SESSION['IDtpagoBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se eliminó el tipo pago con ID: ".$ID_T_pago;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '17', 'Eliminacion Tipo Pago', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

         #entrar OBJETO
public function entrarObj(){
    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Entró a la pantalla Objetos";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '18', 'Entrar a Objetos', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
       #Insert OBJETO
public function InsertObj(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $objeto= $_SESSION['OBJBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se agrego el objeto: ".$objeto;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '18', 'Ingreso de objeto', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

    #UP Objeto
public function UPObj(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $objeto= $_SESSION['OBJBitacora'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se modificó el objeto: ".$objeto;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '18', 'Modificacion de objeto', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

  #DELETE Objeto
public function DELObj(){
    session_start();
    $IDGlobal=$_SESSION['ID_User'];
    $idObj= $_SESSION['IDobjDELETE'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se eliminó el objeto con ID: ".$idObj;
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '18', 'Eliminacion de objeto', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

   #Reporte pago
public function reportpago(){

    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se genero reporte de pago ";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '10', 'Reporte Pago', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
     #Reporte usuario
public function reportusu(){

    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se genero reporte de usuario ";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '1', 'Reporte usuario', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

   #Reporte DONANTE
public function reportdonan(){

    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se genero reporte de donantes ";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '8', 'Reporte donantes', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

    #Reporte DONANTE
public function reportfondo(){

    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se genero reporte de fondos ";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '7', 'Reporte fondos', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

    #Reporte Objeto
public function reportobj(){

    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se genero reporte de objetos ";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '18', 'Reporte objetos', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

  #Reporte parametro
public function reportparametro(){

    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se genero reporte de parametros ";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '3', 'Reporte parametros', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

   #Reporte preguntas
public function reportpregunt(){

    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se genero reporte de preguntas ";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '4', 'Reporte preguntas', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

   #Reporte projecto
public function reportproj(){

    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se genero reporte de proyecto ";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '6', 'Reporte proyecto', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

     #Reporte rol
public function reportrol(){

    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se genero reporte de roles ";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '5', 'Reporte roles', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
#Reporte sar
public function reportsar(){

    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se genero reporte de SAR ";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '11', 'Reporte SAR', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
#Reporte tipo fondo
public function reportTfondo(){

    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se genero reporte de tipo de fondo ";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '13', 'Reporte tipo fondo', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

  #Reporte tipo pago
public function reportTpago(){

    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se genero reporte de tipo de pago ";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '17', 'Reporte tipo pago', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
    #Reporte voluntario proyecto
public function reportvolpro(){

    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se genero reporte de vountario proyecto ";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '15', 'Reporte voluntario proyecto', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

    #Reporte voluntarios
public function reportvol(){

    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se genero reporte de vountarios ";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '9', 'Reporte voluntarios', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

   #Reporte bitacora
public function reportbit(){

    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se genero reporte de bitacora";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '2', 'Reporte bitacora', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
#Reporte area trabajo
public function reportareaT(){

    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Se genero reporte de area de trabajo";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '14', 'Reporte area de trabajo', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
  #entrar backup 
public function entrarbackup(){
    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Entró a la pantalla Backup";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '12', 'Entrar a Backup', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
  #backup 
public function backupcrea(){
    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Creo copia de seguridad";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '12', 'Creacion copia de seguridad', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }

    #backup actualizar
public function backupres(){

    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Actualizo copia de seguridad";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '12', 'Actualizar copia de seguridad', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }
  #backup delete
public function backuDEL(){

    $IDGlobal=$_SESSION['ID_User'];
        $model = new conexion();
        $conexion = $model->conectar();
        $Descripcion = "Eliminó copia de seguridad";
        $fecha = date("Y-m-d h:i:s");
        $sql2 = "INSERT INTO tbl_ms_bitacora(ID_Bitacora,Fecha, ID_Usuario, ID_Objeto, Accion, Descripcion) 
        VALUES (NULL,'$fecha', '$IDGlobal', '12', 'Eliminacion copia de seguridad', '$Descripcion')";
        $consulta2= $conexion->prepare($sql2);
        $consulta2->execute();
        ?>
    <?php
  }


}  
?>