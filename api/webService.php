<?php
  header('Content-Type: text/html; charset=utf-8');
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');

  require_once("../Model/BD.php");
  require_once("../Model/usuarios_bd.php");

if ($_SERVER['REQUEST_METHOD'] == "GET")
{
  $action="-1";
  $limit=10;
  $start=0;
  $filter="";
  $currency="";
  $payment="";
  $extraData="";
  $subSerieId="";
    $numSerie="";
    $grade="";
    $countryId="";
    $option=0;
    $billsIds="";

    $centering="";
    $holes="";
     $paper="";
     $smell="";
      $manipulation="";
       $note="";
    // Get data

    
    if (isset($_GET['action'])) 
    {
      $action= $_GET['action'];
    }
    if (isset($_GET['limit'])) 
    {
      $limit=$_GET['limit'];
    }
     
    if (isset($_GET['start'])) 
    {
      $start=$_GET['start'];
    }
    
    if (isset($_GET['option'])) 
    {
      $option=$_GET['option'];
    }
    if (isset($_GET['imageName1'])) 
    {
      $imageName1=$_GET['imageName1'];
    }
    if (isset($_GET['imageName2'])) 
    {
      $imageName2=$_GET['imageName2'];
    }
    
    if (isset($_GET['newImageName1'])) 
    {
      $newImageName1=$_GET['newImageName1'];
    }
    
    if (isset($_GET['newImageName2'])) 
    {
      $newImageName2=$_GET['newImageName2'];
    }
    

   
    if (isset($_GET['currency'])) 
    {
      $currency=$_GET['currency'];
    }

    if (isset($_GET['payment'])) 
    {
      $payment=$_GET['payment'];
    }

    if (isset($_GET['filter'])) 
    {
      $filter=$_GET['filter'];
    }
    if (isset($_GET['name'])) 
    {
      $name=$_GET['name'];
    }
     
    if (isset($_GET['email'])) 
    {
      $email=$_GET['email'];
    }
    
    if (isset($_GET['pass'])) 
    {
      $pass=$_GET['pass'];
    }   
    
    if (isset($_GET['newPass'])) 
    {
      $newPass=$_GET['newPass'];
    }   
    
    if (isset($_GET['status'])) 
    {
      $status=$_GET['status'];
    }

    $serieId="";
    if (isset($_GET['serieId'])) 
    {
      $serieId=$_GET['serieId'];
    }

    if (isset($_GET['shippingAddress'])) 
    {
      $shippingAddress=$_GET['shippingAddress'];
    }
    
    if (isset($_GET['shippingRules'])) 
    {
      $shippingRules=$_GET['shippingRules'];
    }
    
  
    if (isset($_GET['subSerieId'])) 
    {
      $subSerieId=$_GET['subSerieId'];
    }
          if (isset($_GET['countryId'])) 
    {
      $countryId=$_GET['countryId'];
    }
    if (isset($_GET['id'])) 
          {
            $id=$_GET['id'];
          }
          $imageData1="";
          $imageData2="";
          if (isset($_GET['imageData1'])) 
          {
            $imageData1=$_GET['imageData1'];
          }      
          if (isset($_GET['imageData2'])) 
          {
            $imageData2=$_GET['imageData2'];
          }  
          if (isset($_GET['remark'])) 
          {
            $remark=$_GET['remark'];
          }  



    
         if (isset($_GET['billValue'])) 
          {
            $billValue=$_GET['billValue'];
          }
          if (isset($_GET['userId'])) 
          {
            $userId=$_GET['userId'];
          }
          if (isset($_GET['userId2'])) 
          {
            $userId2=$_GET['userId2'];
          }
          if (isset($_GET['billId'])) 
          {
            $billId=$_GET['billId'];
          }
          if (isset($_GET['billsIds'])) 
          {
            $billsIds=$_GET['billsIds'];
          }
          
          if (isset($_GET['issuer'])) 
          {
            $issuer=$_GET['issuer'];
          }
          if (isset($_GET['dateText'])) 
          {
            $dateText=$_GET['dateText'];
          }
          if (isset($_GET['printer'])) 
          {
            $printer=$_GET['printer'];
          }
     
          if (isset($_GET['year'])) 
          {
            $year=$_GET['year'];
          }
          if (isset($_GET['initYear'])) 
          {
            $initYear=$_GET['initYear'];
          }
          

          if (isset($_GET['endYear'])) 
          {
            $endYear=$_GET['endYear'];
          }  
           
          if (isset($_GET['extraData'])) 
          {
            $extraData=$_GET['extraData'];
          }
           
          if (isset($_GET['description'])) 
          {
            $description=$_GET['description'];
          }
          if (isset($_GET['canonical'])) 
          {
            $canonical=$_GET['canonical'];
          }
          if (isset($_GET['resume'])) 
          {
            $resume=$_GET['resume'];
          }

          if (isset($_GET['tags'])) 
          {
            $tags=$_GET['tags'];
          }

     

        if (isset($_GET['grade'])) 
        {
          $grade=$_GET['grade'];
        }
        if (isset($_GET['frontSerie'])) 
        {
          $frontSerie=$_GET['frontSerie'];
        }
        if (isset($_GET['backSerie'])) 
        {
          $backSerie=$_GET['backSerie'];
        }
        if (isset($_GET['numSerie'])) 
        {
          $numSerie=$_GET['numSerie'];
        }

        
        if (isset($_GET['firstSerial'])) 
        {
          $firstSerial=$_GET['firstSerial'];
        }
        if (isset($_GET['lastSerial'])) 
        {
          $lastSerial=$_GET['lastSerial'];
        }
        if (isset($_GET['purchaseDate'])) 
        {
          $purchaseDate=$_GET['purchaseDate'];
        }
       
 
        if (isset($_GET['publicNotes'])) 
        {
          $publicNotes=$_GET['publicNotes'];
        }
      
          if (isset($_GET['privateNotes'])) 
          {
            $privateNotes=$_GET['privateNotes'];
       
          }
        if (isset($_GET['sellPrice'])) 
        {
          $sellPrice=$_GET['sellPrice'];
        }
        if (isset($_GET['sellActive'])) 
        {
          $sellActive=$_GET['sellActive'];
        }
        if (isset($_GET['active'])) 
        {
          $active=$_GET['active'];
        }
        if (isset($_GET['purchasePrice'])) 
        {
          $purchasePrice=$_GET['purchasePrice'];
        }



        if (isset($_GET['restored'])) 
        {
          $restored=$_GET['restored'];
        }
        if (isset($_GET['errorNote'])) 
        {
          $errorNote=$_GET['errorNote'];
        }
        if (isset($_GET['replacement'])) 
        {
          $replacement=$_GET['replacement'];
        }
        if (isset($_GET['specimen'])) 
        {
          $specimen=$_GET['specimen'];
        }
        if (isset($_GET['proof'])) 
        {
          $proof=$_GET['proof'];
        }
        if (isset($_GET['falseBill'])) 
        {
          $falseBill=$_GET['falseBill'];
        }

          if (isset($_GET['init'])) 
          {
            $init=$_GET['init'];
          }
          
          if (isset($_GET['end'])) 
          {
            $end=$_GET['end'];
          }   

          if (isset($_GET['color1'])) 
          {
            $color1=$_GET['color1'];
          }
          
          if (isset($_GET['color2'])) 
          {
            $color2=$_GET['color2'];
          }
          if (isset($_GET['info'])) 
          {
            $info=$_GET['info'];
          }  

          if (isset($_GET['surnames'])) 
          {
            $surnames=$_GET['surnames'];
          }
          
          if (isset($_GET['bornDate'])) 
          {
            $bornDate=$_GET['bornDate'];
          }
          
          if (isset($_GET['sex'])) 
          {
            $sex=$_GET['sex'];
          }
          
          if (isset($_GET['address'])) 
          {
            $address=$_GET['address'];
          }
          
          if (isset($_GET['dni'])) 
          {
            $dni=$_GET['dni'];
          }
          
          if (isset($_GET['phone'])) 
          {
            $phone=$_GET['phone'];
          }
          
          if (isset($_GET['height'])) 
          {
            $height=$_GET['height'];
          }
          
          
          
          if (isset($_GET['patologies'])) 
          {
            $patologies=$_GET['patologies'];
          }
          
          if (isset($_GET['sport'])) 
          {
            $sport=$_GET['sport'];
          }
          if (isset($_GET['senderId'])) 
          {
            $senderId=$_GET['senderId'];
          }
          if (isset($_GET['sms'])) 
          {
            $sms=$_GET['sms'];
          }
          if (isset($_GET['target'])) 
          {
            $target=$_GET['target'];
          }
          if (isset($_GET['sender'])) 
          {
            $sender=$_GET['sender'];
          }
          if (isset($_GET['managingFor'])) 
          {
            $managingFor=$_GET['managingFor'];
          }

          if (isset($_GET['centering'])) 
          {
            $centering=$_GET['centering'];
          }
          if (isset($_GET['holes'])) 
          {
            $holes=$_GET['holes'];
          }
          if (isset($_GET['paper'])) 
          {
            $paper=$_GET['paper'];
          }
          if (isset($_GET['smell'])) 
          {
            $smell=$_GET['smell'];
          }
          if (isset($_GET['manipulation'])) 
          {
            $manipulation=$_GET['manipulation'];
          }
          if (isset($_GET['note'])) 
          {
            $note=$_GET['note'];
          }
   
        
    }else
    {
          $action="-1";
        $limit=10;
        $start=0;
        $filter="";
        $currency="";
$payment="";
        // Get data

        if (isset($_POST['option'])) 
        {
          $option=$_POST['option'];
        }

        if (isset($_POST['action'])) 
        {
          $action= $_POST['action'];
        }

      if (isset($_POST['limit'])) 
      {
        $limit=$_POST['limit'];
      }
       
      if (isset($_POST['start'])) 
      {
        $start=$_POST['start'];
      }
      
      if (isset($_POST['imageName1'])) 
      {
        $imageName1=$_POST['imageName1'];
      }
      
      if (isset($_POST['imageName2'])) 
      {
        $imageName2=$_POST['imageName2'];
      }
      
      if (isset($_POST['newImageName1'])) 
      {
        $newImageName1=$_POST['newImageName1'];
      }
      
      if (isset($_POST['newImageName2'])) 
      {
        $newImageName2=$_POST['newImageName2'];
      }
      

     
      if (isset($_POST['currency'])) 
      {
        $currency=$_POST['currency'];
      }
      
      if (isset($_POST['payment'])) 
      {
        $payment=$_POST['payment'];
      }
      if (isset($_POST['filter'])) 
      {
        $filter=$_POST['filter'];
      }
      if (isset($_POST['name'])) 
      {
        $name=$_POST['name'];
      }
       
      if (isset($_POST['email'])) 
      {
        $email=$_POST['email'];
      }
      
      if (isset($_POST['pass'])) 
      {
        $pass=$_POST['pass'];
      }   
      
      if (isset($_POST['newPass'])) 
      {
        $newPass=$_POST['newPass'];
      }   
      
      if (isset($_POST['status'])) 
      {
        $status=$_POST['status'];
      }

      $serieId="";
      if (isset($_POST['serieId'])) 
      {
        $serieId=$_POST['serieId'];
      }

      if (isset($_POST['shippingAddress'])) 
      {
        $shippingAddress=$_POST['shippingAddress'];
      }
      
      if (isset($_POST['shippingRules'])) 
      {
        $shippingRules=$_POST['shippingRules'];
      }
      
    
      if (isset($_POST['subSerieId'])) 
      {
        $subSerieId=$_POST['subSerieId'];
      }
            if (isset($_POST['countryId'])) 
      {
        $countryId=$_POST['countryId'];
      }
      if (isset($_POST['id'])) 
            {
              $id=$_POST['id'];
            }
            $imageData1="";
            $imageData2="";
            if (isset($_POST['imageData1'])) 
            {
              $imageData1=$_POST['imageData1'];
            }      
            if (isset($_POST['imageData2'])) 
            {
              $imageData2=$_POST['imageData2'];
            }  
            if (isset($_POST['remark'])) 
            {
              $remark=$_POST['remark'];
            }  



			
	    		if (isset($_POST['billValue'])) 
            {
              $billValue=$_POST['billValue'];
            }
            if (isset($_POST['userId'])) 
            {
              $userId=$_POST['userId'];
            }
            if (isset($_POST['userId2'])) 
            {
              $userId2=$_POST['userId2'];
            }

            if (isset($_POST['billsIds'])) 
            {
              $billsIds=$_POST['billsIds'];
            }


            if (isset($_POST['billId'])) 
            {
              $billId=$_POST['billId'];
            }
            if (isset($_POST['issuer'])) 
            {
              $issuer=$_POST['issuer'];
            }
            if (isset($_POST['dateText'])) 
            {
              $dateText=$_POST['dateText'];
            }
            if (isset($_POST['printer'])) 
            {
              $printer=$_POST['printer'];
            }
       
            if (isset($_POST['year'])) 
            {
              $year=$_POST['year'];
            }
            if (isset($_POST['initYear'])) 
            {
              $initYear=$_POST['initYear'];
            }
            

            if (isset($_POST['endYear'])) 
            {
              $endYear=$_POST['endYear'];
            }   
            if (isset($_POST['extraData'])) 
            {
              $extraData=$_POST['extraData'];
            }
             
            if (isset($_POST['description'])) 
            {
              $description=$_POST['description'];
            }
            if (isset($_POST['canonical'])) 
            {
              $canonical=$_POST['canonical'];
            }
            if (isset($_POST['resume'])) 
            {
              $resume=$_POST['resume'];
            }

            if (isset($_POST['tags'])) 
            {
              $tags=$_POST['tags'];
            }

       

          if (isset($_POST['grade'])) 
          {
            $grade=$_POST['grade'];
          }
          if (isset($_POST['frontSerie'])) 
          {
            $frontSerie=$_POST['frontSerie'];
          }
          if (isset($_POST['backSerie'])) 
          {
            $backSerie=$_POST['backSerie'];
          }
          if (isset($_POST['numSerie'])) 
          {
            $numSerie=$_POST['numSerie'];
          }

          
          if (isset($_POST['firstSerial'])) 
          {
            $firstSerial=$_POST['firstSerial'];
          }
          if (isset($_POST['lastSerial'])) 
          {
            $lastSerial=$_POST['lastSerial'];
          }
          if (isset($_POST['purchaseDate'])) 
          {
            $purchaseDate=$_POST['purchaseDate'];
          }
         
   
          if (isset($_POST['publicNotes'])) 
          {
            $publicNotes=$_POST['publicNotes'];
          }
        
            if (isset($_POST['privateNotes'])) 
            {
              $privateNotes=$_POST['privateNotes'];
         
            }
          if (isset($_POST['sellPrice'])) 
          {
            $sellPrice=$_POST['sellPrice'];
          }
          if (isset($_POST['sellActive'])) 
          {
            $sellActive=$_POST['sellActive'];
          }
          if (isset($_POST['active'])) 
          {
            $active=$_POST['active'];
          }
          if (isset($_POST['purchasePrice'])) 
          {
            $purchasePrice=$_POST['purchasePrice'];
          }



          if (isset($_POST['restored'])) 
          {
            $restored=$_POST['restored'];
          }
          if (isset($_POST['errorNote'])) 
          {
            $errorNote=$_POST['errorNote'];
          }
          if (isset($_POST['replacement'])) 
          {
            $replacement=$_POST['replacement'];
          }
          if (isset($_POST['specimen'])) 
          {
            $specimen=$_POST['specimen'];
          }
          if (isset($_POST['proof'])) 
          {
            $proof=$_POST['proof'];
          }
          if (isset($_POST['falseBill'])) 
          {
            $falseBill=$_POST['falseBill'];
          }

            if (isset($_POST['init'])) 
            {
              $init=$_POST['init'];
            }
            
            if (isset($_POST['end'])) 
            {
              $end=$_POST['end'];
            }   

            if (isset($_POST['color1'])) 
            {
              $color1=$_POST['color1'];
            }
            
            if (isset($_POST['color2'])) 
            {
              $color2=$_POST['color2'];
            }
            if (isset($_POST['info'])) 
            {
              $info=$_POST['info'];
            }  

            if (isset($_POST['surnames'])) 
            {
              $surnames=$_POST['surnames'];
            }
            
            if (isset($_POST['bornDate'])) 
            {
              $bornDate=$_POST['bornDate'];
            }
            
            if (isset($_POST['sex'])) 
            {
              $sex=$_POST['sex'];
            }
            
            if (isset($_POST['address'])) 
            {
              $address=$_POST['address'];
            }
            
            if (isset($_POST['dni'])) 
            {
              $dni=$_POST['dni'];
            }
            
            if (isset($_POST['phone'])) 
            {
              $phone=$_POST['phone'];
            }
            
            if (isset($_POST['height'])) 
            {
              $height=$_POST['height'];
            }
            
            
            
            if (isset($_POST['patologies'])) 
            {
              $patologies=$_POST['patologies'];
            }
            
            if (isset($_POST['sport'])) 
            {
              $sport=$_POST['sport'];
            }
            if (isset($_POST['senderId'])) 
            {
              $senderId=$_POST['senderId'];
            }
            if (isset($_POST['sms'])) 
            {
              $sms=$_POST['sms'];
            }
            if (isset($_POST['target'])) 
            {
              $target=$_POST['target'];
            }
            if (isset($_POST['sender'])) 
            {
              $sender=$_POST['sender'];
            }

            if (isset($_POST['managingFor'])) 
            {
              $managingFor=$_POST['managingFor'];
            }

            if (isset($_POST['centering'])) 
            {
              $centering=$_POST['centering'];
            }
            if (isset($_POST['holes'])) 
            {
              $holes=$_POST['holes'];
            }
            if (isset($_POST['paper'])) 
            {
              $paper=$_POST['paper'];
            }
            if (isset($_POST['smell'])) 
            {
              $smell=$_POST['smell'];
            }
            if (isset($_POST['manipulation'])) 
            {
              $manipulation=$_POST['manipulation'];
            }
            if (isset($_POST['note'])) 
            {
              $note=$_POST['note'];
            }
    }
	  switch ($action) {      

        case "addSerie":				
          $resultArray= addSerie($serieId,$id);         
          break;
          case "addSubSerie":				
            $resultArray= addSubSerie($subSerieId,$id);         
            break;
            case "addAllSubSeries":				
              $resultArray= addAllSubSeries($extraData,$id);         
              break;
              case "addAllSeriesCountries":
                $resultArray= addAllSeriesCountries($id,$countryId);         
              break;
              case "addAllSeriesSubseriesCountries":
                $resultArray= addAllSeriesSubseriesCountries($id,$countryId);         
              break;

              case "addAll":	                
                $resultArray= addAllSubSeries($extraData,$id);           
                $resultArray= addSerie($serieId,$id);      			
                break;
                case "getSugestions":		
                  $resultArray= getSugestions();
                 
                  break;
		  	case "getSeries":
				
			  $resultArray= getTableData("series","",$limit,$start);
			 
      	break;
        case "getSeriesByCollectionId":
          $resultArray= getSeriesByCollectionId($id,$userId);
          break;
          case "getBillsPDFByUser":
            $resultArray= getBillsPDFByUser($userId);
            break;
          case "getBillsPDFByCollectionId":
            $resultArray= getBillsPDFByCollectionId($id,$userId);
                  break;
                  case "getBillsPDFByCountryId":
                    $resultArray= getBillsPDFByCountryId($countryId,$userId);
                          break;
          case "getSeriesByCountryId":
            $resultArray= getSeriesByCountryId($countryId,$userId);
            break;
        case "getSeriesByFilter":
$queryString="";
$queryStringExtra="";
$firstFilter=true;



if (isset($serieId))
{
  if ($serieId!="")
  {
       $queryString = $queryString . " series.serieId LIKE '%" . $serieId . "%'";
       $firstFilter=false;
  }

}
$queryStringExtra =  " series.serieId LIKE '%" . $extraData . "%'";


if (isset($countryId))
{
  if ($countryId!="")
  {
    if ($firstFilter)
    {
      $queryString = $queryString . " series.countryId=" . $countryId;
    }else
    {
      $queryString = $queryString . " AND series.countryId=" . $countryId;
    }
    $firstFilter=false;
  }
  
}



if (isset($printer))
{
  if ($printer!="")
  {
    if ($firstFilter)
    {
      if (($printer!=-1) && ($printer!="-1"))
      {
        $printer=str_replace(",","%",$printer);
        $printer=str_replace(" ","%",$printer);
        $printer=str_replace("(","%",$printer);
        $printer=str_replace(")","%",$printer);
        $printer=str_replace("#","%",$printer);
        $queryString = $queryString . " series.printer  LIKE '%" . trim($printer) . "%'";
        $firstFilter=false;
      }
     
    }else
    {
      if (($printer!=-1) && ($printer!="-1"))
      {
        $printer=str_replace(",","%",$printer);
        $printer=str_replace(" ","%",$printer);
        $printer=str_replace("(","%",$printer);
        $printer=str_replace(")","%",$printer);
        $printer=str_replace("#","%",$printer);
        $queryString = $queryString . " AND series.printer LIKE '%" . trim($printer) . "%'";   
        $firstFilter=false;
      }
     
    }

  }  
     
}
$auxExtraData=$extraData;
$auxExtraData=str_replace(",","%",$auxExtraData);
$auxExtraData=str_replace(" ","%",$auxExtraData);
$auxExtraData=str_replace("(","%",$auxExtraData);
$auxExtraData=str_replace(")","%",$auxExtraData);
$auxExtraData=str_replace("#","%",$auxExtraData);
$queryStringExtra = $queryStringExtra . " OR series.printer LIKE '%" . trim($auxExtraData) . "%'";   


if (isset($issuer))
{
  if ($issuer!="")
  {
    if ($firstFilter)
    {

     $issuer=str_replace(",","%",$issuer);
     $issuer=str_replace(" ","%",$issuer);
     $issuer=str_replace("(","%",$issuer);
     $issuer=str_replace(")","%",$issuer);
     $issuer=str_replace("#","%",$issuer);
      $queryString = $queryString . "  series.issuer LIKE '%" . trim($issuer) . "%'";

    }else
    {
      $issuer=str_replace(",","%",$issuer);
      $issuer=str_replace(" ","%",$issuer);
      $issuer=str_replace("(","%",$issuer);
      $issuer=str_replace(")","%",$issuer);
      $issuer=str_replace("#","%",$issuer);
       $queryString = $queryString . " AND series.issuer LIKE '%" . trim($issuer) . "%'";

    }
    $firstFilter=false;
  }  
     
}

$queryStringExtra = $queryStringExtra . " OR series.issuer LIKE '%" . trim($auxExtraData) . "%'";   



if (isset($dateText))
{
   if ($dateText!="")
   {
    if ($firstFilter)
    {
     $queryString = $queryString . " series.dateText LIKE '%" . $dateText . "%'";

    }else
    {
     $queryString = $queryString . " AND series.dateText LIKE '%" . $dateText . "%'";

    }
    $firstFilter=false;
   }
     
}

$queryStringExtra = $queryStringExtra . " OR series.dateText LIKE '%" . trim($extraData) . "%'"; 


if (isset($billValue))
{
   if ($billValue!="")
   {
              if (is_numeric($billValue))
              {
                    if(strpos($billValue, ".") !== false)
                    {
                    
                      $auxBillValue= str_replace(".","",$billValue);
                    $auxBillValue= str_replace(",","",$billValue);

                    }else
                    {
                      $auxBillValue=  number_format($billValue,0,",",".");              

                    }
              }else
              {
                $auxBillValue=$billValue;
              }
    
          
                if ($firstFilter)
                {

                $queryString = $queryString . " (series.billValue LIKE '%" . $billValue . "%' OR series.billValue LIKE '%" . $auxBillValue . "%')";

                }else
                {
                $queryString = $queryString . " AND (series.billValue LIKE '%" .  $billValue . "%' OR series.billValue LIKE '%" . $auxBillValue . "%')";

                
                }

                $firstFilter=false;
     
  
   
   }     
}

$queryStringExtra = $queryStringExtra . " OR series.billValue LIKE '%" . trim($extraData) . "%'"; 
if (isset($extraData))
{
      if ($extraData!="")
      {
            if ($firstFilter)
            {
               $queryString = $queryStringExtra;
            }else
            {
              $queryString = $queryString . " AND ( " . $queryStringExtra . " )";
            }        
      }
    
}
//cho $queryString;
//die();

//$serieId,$countryId,$issuer,$dateText,$billValue
          $resultArray= getSeriesByFilter($queryString, $limit,$start, " serieID ASC");         
          break;
    case "getInteractionById":
      $resultArray=getInteractionById($id);
      break;
      case "getUserBillsStats":
        $resultArray=getUserBillsStats($id);
        break;
    case "getMyInteractions":
      $resultArray= getMyInteractions($userId,$limit,$start);
      break;
		case "getSeriesByCountry":				

			  $resultArray= getSeriesByCountry($countryId);
			 
      	break;
		case "getSerieByIdAndCountry":
				  $resultArray= getSerieByIdAndCountry($serieId,$countryId);
      	break;
    case "approveSubSerieSugestion":
      $newId=approveSubSerieSugestion($id);
      if ($newId>0)//se ha copiado bien la sugerencia
      {
        $resultArray= deleteFromTable("provisionalSubSeries",$id); //ELIMINAMOS LA SUGERENCIA
        //MOVEMOS LAS IMAGENES
        //$imageData1, $imageData2
        if ($imageData1!="")
        {
          if (file_exists('../images/billetesSugeridos/' . $imageData1))
          {
            copy('../images/billetesSugeridos/' . $imageData1, '../images/billetes/' . $imageData1);
          }
        }
        if ($imageData2!="")
        {
          if (file_exists('../images/billetesSugeridos/' . $imageData2))
          {
            copy('../images/billetesSugeridos/' . $imageData2, '../images/billetes/' . $imageData2);    
          }
        }
        
        $resultArray = array("id" => 1, "message" => "Se ha aprobado la sugerencia correctamente.");
      }else
      {
        $resultArray = array("id" => -1, "message" => "Error al aprobar la sugerencia.");
      }
  break;
    case "approveSugestion":
          $newId=approveSugestion($id);
 
          if ($newId>0)//se ha copiado bien la sugerencia
          {
            $resultArray= deleteFromTable("provisionalSeries",$id); //ELIMINAMOS LA SUGERENCIA
            //MOVEMOS LAS IMAGENES
            //$imageData1, $imageData2
            if ($imageData1!="")
            {
              if (file_exists('../images/billetesSugeridos/' . $imageData1))
              {
                copy('../images/billetesSugeridos/' . $imageData1, '../images/billetes/' . $imageData1);
              }
           
            }
            if ($imageData2!="")
            {
              if (file_exists('../images/billetesSugeridos/' . $imageData2))
              {
                copy('../images/billetesSugeridos/' . $imageData2, '../images/billetes/' . $imageData2);    
              }
                     
            }          
            
            $resultArray = array("id" => $newId, "message" => "Se ha aprobado la sugerencia correctamente.");
          }else
          {
            $resultArray = array("id" => -1, "message" => "Error al aprobar la sugerencia.");
          }
      break;
      case "deleteUser":
        $resultArray= deleteFromTable("users",$userId);
      break;
    case "deleteSugestion":
      $resultArray= deleteFromTable("provisionalSeries",$id);
      break;
    case "deleteSugestionSubSerie":
      $resultArray= deleteFromTable("provisionalSubSeries",$id);
      break;
		case "getProvisionalSerieById":
      $resultArray= getProvisionalSerieById($id);          
        break;
        case "getProvisionalSubSerieById":
          $resultArray= getProvisionalSubSerieById($id);          
            break;
		        case "getSerieById":    
              
              $resultArray= getSerieById($id);          
           // $resultArray= getById($id, "series");          
        break;
        case "getSubSerieSugestionById":
          $resultArray= getSubSerieSugestionById($id);          
          break;
        case "getSubSerieById":  

          $resultArray= getSubSerieById($id);          
      break;
        case "getGrades":
          $resultArray=  getGrades();
          break;
    case "getCountriesByOwnerId":
      $resultArray=  getCountriesByOwnerId($userId);
      break;
    case "getCountriesOnSale":
      
      $resultArray=  getCountriesOnSale();
      break;
  	case "getCountries":
			  $resultArray=  getCountries();
			 
      	break;
    case "getPrinters":
      $resultArray=  getPrinters();			       
      break;
    case "getIssuers":
      $resultArray=  getIssuers();			       
      break;
      case "createProvisionalSubReference":
        $resultArray= createProvisionalSubReference($serieId,$subSerieId,$userId);
        
        break;
      case "createProvisionalSerie":
        $resultArray= createProvisionalSerie($serieId,$countryId,$userId);
        break;
        case "nextSerie":
          $resultArray=nextSerie($id);
        break;
     case "createSerie":
    $resultArray= createSerie($serieId,$countryId);
		 break;
     case "createSubSerie":
      $resultArray= createSubSerie($serieId,$subSerieId);
      break;
	   case "deleteSubSerie":
			$resultArray= deleteFromTable("subSeries",$id);
		 break;

	   case "deleteSerie":
			$resultArray= deleteFromTable("series",$id);
		 break;
		 case "getSeriesAndSubSeriesByCountry":
      $resultArray= getSeriesAndSubSeriesByCountry($countryId);
     break;
		case "getSubSeriesBySerie":    		
            $resultArray= getSubSeriesBySerie($id);       
            
            

            
        break;
        case "getSubSeriesByCollection":
          $resultArray= getSubSeriesByCollection($id);         
          break;
          case "getSeriesByCollection":          
              $resultArray= getSeriesByCollection($id);          
            break;
            case "removeSerieFromCollection":
              $resultArray= removeSerieFromCollection($serieId,$id);          
              break;
              case "removeSubSerieFromCollection":
                $resultArray= removeSubSerieFromCollection($subSerieId,$id);          
                break;
             
              case "activateArticle":
                $resultArray=activateStatus("blog",$id,$status);
                break;
                case "removeBillFromInteraction":
                  $resultArray= removeBillFromInteraction($id,$billId);                 
                 break;
                 case "createInteraction":
                  $resultArray= createInteraction($billId,$userId,$userId2,$option);         
                  
                  $ids= explode(",",$billId);
                  foreach($ids as $id){
                    updateBillState($id,3);
                    }
                    $users= getUsersByIds($userId,$userId2);
                  //  var_dump($users);
                    if (count($users)>1)
                    {
                     $interactionLink= "<a href='https://banknotescollection.com/userPanel/editInteraction/" . $resultArray[0] . "'>View Interaction</a>";
                     $buyerName= getNameFromResult($users, $userId);
                    // echo $buyerName;
                     $sellerName= getNameFromResult($users, $userId2);
                     $buyerEmail= getEmailFromResult($users,$userId);
                     $sellerEmail= getEmailFromResult($users,$userId2);


                    sendEmail($sellerEmail,"<p>Interaction Information",$buyerName . " wants to buy some of your bills.</p>". $interactionLink);
                    }
              break;
                case "updateInteraction":
                  $resultArray= updateInteraction($id,$status);
           
                  if ($status==10)
                  {
                   // echo "ENTRA";
                    $ids= explode(",",$billsIds);
                  //  var_dump($ids);

                    foreach($ids as $changeId){
                     // echo "ENTRA2";
                            $insertId= addBillToOldSold($changeId);                           
                            //echo $insertId;
                            updateBillOwner($changeId,$userId, $userId2, $sellPrice);
                        //    echo "LLEGA";
                            
                      }
                  }
                 $users= getUsersByIds($userId,$userId2);
                 if (count($users)>1)
                 {
                  $interactionLink= "<a href='https://banknotescollection.com/userPanel/editInteraction/" . $id . "'>View Interaction</a>";
                  $buyerName= getNameFromResult($users, $userId);
                  $sellerName= getNameFromResult($users, $userId2);
                  $buyerEmail= getEmailFromResult($users,$userId);
                  $sellerEmail= getEmailFromResult($users,$userId2);
             
                   //userdId= buyer
                   //userId2= seller
                                switch ($status) {
                                case 2: //CANCELADO POR COMPRADOR
                                  sendEmail($sellerEmail,"<p>Interaction Information",$buyerName . " cancelled the interaction.</p>". $interactionLink);
                                  break;
                                case 1://CANCELADO POR VENDEDOR
                                  sendEmail($buyerEmail,"Interaction Information",$sellerName . " cancelled the interaction.</p>". $interactionLink);
                                break;
                                case 3://EL VENDEDOR HA RECIBIDO 
                                  sendEmail($buyerEmail,"Interaction Information",$sellerName . " recieved the payment.</p>". $interactionLink);
                                  break;
                                case 4:        ////EL COMPRADOR ha recibido el billete
                                  sendEmail($sellerEmail,"Interaction Information",$buyerName . " recieved the bills.</p>". $interactionLink);
                                  break;
              
                                case 10:  //TRANSACCION EXITOSA
                                  sendEmail($sellerEmail,"Interaction Information","The transacction was succesfull. You sold the bills to " . $buyerName . "</p>". $interactionLink);
                                  sendEmail($buyerEmail,"Interaction Information","The transacction was succesfull. You bougth the bills from " . $sellerName. "</p>". $interactionLink);
                                  break;
                        
                                default:
                                
                              }
                              
                 }
                 

          
                //  echo "FIN";
              break;
              case "testAddBillToOldSold":
                $insertId= addBillToOldSold($id);      
                echo $insertId;
                break;
              case "TestUpdateSubSeries":
                //memel-500-francs-1981-1990-test_1.jpg
                //https://banknotescollection.com/api/webService.php?action=updateSerie&id=121093&serieId=test&billValue=500%20Francs&issuer=FSADF%20fdsf&dateText=1981-1990&printer=FSrlAfdffdaDF&extraData=SDFADFgfsdfvddvdsfgfg%20gfgf&countryId=482&imageData1=gfdffg&imageData2=fgdgfgf&imageName1=memel-500-francs-1980-1990-test_1.jpg&imageName2=memel-500-francs-1980-1990-test_2.jpg&newImageName1=memel-500-francs-1981-1990-test_1.jpg&newImageName2=memel-500-francs-1981-1990-test_2.jpg
                updateSubReferencesImagesFromSerie(121093,"memel-500-francs-1980-1990-test_1.jpg","memel-500-francs-1980-1990-test_2.jpg","memel-500-francs-1981-1990-test_1.jpg", "memel-500-francs-1981-1990-test_2.jpg");
                break;
              case "updateArticle":
           //     'id' => $id,
             //   'name' => $txtTitle,
              //  'description' =>$txtDescription,
               // 'canonical' =>$txtCanonical,
               // 'resume' =>$txtResume,
               // 'extraData' => $fullArticle,
               // 'tags' => $txtTags);
                $resultArray= updateArticle($id,$name,$description,$canonical,$resume,$extraData,$tags);
                
                break;
                case "updateCollection":                  
                  $resultArray= updateCollection($id,$name,$extraData,$active);
              break;
              case "updateProvisionalSerie":
                $resultArray= updateProvisionalSerie($id,$serieId,$billValue,$issuer,$dateText,$printer,$initYear,$endYear, $countryId,$imageData1,$imageData2, $extraData);
                break;
      case "updateSerie":
		  //$id,$serieId,$billValue,$issuer,$dateText,$printer,$overPrinter,$initYear,$endYear,$extraData
      
      $resultArray= updateSerie($id,$serieId,$billValue,$issuer,$dateText,$printer, $countryId,$imageData1,$imageData2, $extraData,$imageName1,$imageName2, $newImageName1,$newImageName2);
      break;
      case "updateProvisionalSubSerie":
        $resultArray= updateProvisionalSubSerie($id,$subSerieId,$remark);
        break;
        

      case "updateSubSerie":
        $resultArray= updateSubSerie($id,$subSerieId,$remark,$imageName1,$imageName2, $newImageName1,$newImageName2);
        break;
        case "resetUser":
            
          $resultArray= resetPass($email,"users");
          break;
          case "createUser":
            $resultArray= registerUser($name,$email,$pass);
            break;
            case "removeCountryCollection":
              $resultArray= removeCountryCollection($userId,$id); 
              break;
            case "addCountryCollection":
              $resultArray= addCountryCollection($userId,$id);
              break;
            case "removeCollection":
              $resultArray= removeCollection($userId,$id); 
              break;
            case "addCollection":
              $resultArray= addCollection($userId,$id);
              break;
              case "createArticle":
                $resultArray= createArticle($name);
                break;  
            case "createCollection":
              $resultArray= createCollection($name,$id);
              break;
              case "getOwnersByIds":
         
                $resultArray= getOwnersByIds($extraData);   
                break;
            case "getUsers":              
              $resultArray= getTableData("users","",$limit,$start);              
      	break;
        case "getMyOtherCollectionsByOwner":
          $resultArray= getMyOtherCollectionsByOwner($userId);
            break;
        case "getCollectionsByOwner":
          $resultArray= getCollectionsByOwner($userId);
            break;
            case "getSoldBillsByUser":
              $resultArray= getSoldBillsByUser($userId,$limit,$start);
                    break;
            case "getBougthBillsByUser":
              $resultArray= getBougthBillsByUser($userId,$limit,$start);
                    break;

        case "getArticles":          
            $resultArray= getTableData("blog","",$limit,$start);
        //    $resultArray= getTableData("collections","",$limit,$start);
              break;
              case "getArticles2":          
                $resultArray= getTableData("blog","status=1",$limit,$start);
            //    $resultArray= getTableData("collections","",$limit,$start);
                  break;
        case "getArticleById":
          $resultArray= getById($id, "blog");          
          break;
          case "getArticleByCanonical":
            $resultArray= getByCanonical($canonical, "blog");          
            break;
        case "getCollections":
          $resultArray= getCollections($limit,$start);
      //    $resultArray= getTableData("collections","",$limit,$start);
            break;
        case "getUserById":    
          $resultArray= getById($userId, "users");          
        break;
        
        case "getCollectionById":
          $resultArray= getCollectionById($id);          
        break;
        case "updateUser":
          $resultArray=updateUser($userId,$name,$surnames,$phone,$shippingRules,$shippingAddress,$status,$issuer,$currency,$payment);
      break;
        case "updateUserPassword":
          $resultArray=updatePassword($userId,$pass,$newPass,"users");
        break;
        case "updateUserPasswordAdmin":
          $resultArray=updatePasswordAdmin($userId,$pass,"users");
        break;
        case "getStats":
    
           $resultArray=getStats();        
           
         break;
         case "loginUser":
          $resultArray= login($email,$pass,"users");
     break;
     case "getBillsBySerie":
      $resultArray= getBillsBySerie($serieId);           
  break;
     case "getBillsByUser":    

      $resultArray= getBillsByUser($userId);           
  break;
  case "getBillsBySerieAndFilter":    
    $resultArray= getBillsBySerieAndFilter($serieId,$subSerieId,$grade,$numSerie,$countryId,$status,$userId);    
    break; 
    case "getBillsBySerieAndUserAndFilter":
      $resultArray= getBillsBySerieAndUserAndFilter($serieId,$subSerieId,$userId,$grade,$numSerie,$countryId);    
      break;
  case "getBillsBySerieAndUser":
    $resultArray= getBillsBySerieAndUser($serieId,$subSerieId,$userId);    
    break;

  case "getBillsByFilter":
    $queryString="";


    if (isset($serieId))
    {
      if ($serieId!="")
      {
           $queryString = $queryString . " AND series.serieId LIKE '%" . $serieId . "%'";
  
      }
    
    }

    if (isset($grade))
    {
            if ($grade!="")
            {
            
              $queryString = $queryString . " AND bills.grade=" . $grade;  

            }  
        
    }
    
    if (isset($numSerie))
    {
            if ($numSerie!="")
            {
            // concat(city,name)
              $queryString = $queryString . " AND concat(bills.frontSerie,bills.numSerie,bills.backSerie)  LIKE '%" . $numSerie . "%'";  

            }  
        
    }
    if (isset($printer))
    {
      if ($printer!="")
      {
    
          if (($printer!=-1) && ($printer!="-1"))
          {
            $queryString = $queryString . " AND series.printer=  LIKE '%" . $printer . "%'";   
            $firstFilter=false;
          }
         
        
    
      }  
         
    }
    
    if (isset($countryId))
    {
      if ($countryId!="")
      {
    
          $queryString = $queryString . " AND series.countryId=" . $countryId;     
      }
      
    }
    if (isset($issuer))
    {
      if ($issuer!="")
      {
     
        $issuer=str_replace(",","%",$issuer);
        $issuer=str_replace(" ","%",$issuer);
        $issuer=str_replace("(","%",$issuer);
        $issuer=str_replace(")","%",$issuer);
        $issuer=str_replace("#","%",$issuer);
         $queryString = $queryString . " AND series.issuer LIKE '%" . trim($issuer) . "%'";
  
      }  
         
    }
    if (isset($dateText))
    {
       if ($dateText!="")
       {
     
         $queryString = $queryString . " AND series.dateText LIKE '%" . $dateText . "%'";
       }
         
    }
    if (isset($billValue))
    {
      if ($billValue!="")
      {
                 if (is_numeric($billValue))
                 {
                       if(strpos($billValue, ".") !== false)
                       {
                       
                         $auxBillValue= str_replace(".","",$billValue);
                       $auxBillValue= str_replace(",","",$billValue);
   
                       }else
                       {
                         $auxBillValue=  number_format($billValue,0,",",".");              
   
                       }
                 }else
                 {
                   $auxBillValue=$billValue;
                 }
       
             
                   $queryString = $queryString . " AND (series.billValue LIKE '%" .  $billValue . "%' OR series.billValue LIKE '%" . $auxBillValue . "%')";
     }
    }


    $resultArray= getBillsByFilter($limit,$start, $queryString);    
    break;

    case "getGroupedBillsByFilter2":
      $queryString="";
      $queryString = " bills.sellActive=1";
      if (isset($serieId))
      {
        if ($serieId!="")
        {
             $queryString = $queryString . " AND series.serieId LIKE '%" . $serieId . "%'";    
        }      
      }
  
      if (isset($grade))
      {
              if ($grade!="")
              {              
                $queryString = $queryString . " AND bills.grade=" . $grade;    
              }            
      }
      
      if (isset($numSerie))
      {
        $numSerie=trim($numSerie);
              if ($numSerie!="")
              {
              // concat(city,name)
                $queryString = $queryString . " AND concat(bills.frontSerie,bills.numSerie,bills.backSerie)  LIKE '%" . $numSerie . "%'";    
              }            
      }
      if (isset($printer))
      {
        if ($printer!="")
        {      
            if (($printer!=-1) && ($printer!="-1"))
            {
              $printer=str_replace(",","%",$printer);
              $printer=str_replace(" ","%",$printer);
              $printer=str_replace("(","%",$printer);
              $printer=str_replace(")","%",$printer);
              $printer=str_replace("#","%",$printer);
              $queryString = $queryString . " AND series.printer LIKE '%" . trim($printer) . "%'";   
              $firstFilter=false;
            }
        }             
      }


      if (isset($countryId))
      {
        if ($countryId!="")
        {      
            $queryString = $queryString . " AND series.countryId=" . $countryId;     
        }        
      }
      if (isset($issuer))
      {
        if ($issuer!="")
        {
          $issuer=str_replace(",","%",$issuer);
          $issuer=str_replace(" ","%",$issuer);
          $issuer=str_replace("(","%",$issuer);
          $issuer=str_replace(")","%",$issuer);
          $issuer=str_replace("#","%",$issuer);
           $queryString = $queryString . " AND series.issuer LIKE '%" . trim($issuer) . "%'";    
        }  
           
      }
      if (isset($dateText))
      {
         if ($dateText!="")
         {       
           $queryString = $queryString . " AND series.dateText LIKE '%" . $dateText . "%'";
         }           
      }
      if (isset($billValue))
      {
        if ($billValue!="")
        {
          $billValue=str_replace("---dot---",".",$billValue);
          $billValue=str_replace("---com---",",",$billValue);
        //  $billValue="";
          // $auxBillValueWords= explode(" ",$billValue);
        //   foreach($auxBillValueWords as $word)
         //  {
          //    if(strpos($word, ".") !== false)
           //   {
              
             //   $word= str_replace(".","",$word);
             // $word= str_replace(",","",$word);

              //}else
             // {
               // $word=  number_format($word,0,",",".");  
              //}
           //}

                   if (is_numeric($billValue))
                   {
                         if(strpos($billValue, ".") !== false)
                         {
                         
                           $auxBillValue= str_replace(".","",$billValue);
                           $auxBillValue= str_replace(",","",$billValue);
     
                         }else
                         {
                           $auxBillValue=  number_format($billValue,0,",",".");              
     
                         }
                        // $queryString = $queryString . " AND (series.billValue LIKE '" .  $billValue . "' OR series.billValue LIKE '" . $auxBillValue . "')";
                         $queryString = $queryString . " AND (series.billValue LIKE '" .  $billValue . " %' OR series.billValue LIKE '" . $auxBillValue . " %')";
                   }else
                   {
                     $auxBillValue=$billValue;
                     $queryString = $queryString . " AND (series.billValue LIKE '%" .  $billValue . "%')";
                   }         
       }
      }
  

      if (isset($id))
      {
        if ($id!="")
        {      
            $queryString =  " bills.sellActive=1 AND bills.ownerId=" . $id;     
        }        
      }  
      $resultArray= getGroupedBillsByFilter2($limit,$start, $queryString);    
      break;
    case "getGroupedBillsByFilter":
      $queryString="";
      $queryString = " bills.sellActive=1";
      if (isset($serieId))
      {
        if ($serieId!="")
        {
             $queryString = $queryString . " AND series.serieId LIKE '%" . $serieId . "%'";    
        }      
      }
  
      if (isset($grade))
      {
              if ($grade!="")
              {              
                $queryString = $queryString . " AND bills.grade=" . $grade;    
              }            
      }
      
      if (isset($numSerie))
      {
        $numSerie=trim($numSerie);
              if ($numSerie!="")
              {
              // concat(city,name)
                $queryString = $queryString . " AND concat(bills.frontSerie,bills.numSerie,bills.backSerie)  LIKE '%" . $numSerie . "%'";    
              }            
      }
      if (isset($printer))
      {
        if ($printer!="")
        {      
            if (($printer!=-1) && ($printer!="-1"))
            {
              $printer=str_replace(",","%",$printer);
              $printer=str_replace(" ","%",$printer);
              $printer=str_replace("(","%",$printer);
              $printer=str_replace(")","%",$printer);
              $printer=str_replace("#","%",$printer);
              $queryString = $queryString . " AND series.printer LIKE '%" . trim($printer) . "%'";   
              $firstFilter=false;
            }
        }             
      }


      if (isset($countryId))
      {
        if ($countryId!="")
        {      
            $queryString = $queryString . " AND series.countryId=" . $countryId;     
        }        
      }
      if (isset($issuer))
      {
        if ($issuer!="")
        {
          $issuer=str_replace(",","%",$issuer);
          $issuer=str_replace(" ","%",$issuer);
          $issuer=str_replace("(","%",$issuer);
          $issuer=str_replace(")","%",$issuer);
          $issuer=str_replace("#","%",$issuer);
           $queryString = $queryString . " AND series.issuer LIKE '%" . trim($issuer) . "%'";    
        }  
           
      }
      if (isset($dateText))
      {
         if ($dateText!="")
         {       
           $queryString = $queryString . " AND series.dateText LIKE '%" . $dateText . "%'";
         }           
      }
      if (isset($billValue))
      {
        if ($billValue!="")
        {
          $billValue=str_replace("---dot---",".",$billValue);
          $billValue=str_replace("---com---",",",$billValue);
        //  $billValue="";
          // $auxBillValueWords= explode(" ",$billValue);
        //   foreach($auxBillValueWords as $word)
         //  {
          //    if(strpos($word, ".") !== false)
           //   {
              
             //   $word= str_replace(".","",$word);
             // $word= str_replace(",","",$word);

              //}else
             // {
               // $word=  number_format($word,0,",",".");  
              //}
           //}

                   if (is_numeric($billValue))
                   {
                         if(strpos($billValue, ".") !== false)
                         {
                         
                           $auxBillValue= str_replace(".","",$billValue);
                           $auxBillValue= str_replace(",","",$billValue);
     
                         }else
                         {
                           $auxBillValue=  number_format($billValue,0,",",".");              
     
                         }
                        // $queryString = $queryString . " AND (series.billValue LIKE '" .  $billValue . "' OR series.billValue LIKE '" . $auxBillValue . "')";
                         $queryString = $queryString . " AND (series.billValue LIKE '" .  $billValue . " %' OR series.billValue LIKE '" . $auxBillValue . " %')";
                   }else
                   {
                     $auxBillValue=$billValue;
                     $queryString = $queryString . " AND (series.billValue LIKE '%" .  $billValue . "%')";
                   }         
       }
      }
  

      if (isset($id))
      {
        if ($id!="")
        {      
            $queryString =  " bills.sellActive=1 AND bills.ownerId=" . $id;     
        }        
      }  
      $resultArray= getGroupedBillsByFilter($limit,$start, $queryString);    
      break;
  case "getGroupedBillsByUser":
    $queryString="";


    if (isset($serieId))
    {
      if ($serieId!="")
      {
        if ($serieId!=-1)
        {
          $queryString = $queryString . " AND series.serieId LIKE '%" . $serieId . "%'";
        }
          
  
      }
    
    }

    if (isset($grade))
    {
            if ($grade!="")
            {
            
              $queryString = $queryString . " AND bills.grade=" . $grade;  

            }  
        
    }
    
    if (isset($numSerie))
    {
            if ($numSerie!="")
            {
            
              $queryString = $queryString . " AND concat(bills.frontSerie,bills.numSerie,bills.backSerie)  LIKE '%" . $numSerie . "%'";  

            }  
        
    }

    if (isset($printer))
    {
      if ($printer!="")
      {
       
          if (($printer!=-1) && ($printer!="-1"))
          {
            $queryString = $queryString . " AND series.printer=  LIKE '%" . $printer . "%'";   
            $firstFilter=false;
          }
         
        
    
      }  
         
    }
    
    
    
    if (isset($countryId))
    {
      if ($countryId!="")
      {
    
          $queryString = $queryString . " AND series.countryId=" . $countryId;     
      }
      
    }
    if (isset($issuer))
    {
      if ($issuer!="")
      {
     
        $issuer=str_replace(",","%",$issuer);
        $issuer=str_replace(" ","%",$issuer);
         $queryString = $queryString . " AND series.issuer LIKE '%" . trim($issuer) . "%'";
  
      }  
         
    }
    if (isset($dateText))
    {
       if ($dateText!="")
       {
     
         $queryString = $queryString . " AND series.dateText LIKE '%" . $dateText . "%'";
       }
         
    }
    if (isset($billValue))
    {
 
       if ($billValue!="")
       {
                  if (is_numeric($billValue))
                  {
                        if(strpos($billValue, ".") !== false)
                        {
                        
                          $auxBillValue= str_replace(".","",$billValue);
                        $auxBillValue= str_replace(",","",$billValue);
    
                        }else
                        {
                          $auxBillValue=  number_format($billValue,0,",",".");              
    
                        }
                  }else
                  {

                    $auxBillValue="";
                            $auxMany=explode(" ",$billValue);
                            foreach($auxMany as $auxOne)
                            {
                              if (is_numeric($auxOne))
                              {
                                    if(strpos($auxOne, ".") !== false)
                                    {
                                    
                                      $auxOne= str_replace(".","",$auxOne);
                                      $auxOne= str_replace(",","",$auxOne);
                                    }else
                                    {
                                      $auxOne=  number_format($auxOne,0,",",".");              
                
                                    }
                              }
                              $auxBillValue=$auxBillValue . " " . $auxOne;
                            }
                            $auxBillValue=trim($auxBillValue);
                    
                  }
        
              
                    $queryString = $queryString . " AND (series.billValue LIKE '%" .  $billValue . "%' OR series.billValue LIKE '%" . $auxBillValue . "%')";
      }
         
    }

//echo $queryString;
    $resultArray= getGroupedBillsByUser($userId,$limit,$start, $queryString);    
  break;

  case "getExpertReviewsByUser":
    $queryString="";


    if (isset($serieId))
    {
      if ($serieId!="")
      {
        if ($serieId!=-1)
        {
          $queryString = $queryString . " AND series.serieId LIKE '%" . $serieId . "%'";
        }    
      }    
    }
   
    
    if (isset($numSerie))
    {
            if ($numSerie!="")
            {            
              $queryString = $queryString . " AND concat(expertReviews.frontSerie,expertReviews.numSerie,expertReviews.backSerie)  LIKE '%" . $numSerie . "%'";  
            }         
    }

    
    if (isset($countryId))
    {
      if ($countryId!="")
      {
    
          $queryString = $queryString . " AND expertReviews.countryId=" . $countryId;     
      }
      
    }


    

//echo $queryString;
    $resultArray= getExpertReviewsByUser($userId,$limit,$start, $queryString);    
    break;
    case "getExpertReviewsByBillData":
      $resultArray=getExpertReviewsByBillData($countryId,$serieId,$subSerieId,$frontSerie,$numSerie,$backSerie);      
      break;
  case "getCountriesByExpertOwnerId":
    $resultArray=  getCountriesByExpertOwnerId($userId);
    break;

    case "getExpertReviewById":
      $resultArray= getById($id, "expertReviews");
      break;    
  case "getBillOwnerDataById":
    $resultArray= getBillOwnerDataById($id);
    break;

  case "getBillById":
    $resultArray= getById($id, "bills");
    break;
      case "createBill":

        $resultArray= createBill($userId,$countryId);
        break;
        case "deleteArticle":
          $resultArray=deleteFromTable("blog", $id);
          break;
        case "deleteCollection":
          $resultArray=deleteFromTable("collections", $id);
      break;
      case "deleteExpertReview":
        $resultArray=deleteFromTable("expertReviews", $id);
        break;
        case "deleteBill":
            $resultArray=deleteFromTable("bills", $id);
        break;
        case "bulkDelete":
        $resultArray=bulkDelete($extraData);
        break;
        case "updateInteractionMessage":
          $resultArray=updateInteractionMessage($extraData,$id);
        break;
        case "bulkUpdateStatus":
          $resultArray=bulkUpdateStatus($extraData,$status);
          case "bulkUpdateStatusPrice":
            $resultArray=bulkUpdateStatusPrice($extraData,$status);
        break;
        case "bulkBills":  
   //       $resultArray = array("id" => 1, "message" => "Se ha insertado un nuevo billete correctamente.", "sql" => $extraData);  
          $resultArray= bulkBills($userId,$countryId,$serieId, $subSerieId, $purchaseDate,$publicNotes,$privateNotes,
          $sellPrice, $sellActive,$purchasePrice,$restored,$errorNote,$extraData);
          break;
          case "updateExpertReview":
            if ($id==-1)
            {
              $resultArray= createExpertReview($id,$userId, $countryId, $serieId, $subSerieId, $grade, $frontSerie, $numSerie, $backSerie, $centering, $holes, $paper, $smell, $manipulation, $note);
            }else
            {

              $resultArray= updateExpertReview($id,$userId, $countryId, $serieId, $subSerieId, $grade, $frontSerie, $numSerie, $backSerie, $centering, $holes, $paper, $smell, $manipulation, $note);
            }
          
            break;  
            case "updateBill":             
              if ($id==-1)
              {
                $resultArray= createBill($id,$userId,$countryId,$serieId, $subSerieId,$grade,$frontSerie,$backSerie, $numSerie
                  ,$purchaseDate,$publicNotes,$privateNotes,$sellPrice,
                 $sellActive,$purchasePrice,$restored,$errorNote,$replacement,$specimen,$proof,$falseBill,$year,$managingFor);
              }else
              {

                $resultArray= updateBill($id,$serieId, $subSerieId,$countryId,$grade,$frontSerie,$backSerie, $numSerie
              ,$purchaseDate,$publicNotes,$privateNotes,$sellPrice,
            $sellActive,$purchasePrice,$restored,$errorNote,$replacement,$specimen,$proof,$falseBill,$year,$managingFor);
              }
            
              break;  
              case "updateBillPrice":             
            
                  $resultArray= updateBillPrice($id,$sellPrice);
             
              
                break; 
                case "getBillsStatsAdmin":
                  $resultArray= getBillsStatsAdmin();
                  break;
              case "getMyPendingInteractions":
                $resultArray= getMyPendingInteractions($userId);
                updateMyPendingInteractions($userId);
                break;
              case "getBillsStats":
                $resultArray= getBillsStats($userId);
                break;
          case "requestTurnChange":
            $resultArray= requestChange($userId,$info,1,$month,$year,$day,$calendarId);
            break;
            case "requestTurnSustitution":      
//              echo "UserID:" . $userId . "<br/>";      
              $resultArray= requestChange($userId,$info,0,$month,$year,$day,$calendarId);
            break;
            case "modifyChangeRequestStatus":
              $resultArray= modifyRequestChange($id,$status);
              break;
    
        case "createTurnType":
          //var url= webServiceUrl + "?action=createTurnType&id=" + id + "&name=" + name + "&init=" + init + "&end=" + end + "&hours=" + hours + "&color1=" + color1 + "&color2=" + color2;
          $resultArray= createTurnType($id, $name,$init,$end,$hours,$color1,$color2);
          break;
        case "createCalendar":
          $resultArray= createCalendar($name,$userId);
          break;        
          case "requestCalendarLink":
            $resultArray= requestCalendarLink($userId,$calendarId);
            break;                            
          case "createLocation":
            $resultArray= createLocation($name,$calendarId);
          break;
          case "createTurn":
            $resultArray=createTurn($calendarId,$userId,$month,$year,$info);
            break;
          case "updateTurn":
            $resultArray=updateTurn($calendarId,$userId,$month,$year,$info);
          break;
          case "getChangeRequestsByCalendar":
            $resultArray= getChangeRequestsByCalendar($calendarId,$month,$year);
              break;
          case "getTurnsByCalendar":
            $resultArray= getTurnsByCalendarIdAndMonth($calendarId,$month,$year);
              break;
         
    

            case "getLocations":
              $resultArray= getTableData("locations","calendarId=" . $calendarId,$limit,$start);
              break;
        case "loginProfesional":
             $resultArray= login($email,$pass,"profesionals");
        break;
        case "loginBusiness":
          $resultArray= login($email,$pass,"business");
        break;        

      
        case "testMail":
          $resultArray=  sendEmail("epepatreup@hotmail.com","TestMail", "<p>Mensaje de prueba</p>");
          break;
    case "green":
      $resultArray = array("status" => 0, "msg" => "Your favorite color is green!");
    break;
    case "testDDBB":
      $resultArray=testDataBase();
        break;
    default:        
        $resultArray = array("status" => 0, "msg" => "Web service Billetes. Accion ilegal.");
}
	


//var_dump($resultArray);
//@mysql_close($conn);
//$resultArray = mb_convert_encoding($resultArray, "UTF-8", "auto");
//$resultArray = convert_to_utf8_recursively($resultArray);

$json= json_encode($resultArray);
/* Output header */
	header('Content-type: application/json');
	echo $json;
     //   echo json_last_error();



function convert_to_utf8_recursively($dat){
    if( is_string($dat) ){
		
        return mb_convert_encoding($dat, 'UTF-8', 'UTF-8');
    }
    elseif( is_array($dat) ){
        $ret = [];
        foreach($dat as $i => $d){
            $ret[$i] = convert_to_utf8_recursively($d);
        }
        return $ret;
    }
    else{
        return $dat;
    }
}