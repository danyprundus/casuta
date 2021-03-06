<?php
/**
 * Created by PhpStorm.
 * User: danielphp
 * Date: 12/08/16
 * Time: 14:09
 */

namespace finance;


class finance
{
    //read api
    private $_json = null;

    public function financeMonetarOptions()
    {
        return $this->getParam(__FUNCTION__);
    }

    public function getParam($slug)
    {
        $this->GetParams();

        $params = $this->getJson();


        $return = array();
        foreach ($params->$slug as $key => $val) {
            $return[$key] = $val;

        }

        return $return;

    }

    /**
     * @return mixed
     */
    public function getJson()
    {
        return json_decode($this->_json);
    }

    public function setJson($json)
    {
        $this->_json = $json;
    }

    public function GetParams()
    {
        if(empty($_SESSION['params']))
        {
            //$_SESSION['params']=file_get_contents("http://daniel.dev/slim/src/public/finance/params");
            $_SESSION['params']=file_get_contents("http://casutajucariilor.com/unelte/front/slim/src/public/finance/params");
        }
        $this->setJson( $_SESSION['params']);

    }

    public function financeOptions()
    {

        return $this->getParam(__FUNCTION__);

    }

    public function financeBonOptions()
    {

        return $this->getParam(__FUNCTION__);

    }

    public function financeFacturaOptions()
    {

        return $this->getParam(__FUNCTION__);
    }

    public function financeZetOptions()
    {

        return $this->getParam(__FUNCTION__);

    }

    public function financeRetragereOptions()
    {

        return $this->getParam(__FUNCTION__);

    }

    public function financeFaraDocumentOptions()
    {

        return $this->getParam(__FUNCTION__);

    }

    public function financeCommentOptions()
    {

        return $this->getParam(__FUNCTION__);

    }

    public function financeDepunereBancaOptions()
    {

        return $this->getParam(__FUNCTION__);

    }

    public function financeClientiOptions()
    {

        return $this->getParam(__FUNCTION__);

    }

    public function financeBaniPropriiOptions()
    {

        return $this->getParam(__FUNCTION__);

    }
   public function financeRetragereBaniPropriiOptions()
    {
       return $this->getParam(__FUNCTION__);

    }

    public function financeProductsOptions()
    {
        return $this->getParam(__FUNCTION__);
    }

    public function financeProductAddOptions()
    {
        return $this->getParam(__FUNCTION__);
    }
    public  function financeShowDetails($details,$opType){
        $data=json_decode($details);

       // print_r($this->financeMonetarOptions());
        switch ($opType){
            case 'zet':  break;
            case 'dimineata':
            case 'seara':
                echo "<span class=\"label label-info\">Monetar</span><br>";
                ?>
                <table class="table table-striped">
                   <? foreach ($data as $detail_key=>$detail_val):?>
                       <tr>
                       <td><?=$detail_key?></td>
                       <td><?=$detail_val?></td>
                       </tr>
                   <? endforeach;?>
                </table>
                <?
                 break;

        }

    }

}