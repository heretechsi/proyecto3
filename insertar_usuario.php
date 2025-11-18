<?php
// Incluye el archivo de configuración de la base de datos
include 'config.php';

// Define los datos del usuario a insertar
$nombre = 'ferher';
$usuario = 'edison';
$contrasena = 'ferher';  // Cambia 'tu_contraseña' por la contraseña deseada
$rol_id = 1;  // Inserta rol
$email = 'heredialf@gmail.com';

// Encripta la contraseña
$password_hash = password_hash($contrasena, PASSWORD_DEFAULT);

// Prepara la consulta SQL para insertar el usuario
$query = "INSERT INTO usuarios (nombre, usuario, password, rol_id, email) 
          VALUES ('$nombre', '$usuario', '$password_hash', $rol_id, '$email')";

// Ejecuta la consulta
if ($conn->query($query) === TRUE) {
    echo "Usuario insertado correctamente.";
} else {
    echo "Error al insertar usuario: " . $conn->error;
}

// Cierra la conexión a la base de datos
$conn->close();
?>
