<?php
require "inc/header.php";
require "classes/finance.php";
require "classes/builder.php";
$command = $_GET['command'];

$finance = new \finance\finance();
$builder = new \builder\builder();
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
            <table class="table table-striped table-bordered table-hover">
              <tr>
                  <td>
                     Compania <input type="text" name="company">
                  </td>
                  <td>
                     ff <input type="text" name="ff">
                  </td>
                  <td>
                     Data Factura <input type="text" name="invoiceDate">
                  </td>
              </tr>

            </table>
            <div id="extraData"></div>

            <div class="noprint"> Cautare <input id="inventorySearchInput" value=""></div>

            <table class="table table-bordered table-hover table-responsive">
                <tr>

                    <th>Nume</th>
                    <th>Cantitate </th>
                    <th>Pret per bucata</th>
                    <th>Total</th>
                    <th></th>
                </tr>

                <?
                $data = json_decode(file_get_contents(API_URL . "finance/inventory/totalsForProducts/" . Playground ));
                $data = json_decode($data->data);
                foreach ($data as $val):
                    ?>
                    <tr class="noprint" id="productRow_<?= $val->barcodeID ?>">

                        <td><?= $val->name ?></td>
                        <td >
                            <input type="text" id="productQTY_<?= $val->barcodeID ?>" name="product[<?= $val->barcodeID ?>][]" onchange="receptiiProductQTY('<?= $val->barcodeID ?>','<?= $val->price ?>')">
                        </td>
                        <td><strong><?= $val->price ?> </strong> lei</td>
                        <td  id="productTotal_<?= $val->barcodeID ?>" class="total"></td>
                        <td  ></td>
                    </tr>


                    <?
                endforeach;
                ?>

                <td  id="productTotalPrice" colspan="4" style="text-align: right">  </td>
                <td  >  </td>

            </table>

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
<script>
    function receptiiProductQTY(barcodeID,price){
        var qty= $('#'+'productQTY_'+barcodeID).val();
         var total=price*qty;
         $("#productTotal_"+barcodeID).html(total.toFixed(2)+' lei');
         if(total>0){
             $("#productRow_"+barcodeID).removeClass('noprint');
             $("#productQTY_"+barcodeID).addClass('no-border');
         }
         else{
             $("#productRow_"+barcodeID).addClass('noprint');
             $("#productQTY_"+barcodeID).removeClass('no-border');

         }
         total=0;
        tmpval=0;
         $( ".total" ).each(function( i ) {
             tmpval=parseFloat($(this).text());
             if(tmpval>0){
                 total += tmpval;

             }

        });
        $("#productTotalPrice").html(total.toFixed(2)+' lei');
    }
</script>
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

