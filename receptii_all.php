<?php
require "inc/header.php";
require "classes/finance.php";
require "classes/builder.php";
$command = $_GET['command'];

$finance = new \finance\finance();
$builder = new \builder\builder();
$invoices = \builder\builder::jsonRequest(API_URL . "finance/inventory/getReceptiiAll/" . Playground );
?>
<div id="wrapper">

    <!-- Navigation -->
    <?php
    require "inc/navbar.php";
    ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                   Lista Receptii Marfa
                </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
            <table class="table table-bordered table-hover table-responsive">
                <tr>

                    <th>Furnizor</th>
                    <th>Nr Document</th>
                    <th>Data </th>
                    <th>Valoare </th>
                    <th> </th>
                </tr>

                <? foreach ($invoices as $invoice){
                    ?>
                    <tr class="noprint" id="productRow">

                        <td><?=$invoice->company?></td>
                        <td><?=$invoice->docNo?></td>
                        <td><?=$invoice->invoiceDate?></td>
                        <td><?=$invoice->invoiceValue?></td>
                        <td><a href="products_in.php?docNo=<?=$invoice->docNo?>">Vizualizare</a> </td>
                    </tr>
                <?}?>

            </table>


</div>
<!-- /.panel-body -->
</div>
<!-- /.panel -->
</div>
<!-- /.col-lg-6 -->


</div>
<!-- /.row -->
</div>
<!-- /#page-wrapper -->

</div>
<style>
    .no-border {
        border: 0;
        box-shadow: none; /* You may want to include this as bootstrap applies these styles too */
    }

</style>
<!-- /#wrapper -->
<?php
//test git
require "inc/footer.php";
?>

