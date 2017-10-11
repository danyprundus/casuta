<?php
require "inc/header.php";
require "classes/finance.php";
require "classes/builder.php";

?>

    <body>
<?php
$finance= new \finance\finance();
$builder= new \builder\builder();
$dateComponents = @getdate();

if($_POST['month']){

    $month=$_POST['month'];
}
else{
    $month = $dateComponents['mon'];

}
$admimn=$_GET['admin'];
$year = $dateComponents['year'];
$admin=$_GET['admin'];
?>
    <div id="wrapper">

        <!-- Navigation -->
        <?php
        require "inc/navbar.php";
        ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header btn-danger">Adaugare Petrecere</h1>
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
                        <div class="col-lg-12">
                            <form role="form" id="financiarForm">
                                <input type="text" name="date" value="<?=date("d-m-Y",time())?>" class="datepicker date operatiune">

                            </form>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <?

                        echo build_calendar($month,$year,$dateArray,$admin);
                        ?>
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
    $data=json_decode(file_get_contents(API_URL. "finance/party/".Playground."/getParties/".($month<10?"0".$month:$month)."/".$year));
    $data=json_decode(json_encode($data), True);
    $partyInfo=json_decode($data['data'], True);
    //print_r($partyInfo);
    $data=json_decode(file_get_contents(API_URL. "finance/party/".Playground."/getForm"));
    $data=json_decode(json_encode($data), True);
    $formFields=json_decode($data['data'],true);
    $today=date("j",time());
    ?>
    <form class="form-inline "  role="form"  id="saveParty"  >
        <?  foreach($formFields as $key=>$val):?>
        <div class="form-group col-lg-5" >
            <label class="control-label col-lg-4"><?=$val['optionName'];?></label>
            <div class="col-lg-6">
                <? $options=explode(',',$val['optionValue']);
                if(strlen($options[0])>0){
                    ?><select name="optionid_<?=$val['id']?>">
                    <?foreach ($options as $option):?>
                        <option value="<?=$option?>"><?=$option?></option>
                    <? endforeach;?>

                    </select> <?
                }
                else{
                    ?><input type="text" name="optionid_<?=$val['id']?>" id="optionid_<?=$val['id']?>"<?
                    switch ($val['type']){
                        case 'date' : echo ' class=" datepicker"';break;
                        case 'numeric' : echo ' class="numeric"';break;
                    }
                    ?>><?
                }
                ?>
            </div>
        </div>
    <? endforeach;?>
        <button type="submit" class="btn btn-info">Salveaza</button>

    </form>

    </div>
    <!-- /.col-lg-6 (nested) -->
    <table class="table table-bordered table-responsive table-striped" >
        <tr>
            <th>Data</th>
    <?  foreach($formFields as $key1=>$val):?>
        <th><?=$val['optionName']?></th>
    <?endforeach;?>
            <th>Estimare</th>
        </tr>
        <?php
        for($i=1;  $i<=$numberDays;$i++):
            $currentDayRel = str_pad($i, 2, "0", STR_PAD_LEFT);
            $currentMonthRel= ($month<10?"0".$month:$month);
            $date = "$year-$currentMonthRel-$currentDayRel";
            $key=$i.$currentMonthRel.$year;
            foreach($partyInfo as $partykey=>$partyval){
                //print_r( $partyval[3][1]);
                if(str_replace('-','',$partyval[3][1])==$key){
                     $cardID[$partykey]=$partykey;
                }

            }
            foreach ($cardID as $cardarray):
            ?>
            <tr>
                <td>
                    <a href='financiar.php?viewdate=1&date=<?=$date?>'><?=$i?></a>
                </td>
                <?  foreach($formFields as $formKey=>$val):?>
                   <td>
                       <?=$partyInfo[$cardarray][$val['id']][1];?>
                   </td>
                 <?
                endforeach;
                ?><td>
                <?   $data=json_decode(file_get_contents(API_URL. "finance/party/".Playground."/calculate/".$cardarray));
                    $calculate=json_decode(json_encode($data), True);
                    echo $calculate['basePrice'];
                ?>

            </td><?
                unset($cardID[$cardarray]);
                endforeach;
                ?>

            </tr>
        <? endfor;?>
    </table>
    <?

}

require "inc/footer.php";
?>