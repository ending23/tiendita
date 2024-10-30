<?php
include 'database.php';

// Eliminar producto
if (isset($_GET['eliminar_id'])) {
    $id = $_GET['eliminar_id'];
    $sql = "DELETE FROM productos WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Producto eliminado correctamente.</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

// Agregar producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen_url = $_POST['imagen_url'];

    $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen_url) VALUES ('$nombre', '$descripcion', '$precio', '$imagen_url')";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Producto agregado correctamente.</p>";
    } else {
        echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Editar producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen_url = $_POST['imagen_url'];

    $sql = "UPDATE productos SET nombre = '$nombre', descripcion = '$descripcion', precio = '$precio', imagen_url = '$imagen_url' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Producto actualizado correctamente.</p>";
    } else {
        echo "<p>Error: " . $conn->error . "<br></p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
</head>
<body>
    <h1>Productos</h1>

    <!-- Formulario para agregar producto -->
    <h2>Agregar Producto</h2>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required><br>
        <textarea name="descripcion" placeholder="Descripción" required></textarea><br>
        <input type="number" name="precio" placeholder="Precio" step="0.01" required><br>
        <input type="text" name="imagen_url" placeholder="URL de Imagen"><br>
        <button type="submit" name="add">Agregar Producto</button>
    </form>

    <!-- Listado de productos -->
    <h2>Listado de Productos</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
        <?php
        $sql = "SELECT * FROM productos";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['descripcion']; ?></td>
                <td><?php echo $row['precio']; ?></td>
                <td><img src="<?php echo $row['imagen_url']; ?>" width="50"></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>" required>
                        <input type="text" name="descripcion" value="<?php echo $row['descripcion']; ?>" required>
                        <input type="number" name="precio" value="<?php echo $row['precio']; ?>" step="0.01" required>
                        <input type="text" name="imagen_url" value="<?php echo $row['imagen_url']; ?>">
                        <button type="submit" name="update">Actualizar</button>
                    </form>
                    <a href="?eliminar_id=<?php echo $row['id']; ?>" onclick="return confirm('¿Seguro que quieres eliminar este producto?')">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>

<?php $conn->close(); ?>
