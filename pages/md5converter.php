
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

<form id="form_box" class="form-horizontal" method="post" action="md5converter.php" enctype='multipart/form-data'>
<table class="table-bordered table-striped" width="50%" align="center">
    <tr>
        <td>Enter words to be translated : </td>
        <td><input type="text" name="words" id="words" class="form-control" ></td>
    </tr>
</table>

<br><br>

<div>
    <button id="submit" name="submit" style="display: block; margin: 0 auto;" class="btn btn-primary">Translate</button>
</div>

</form>

<?php
if(isset($_POST)){
    $md5ed = md5($_POST['words']);
    echo "<h1>$md5ed</h1>";
}


?>
                    