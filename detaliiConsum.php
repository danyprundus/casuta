<?php
require "inc/header.php";
require "classes/finance.php";
require "classes/builder.php";

?>

<body>
<?php
$finance= new \finance\finance();
$builder= new \builder\builder();

?>
<div id="wrapper">

    <!-- Navigation -->
    <?php
    require "inc/navbar.php";
    ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header btn-danger">Detalii pentru -<?=$_GET['id']?></h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">

                <div class="alert alert-success alert-dismissable hide">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <div id="alert-dimissable-text"> </div>
                </div>

                <div class="row">

                    <!-- /.col-lg-6 (nested) -->
<?
if($_GET['pID']){
    file_get_contents(API_URL . "finance/client/" . Playground . "/" . $_GET['id']. "/".$_GET['pID']."/remove");
}
$data = json_decode(file_get_contents(API_URL . "finance/client/" . Playground . "/" . $_GET['id']. "/consum"));
$data=json_decode($data->data);

?>
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Denumire</th>
                            <th>Cod Bare</th>
                            <th>Sterge</th>
                        </tr>
                        <?
                        foreach ($data as $result) {

                            ?>
                            <tr>
                                <td><?=$result->name?></td>
                                <td><?=$result->barcodeID?></td>
                                <td><a href="detaliiConsum.php?id=<?=$_GET['id']?>&pID=<?=$result->barcodeID?>">Sterge</a> </td>
                            </tr>


                            <?
                        }
                        ?>

                        <?


?></table>
                    <!-- /.col-lg-6 (nested) -->
                </div>
                <!-- /.row (nested) -->


            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>

<!-- /#wrapper -->
<?php


require "inc/footer.php";
?>