<?php
require "inc/header.php";
require "classes/finance.php";
require "classes/builder.php";
$command = $_GET['command'];

$finance = new \finance\finance();
$builder = new \builder\builder();
$productTypes = \builder\builder::jsonRequest(API_URL . "finance/inventory/getProductTypes/" . Playground );
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
                    Receptii Marfa
                </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <td class="row">
        <td class="col-lg-12">
            <div class="alert alert-success alert-dismissable hide">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <div id="alert-dimissable-text"></div>
            </div>
        <td class="panel panel-default">

            <!-- /.panel-heading -->
        <td class="panel-body product-data">
        <td class="table-responsive col-lg-8">
            <form method="post" action="#" id="header">
            <table class="table table-striped table-bordered table-hover">
                <tr>
                    <td>
                        Compania <input type="text" name="company" id="company">
                    </td>
                    <td>
                        ff <input type="text" name="ff" id="ff">
                    </td>
                    <td>
                        Data Factura <input type="text" name="invoiceDate"   id="invoiceDate" value="<?=date("d-m-Y",time())?>" class="datepicker">
                    </td>
                    <td>
                        Valoare Factura <input type="text" name="invoiceValue" id="invoiceValue">
                    </td>
                </tr>

            </table>
            </form>
            <div id="extraData"></div>
            <form action="#" id="invoiceBody">

            <table class="table table-bordered table-hover table-responsive">
                <tr>

                    <th>BarCode</th>
                    <th>Nume</th>
                    <th>Tip </th>
                    <th>Cantitate </th>
                    <th>Pret per bucata</th>
                    <th>Total</th>
                </tr>

                <?
                    ?>
                    <tr class="noprint" id="productRow">

                        <td><input type="text" name="barcode"  id="barcode" > </td>
                        <td>
                            <input type="text" id="productName" name="productName">
                        </td>
                        <td >
                            <select name="productType" id="productType">
                                <?
                                foreach ($productTypes as $type){
                                    ?><option value="<?php echo $type->id ?>"><?php echo $type->typeName ?></option><?
                                }
                                ?>
                            </select>
                        </td>
                        <td >
                            <input type="text" id="productQTY" name="qty">
                        </td>
                        <td><strong id="price"></strong> lei</td>
                        <td  class="total"></td>
                    </tr>

            </table>
            </form>

    </div>


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
if($_GET['docNo']){
    ?>
    <script>
        $("#ff").val('<?=$_GET['docNo']?>').focus().trigger('change');
        $("#company").focus();
    </script>
    <?
}

?>

