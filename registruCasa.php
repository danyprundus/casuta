<?php
require "inc/header.php";
require "classes/finance.php";
require "classes/builder.php";

?>

<body>
<?php
$finance= new \finance\finance();
$builder= new \builder\builder();

$admimn=$_GET['admin'];
$year = $dateComponents['year'];
$admin=$_GET['admin'];
//rest din decembrie 88,15
//$offset=3357.3+2328.45+88.15;
//$offset=5700+88.15;
$offset=164.10;
?>
<div id="wrapper">

    <!-- Navigation -->
    <?php
    require "inc/navbar.php";
    ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header btn-danger">Registru Casa-<?=$_GET['date']?></h1>
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
                    <form method="get"> <input type="text" name="date" class="datepicker noprint"> <input type="submit"  class="btn btn-info"> </form>

                    <!-- /.col-lg-6 (nested) -->
<?

//echo build_calendar($month,$year,$dateArray,$admin);

if($_GET['date']){
$data = json_decode(file_get_contents(API_URL . "finance/monetar/registruCasa/" . Playground . "/" . $_GET['date']));
$data=json_decode($data->data);
$totalZ= $data[0]->TotalZ;
$totalZPreviousDay= $data[0]->TotalZPreviousDay+$offset;
$totalCheltuieli= $data[0]->TotalCheltuieli;
$totalCheltuieliPreviousDay= $data[0]->TotalCheltuieliPreviousDay;
$previousDay= $totalZPreviousDay-$totalCheltuieliPreviousDay;
$totalZForDay=0;
$totalCheltuieliForDay=0;

?><a href="registruCasa.php?date=<?=$date = date('d-m-Y', strtotime("-1 day", strtotime($_GET['date'])));?>" class="noprint">Back</a>
                    <a href="registruCasa.php?date=<?=$date = date('d-m-Y', strtotime("+1 day", strtotime($_GET['date'])));?>" class="noprint">Next</a>

                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Denumire</th>
                            <th>Plati</th>
                            <th>Incasari</th>
                        </tr>
                        <tr>
                            <td>Rest ziua Precedenta</td>
                            <td></td>
                            <th><? echo sprintf("%.2f",$previousDay) ;  $totalZForDay+=$previousDay;?></th>
                        </tr>

                        <?
                        foreach ($data as $result) {
                            $op=$result->operatiune;
                            $tmp=json_decode($result->data);

                            if($op=='factura' || $op=='bon' || $op=='baniproprii'|| $op=='retragerebaniproprii'|| $op=='depunere')
                            {
                                if($op=='retragerebaniproprii'){
                                    $description="Ridicare  Bani Proprii";
                                    $totalCheltuieliForDay+=$result->Valoare;

                                }elseif($op=='baniproprii'){

                                    $description="Depunere Bani Proprii";
                                    $totalZForDay+=$result->Valoare;

                                }elseif($op=='depunere'){
                                    $description="Depunere Banca";
                                    $totalCheltuieliForDay+=$result->Valoare;

                                }
                                else{
                                    $description=$tmp->firma.'-'.$tmp->descriereServicii.'-'.$tmp->bon;
                                    $totalCheltuieliForDay+=$result->Valoare;
                                }



                            }
                            else
                            {
                                $description="<b>Incasari conform Z</b>";
                                $totalZForDay+=$result->Valoare;

                            }
                            ?>
                            <tr>
                                <td><?=$description?></td>
                                <td><? if($op!='zet' && $op<>'baniproprii') echo sprintf("%.2f",$result->Valoare) ?></td>
                                <td><? if($op=='zet'|| $op=='baniproprii'
                                    ) echo sprintf("%.2f",$result->Valoare)  ?></td>
                            </tr>


                            <?
                        }
                        ?>

                        <tr>
                            <td></td>
                            <td><?= sprintf("%.2f",$totalCheltuieliForDay) ?></td>
                            <td><?= sprintf("%.2f",$totalZForDay) ?></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>Rest in casa </td>
                            <th><?=sprintf("%.2f",( $totalZForDay-$totalCheltuieliForDay)) ?></th>
                        </tr>

                        <?
                        }

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
function build_calendar($month,$year,$dateArray,$admin){
    // What is the first day of the month in question?
    $firstDayOfMonth = @mktime(0,0,0,$month,1,$year);

    // How many days does this month contain?
    $numberDays = @date('t',$firstDayOfMonth);
    $data=json_decode(file_get_contents(API_URL. "finance/monetar/getMoneyForMonth/".Playground."/$year".($month<10?"0".$month:$month)."/zet"));
    $zetInfo=json_decode(json_encode($data), True);


    $data=json_decode(file_get_contents(API_URL. "finance/monetar/getMoneyForMonth/".Playground."/$year".($month<10?"0".$month:$month)."/factura"));
    $facturaInfo=json_decode(json_encode($data), True);

    $data=json_decode(file_get_contents(API_URL. "finance/monetar/getMoneyForMonth/".Playground."/$year".($month<10?"0".$month:$month)."/bon"));
    $bonInfo=json_decode(json_encode($data), True);

    $data=json_decode(file_get_contents(API_URL. "finance/monetar/getMoneyForMonth/".Playground."/$year".($month<10?"0".$month:$month)."/retragere"));
    $retragereInfo=json_decode(json_encode($data), True);

    $data=json_decode(file_get_contents(API_URL. "finance/monetar/getMoneyForMonth/".Playground."/$year".($month<10?"0".$month:$month)."/dimineata"));
    $morningInfo=json_decode(json_encode($data), True);

    $data=json_decode(file_get_contents(API_URL. "finance/monetar/getMoneyForMonth/".Playground."/$year".($month<10?"0".$month:$month)."/seara"));
    $eveningInfo=json_decode(json_encode($data), True);

    $data=json_decode(file_get_contents(API_URL. "finance/monetar/getCountForMonth/".Playground."/$year".($month<10?"0".$month:$month)));
    $moneyCountInfo=json_decode(json_encode($data), True);

    $today=date("j",time());

}

require "inc/footer.php";
?>