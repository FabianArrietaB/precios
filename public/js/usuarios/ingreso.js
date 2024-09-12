function ingresar(){
    $.ajax({
        url:"controller/usuarios/login.php",
        type:"POST",
        data:$('#frmIngreso').serialize(),
        success:function(respuesta){
            respuesta = respuesta.trim();
            console.log(respuesta)
            if(respuesta == 1){
                window.location.href = "view/inicio.php";
            }else{
                swal.fire({
                    icon: 'error',
                    title: 'Su usuario esta Inactivo',
                    text: 'Contacte Administrador!',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        }
    });
    return false;
}