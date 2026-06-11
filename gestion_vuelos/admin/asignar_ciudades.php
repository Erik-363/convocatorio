<?php include("../modelos/conexion.php"); ?>

<form action="../controladores/guardar_asignacion.php" method="POST">

<select name="aerolinea" id="aerolinea">
<?php
$r = mysqli_query($conexion,"SELECT * FROM aerolineas");
while($row = mysqli_fetch_assoc($r)){
echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
}
?>
</select>

<div id="ciudades"></div>

<button type="submit">Guardar</button>

</form>

<script>
document.getElementById("aerolinea").addEventListener("change", function(){
let id = this.value;

fetch("../controladores/obtener_ciudades_check.php?aerolinea_id="+id)
.then(r=>r.text())
.then(data=>{
document.getElementById("ciudades").innerHTML=data;
});
});
</script>