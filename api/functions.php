<?php
error_reporting(E_ERROR | E_PARSE);
$baseUrl="https://banknotescollection.com/controlPanel";
// Include confi.php
require_once ('../Model/BD.php');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function testDataBase()
{
  global $mysqli;
  global $ddbbSms;
  $myArray = array("status" => 0, "message" => $ddbbSms);
    return $myArray;
}
function getProvisionalSerieById($id)
{
  global $mysqli;

    $queryString= "SELECT provisionalSeries.*, countries.name as countryName, continents.name as continentName
     FROM provisionalSeries INNER JOIN countries ON provisionalSeries.countryId=countries.id 
                 INNER JOIN continents ON countries.continentId=continents.id 
                 WHERE  provisionalSeries.id=?";  
//echo "SELECT series.* FROM series INNER JOIN countries ON series.countryId=countries.id WHERE  series.serieId=$serieId AND countries.canonical=$countryCanonical";      

//echo $queryString;
    if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->bind_param("i", $id);     // Bind variables in order
      $stmt->execute();                               // Execute query    
      $results = $stmt->get_result();
    }
$count=0;
$myArray = array();
    while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
    }
    if ($count>0)
    {
	
      return array("id" =>$id, "item"=> $myArray[0]);
     
    } 
    $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
    return $error;
 
}

function getUserBillsStats($id)
{
  global $mysqli; 

  $queryString= "SELECT COUNT(id) as totalBillsIHave FROM bills WHERE ownerId=? AND sellActive!=2";
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("i", $id);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
  $count=0;
  $myArray = array();
  while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
  }
  $totalBillsIHave= $myArray[0][0];
  


  $queryString= "SELECT COUNT(id) as totalBillsOnSale FROM bills WHERE ownerId=? AND sellActive=1";
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("i", $id);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
  $count=0;
  $myArray = array();
  while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
  }
  $totalBillsOnSale= $myArray[0][0];




  $queryString= "SELECT COUNT(id) as totalBillReserved FROM bills WHERE ownerId=? AND sellActive=3";
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("i", $id);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
  $count=0;
  $myArray = array();
  while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
  }
  $totalBillReserved= $myArray[0][0];



  $queryString= "SELECT SUM(purchasePrice) as totalInvested FROM bills WHERE ownerId=? AND sellActive!=2";
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("i", $id);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
  $count=0;
  $myArray = array();
  while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
  }
  $totalInvested= $myArray[0][0];
  


  $queryString= "SELECT SUM(sellPrice) as totalOnSale FROM bills WHERE ownerId=? AND sellActive=1";
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("i", $id);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
  $count=0;
  $myArray = array();
  while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
  }
  $totalOnSale= $myArray[0][0];



  $queryString= "SELECT SUM(purchasePrice) as totalBillCostOnSale FROM bills WHERE ownerId=? AND sellActive=1";
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("i", $id);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
  $count=0;
  $myArray = array();
  while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
  }
  $totalBillCostOnSale= $myArray[0][0];
  



  $queryString= "SELECT SUM(sellPrice) as totalSold FROM billsOld WHERE sellerId=?";
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("i", $id);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
  $count=0;
  $myArray = array();
  while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
  }
  $totalSold= $myArray[0][0];


  $queryString= "SELECT SUM(sellPrice) as totalSold FROM bills WHERE ownerId=? AND sellActive=2";
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("i", $id);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
  $count=0;
  $myArray = array();
  while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
  }
  $totalSold2= $myArray[0][0];
  $totalSold= $totalSold2;// + $totalSold2;

  $queryString= "SELECT SUM(purchasePrice) as totalSoldCost FROM billsOld WHERE sellerId=?";
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("i", $id);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
  $count=0;
  $myArray = array();
  while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
  }
  $totalSoldCost= $myArray[0][0];


  $queryString= "SELECT SUM(purchasePrice) as totalSoldCost FROM bills WHERE ownerId=? AND sellActive=2";
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("i", $id);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
  $count=0;
  $myArray = array();
  while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
  }
  $totalSoldCost2= $myArray[0][0];
  if ($totalSoldCost==null)
  {
    $totalSoldCost=0;
  }
  //echo "a:" . $totalSoldCost2;
  //echo "<br/>b:" . $totalSoldCost;

  $totalSoldCost= $totalSoldCost + $totalSoldCost2;
  $totalSoldCost=round(doubleval($totalSoldCost),2);


  
  //echo "<br/>c:" . $totalSoldCost;
  //echo "<br/>d:" . $totalSold2;
  //echo "<br/>e:" . $totalSold;
  //die();

  if ($totalOnSale==null)
  {
    $totalOnSale=0;
  }
  if ($totalBillCostOnSale==null)
  {
    $totalBillCostOnSale=0;
  }
  if ($totalSoldCost==null)
  {
    $totalSoldCost=0;
  }
  if ($totalSold==null)
  {
    $totalSold=0;
  }
  if ($totalBillsIHave==null)
  {
    $totalBillsIHave=0;
  }
  if ($totalBillsOnSale==null)
  {
    $totalBillsOnSale=0;
  }
  if ($totalBillReserved==null)
  {
    $totalBillReserved=0;
  }
  if ($totalInvested==null)
  {
    $totalInvested=0;
  }
  if ($totalOnSale==null)
  {
    $totalOnSale=0;
  }

  $potencialBenefit=$totalOnSale-$totalBillCostOnSale;
  if ($totalBillCostOnSale==0)
  {
    $potencialBenefitPercent=  "100";
  }else
  {
    $potencialBenefitPercent= ($potencialBenefit*100)/$totalBillCostOnSale;
  }

  
  if ($potencialBenefitPercent==null)
  {
    $potencialBenefitPercent=0;
  }

  if ($potencialBenefit==0)
  {
    $potencialBenefit= round(doubleval($potencialBenefit),2) . "€ (0%)";
  }else
  {
    if ($potencialBenefit>0)
    {
      $potencialBenefit="<span style='color:green;'>" .  round(doubleval($potencialBenefit),2) . "€</span>";
    }else if ($potencialBenefit<0)
    {
      $potencialBenefit="<span style='color:red;'>" . round(doubleval($potencialBenefit),2) . "€</span>";
    }else
    {
      $potencialBenefit="<span>" .  round(doubleval($potencialBenefit),2) . "€</span>";
    }

    $potencialBenefit= $potencialBenefit . " (" . round(doubleval($potencialBenefitPercent),2) . "%)";
  }


  $sellBenefit=$totalSold-$totalSoldCost;
  if ($totalSoldCost==0)
  {
    $sellBenefitPercent=  "100";
  }else
  {
    $sellBenefitPercent= ($sellBenefit*100)/$totalSoldCost;
  }

  if ($sellBenefit==0)
  {
    $sellBenefit= $sellBenefit . "€ (0%)";
  }else
  {
    if ($sellBenefit>0)
    {
      $sellBenefit="<span style='color:green;'>" . $sellBenefit . "€</span>";
    }else if ($sellBenefit<0)
    {
      $sellBenefit="<span style='color:red;'>" . abs($sellBenefit) . "€</span>";
    }else
    {
      $sellBenefit="<span>" . $sellBenefit . "€</span>";
    }
    $sellBenefit= $sellBenefit . " (" . round(doubleval($sellBenefitPercent),2)  . "%)";
  }
  

                                        //1.- Cantidad total de billetes: Suma total de billetes (no incluir los vendidos, a los que no se debe tener acceso)
                                 //       $totalBillsIHave=0;

                                        //2.- Cantidad total de billetes en venta: suma total de billetes en venta.
                                     //   $totalBillsOnSale=0;
  
                                        //3.- Cantidad total de ventas pendientes: suma total de billetes en reservado.
                                      //  $totalBillReserved=0;
  
                                        //4. Total invertido: Suma total del precio de compra todos los billetes
                                    //    $totalInvested=0;
  
                                        //5. Suma total de billetes en venta:  suma total del precio de venta de todos los billetes en venta
                                     //   $totalOnSale=0;
  
                                        //6.Coste de los billetes que están en venta: Precio de compra de los billetes que están en venta.
                                    //    $totalBillCostOnSale=0;
  
                                        //MIX.Beneficio potencial de los billetes en venta: Punto2 - punto3. y porcentaje con regla de 3 (punto2-punto3 x 100 / punto3)
                                 //       $potencialBenefit=0;
  
                                        //7.-  Billetes vendidos: Suma total de preciodeventa de billetes vendidos.
                                  //      $totalSold=0;
  
                                        //8.-Coste de billetes vendidos: suma de preciocompra de los billetes vendidos.
                                  //      $totalSoldCost=0;
  
                                        //MIX. Beneficio de Ventas:  Punto5 - punto6. y porcentaje con regla de 3 (punto5-punto6 x 100 / punto6)
                                   //      $benefit=0;

                                   $totalInvested=  round(doubleval($totalInvested),2);
                                   $totalSoldCost=  round(doubleval($totalSoldCost),2);
                                   $totalBillCostOnSale=  round(doubleval($totalBillCostOnSale),2);
                                   

  return array("totalBillsIHave" =>$totalBillsIHave, "totalBillsOnSale"=> $totalBillsOnSale, "totalBillReserved"=>$totalBillReserved,
    "totalInvested"=>$totalInvested, "totalOnSale"=>$totalOnSale, "totalSold"=>$totalSold, "totalSoldCost"=>$totalSoldCost, "potencialBenefit"=>$potencialBenefit,"sellBenefit"=>$sellBenefit, "totalBillCostOnSale" =>$totalBillCostOnSale );
}
function getSeriesByCountryId($countryId,$userId)
{
  global $mysqli;
  $queryString="SELECT DISTINCT series.serieId as serieIdText,series.*, subSeries.subSerieId, bills.ownerId as isInUserPossesion, countries.name as countryName FROM subSeries           
  LEFT OUTER JOIN bills ON bills.subSerieId=subSeries.id
  LEFT OUTER JOIN  series ON series.id=subSeries.serieId
   INNER JOIN countries ON series.countryId=countries.id
  WHERE series.countryId=? AND (bills.ownerId=? OR bills.ownerId IS NULL) ORDER BY series.serieId ASC, subSeries.subSerieId ASC";
//   WHERE series.countryId=501 AND (bills.ownerId=6 OR bills.ownerId IS NULL)";
        
    //    $queryString ="SELECT series.serieId as serieIdText,series.*,subSeries.*, bills.ownerId as isInUserPossesion, countries.name as countryName FROM series       
    //    LEFT JOIN bills ON series.id = bills.serieId 
    //    LEFT JOIN subSeries as subs2 ON subs2.id=bills.subSerieId
    //    INNER JOIN countries ON series.countryId=countries.id
    //    LEFT JOIN subSeries ON series.id=subSeries.serieId
    //     WHERE series.countryId=? AND (bills.ownerId=? OR bills.ownerId IS NULL)";

    if ($stmt = $mysqli->prepare($queryString)) {
          $stmt->bind_param("ii", $countryId,$userId);     // Bind variables in order
          $stmt->execute();                               // Execute query    
          $results = $stmt->get_result();
        }
      $count=0;
      $myArray = array();


        while ($row = $results->fetch_array()) {  
          $myArray[]=$row;
          $count++;
        }
        if ($count>0)
        {
          $newSeries = array();
          foreach($myArray as $serie)
          {
            $serie=(object) $serie;
            preg_match_all('/([a-zA-Z]+|[0-9]+)/',$serie->serieId,$matches);
            if ($matches!=null)
            {
              if ($matches[0]!=null)
              {
                $serie->first= $matches[0][0];
          
                if (count($matches[0])>1)
                {
                  $serie->second= $matches[0][1];
                }else
                {
                  $serie->second="";
                }
              
                if (count($matches[0])>2)
                {
                  $serie->third= $matches[0][2];
                }else
                {
                  $serie->third= "";
                }
              }else
              {
                $serie->first=$serie->serieId;
              }
             
          
            }else
            {
              $serie->first=$serie->serieId;
            }
           
            $newSeries[]=$serie;

          }

          usort($newSeries, function ($item1, $item2) {
            return $item1->first <=> $item2->first;
          });

          $groupedSeries = array();
        
          $lastGroup="";
          $actualGroupSerie=array();

          foreach($newSeries as $serie)          
        {
            if ($serie->first!=$lastGroup)
            {
              //echo "ENTRA1";
              if (count($actualGroupSerie)>0)//VIENE DE UN GRUPO ANTERIOR. LO AÑADIMOS AL MULTI GRUPO.
              {
             //   echo "ENTRA2";
                $groupedSeries[]=$actualGroupSerie;
              }
        
              //NUEVO GRUPO ORDENAR
              $lastGroup=$serie->first;
              $actualGroupSerie=array();
              $actualGroupSerie[]=$serie;
            }else //NUEVO ELEMENTO. LO AÑADIMOS AL GRUPO
            {
           //   echo "ENTRA3";
              $actualGroupSerie[]=$serie;
            }
        }


        $groupedSeries[]=$actualGroupSerie;       
        
        $groupedSeriesResult= array();
        foreach($groupedSeries as $groupedSerie)          
        {
              usort($groupedSerie, function ($item1, $item2) {
                return @$item1->second <=> @$item2->second;
              });
              foreach($groupedSerie as $serie)          
              {
                $groupedSeriesResult[]=$serie;
              }
        
        //FIN
        }


          return array("id" => 1, "items"=> $groupedSeriesResult); 
        }else
        {
          $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
          return $error;
        }
}
function getBillsPDFByUser($userId)
{
  global $mysqli;
  $queryString="SELECT DISTINCT series.serieId as serieIdText, series.*, subSeries.subSerieId as subSerieIdText,subSeries.*,bills.id as billId, bills.ownerId as isInUserPossesion,
  bills.*, CONCAT(bills.frontSerie,bills.numSerie, bills.backSerie) AS fullNumSerie,  expertReviews.*,
      countries.name as countryName, users.nickname, grades.es, grades.en FROM subSeries      
  LEFT OUTER JOIN bills ON bills.subSerieId=subSeries.id
  LEFT OUTER JOIN  series ON series.id=subSeries.serieId
   INNER JOIN countries ON series.countryId=countries.id
   LEFT OUTER JOIN expertReviews ON bills.serieId=expertReviews.serieId AND bills.subSerieId=expertReviews.subSerieId
        AND bills.frontSerie=expertReviews.frontSerie AND bills.numSerie=expertReviews.numSerie AND bills.backSerie=expertReviews.backSerie  
        INNER JOIN collectionsSeries ON series.id=collectionsSeries.serieId    
        LEFT JOIN users ON expertReviews.ownerId=users.id
        LEFT JOIN grades ON bills.grade=grades.id
  WHERE (bills.ownerId=?) AND (bills.sellActive!=2)  ORDER BY series.serieId ASC, subSeries.subSerieId ASC";
//   WHERE series.countryId=501 AND (bills.ownerId=6 OR bills.ownerId IS NULL)";
        
    //    $queryString ="SELECT series.serieId as serieIdText,series.*,subSeries.*, bills.ownerId as isInUserPossesion, countries.name as countryName FROM series       
    //    LEFT JOIN bills ON series.id = bills.serieId 
    //    LEFT JOIN subSeries as subs2 ON subs2.id=bills.subSerieId
    //    INNER JOIN countries ON series.countryId=countries.id
    //    LEFT JOIN subSeries ON series.id=subSeries.serieId
    //     WHERE series.countryId=? AND (bills.ownerId=? OR bills.ownerId IS NULL)";

    if ($stmt = $mysqli->prepare($queryString)) {
          $stmt->bind_param("i",$userId);     // Bind variables in order
          $stmt->execute();                               // Execute query    
          $results = $stmt->get_result();
        }
      $count=0;
      $myArray = array();


        while ($row = $results->fetch_array()) {  
          $myArray[]=$row;
          $count++;
        }
        if ($count>0)
        {
          $newSeries = array();
          foreach($myArray as $serie)
          {
            $serie=(object) $serie;
            preg_match_all('/([a-zA-Z]+|[0-9]+)/',$serie->serieId,$matches);
            if ($matches!=null)
            {
              if ($matches[0]!=null)
              {
                $serie->first= $matches[0][0];
          
                if (count($matches[0])>1)
                {
                  $serie->second= $matches[0][1];
                }else
                {
                  $serie->second="";
                }
              
                if (count($matches[0])>2)
                {
                  $serie->third= $matches[0][2];
                }else
                {
                  $serie->third= "";
                }
              }else
              {
                $serie->first=$serie->serieId;
              }
             
          
            }else
            {
              $serie->first=$serie->serieId;
            }
           
            $newSeries[]=$serie;

          }

          usort($newSeries, function ($item1, $item2) {
            return $item1->first <=> $item2->first;
          });

          $groupedSeries = array();
        
          $lastGroup="";
          $actualGroupSerie=array();

          foreach($newSeries as $serie)          
        {
            if ($serie->first!=$lastGroup)
            {
              //echo "ENTRA1";
              if (count($actualGroupSerie)>0)//VIENE DE UN GRUPO ANTERIOR. LO AÑADIMOS AL MULTI GRUPO.
              {
             //   echo "ENTRA2";
                $groupedSeries[]=$actualGroupSerie;
              }
        
              //NUEVO GRUPO ORDENAR
              $lastGroup=$serie->first;
              $actualGroupSerie=array();
              $actualGroupSerie[]=$serie;
            }else //NUEVO ELEMENTO. LO AÑADIMOS AL GRUPO
            {
           //   echo "ENTRA3";
              $actualGroupSerie[]=$serie;
            }
        }


        $groupedSeries[]=$actualGroupSerie;       
        
        $groupedSeriesResult= array();
        foreach($groupedSeries as $groupedSerie)          
        {
              usort($groupedSerie, function ($item1, $item2) {
                return @$item1->second <=> @$item2->second;
              });
              foreach($groupedSerie as $serie)          
              {
                $groupedSeriesResult[]=$serie;
              }
        
        //FIN
        }


          return array("id" => 1, "items"=> $groupedSeriesResult); 
        }else
        {
          $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
          return $error;
        }
}
function getBillsPDFByCountryId($countryId,$userId)
{
  global $mysqli;

/*$queryString ="SELECT DISTINCT series.serieId as serieIdText, series.*, subSeries.subSerieId as subSerieIdText,subSeries.*,bills.id as billId, bills.ownerId as isInUserPossesion,
    bills.*, CONCAT(bills.frontSerie,bills.numSerie, bills.backSerie) AS fullNumSerie,  expertReviews.*,
        countries.name as countryName, users.nickname, grades.es, grades.en FROM subSeries 
        LEFT OUTER JOIN bills ON bills.subSerieId=subSeries.id
        LEFT OUTER JOIN  series ON series.id=subSeries.serieId
        LEFT OUTER JOIN expertReviews ON bills.serieId=expertReviews.serieId AND bills.subSerieId=expertReviews.subSerieId
        AND bills.frontSerie=expertReviews.frontSerie AND bills.numSerie=expertReviews.numSerie AND bills.backSerie=expertReviews.backSerie
        INNER JOIN countries ON series.countryId=countries.id
        INNER JOIN collectionsSeries ON series.id=collectionsSeries.serieId    
        LEFT JOIN users ON expertReviews.ownerId=users.id
        LEFT JOIN grades ON bills.grade=grades.id
        WHERE collectionsSeries.collectionId=? AND (bills.ownerId=?)  AND (bills.sellActive!=2)  
          ORDER BY countries.name ASC, series.countryId ASC, serieIdText ASC, subSeries.subSerieId ASC";*/


  $queryString="SELECT DISTINCT series.serieId as serieIdText, series.*, subSeries.subSerieId as subSerieIdText,subSeries.*,bills.id as billId, bills.ownerId as isInUserPossesion,
  bills.*, CONCAT(bills.frontSerie,bills.numSerie, bills.backSerie) AS fullNumSerie,  expertReviews.*,
      countries.name as countryName, users.nickname, grades.es, grades.en FROM subSeries      
  LEFT OUTER JOIN bills ON bills.subSerieId=subSeries.id
  LEFT OUTER JOIN  series ON series.id=subSeries.serieId
   INNER JOIN countries ON series.countryId=countries.id
   LEFT OUTER JOIN expertReviews ON bills.serieId=expertReviews.serieId AND bills.subSerieId=expertReviews.subSerieId
        AND bills.frontSerie=expertReviews.frontSerie AND bills.numSerie=expertReviews.numSerie AND bills.backSerie=expertReviews.backSerie  
        INNER JOIN collectionsSeries ON series.id=collectionsSeries.serieId    
        LEFT JOIN users ON expertReviews.ownerId=users.id
        LEFT JOIN grades ON bills.grade=grades.id
  WHERE series.countryId=? AND (bills.ownerId=?) AND (bills.sellActive!=2)  ORDER BY series.serieId ASC, subSeries.subSerieId ASC";
//   WHERE series.countryId=501 AND (bills.ownerId=6 OR bills.ownerId IS NULL)";
        
    //    $queryString ="SELECT series.serieId as serieIdText,series.*,subSeries.*, bills.ownerId as isInUserPossesion, countries.name as countryName FROM series       
    //    LEFT JOIN bills ON series.id = bills.serieId 
    //    LEFT JOIN subSeries as subs2 ON subs2.id=bills.subSerieId
    //    INNER JOIN countries ON series.countryId=countries.id
    //    LEFT JOIN subSeries ON series.id=subSeries.serieId
    //     WHERE series.countryId=? AND (bills.ownerId=? OR bills.ownerId IS NULL)";

    if ($stmt = $mysqli->prepare($queryString)) {
          $stmt->bind_param("ii", $countryId,$userId);     // Bind variables in order
          $stmt->execute();                               // Execute query    
          $results = $stmt->get_result();
        }
      $count=0;
      $myArray = array();


        while ($row = $results->fetch_array()) {  
          $myArray[]=$row;
          $count++;
        }
        if ($count>0)
        {
          $newSeries = array();
          foreach($myArray as $serie)
          {
            $serie=(object) $serie;
            preg_match_all('/([a-zA-Z]+|[0-9]+)/',$serie->serieId,$matches);
            if ($matches!=null)
            {
              if ($matches[0]!=null)
              {
                $serie->first= $matches[0][0];
          
                if (count($matches[0])>1)
                {
                  $serie->second= $matches[0][1];
                }else
                {
                  $serie->second="";
                }
              
                if (count($matches[0])>2)
                {
                  $serie->third= $matches[0][2];
                }else
                {
                  $serie->third= "";
                }
              }else
              {
                $serie->first=$serie->serieId;
              }
             
          
            }else
            {
              $serie->first=$serie->serieId;
            }
           
            $newSeries[]=$serie;

          }

          usort($newSeries, function ($item1, $item2) {
            return $item1->first <=> $item2->first;
          });

          $groupedSeries = array();
        
          $lastGroup="";
          $actualGroupSerie=array();

          foreach($newSeries as $serie)          
        {
            if ($serie->first!=$lastGroup)
            {
              //echo "ENTRA1";
              if (count($actualGroupSerie)>0)//VIENE DE UN GRUPO ANTERIOR. LO AÑADIMOS AL MULTI GRUPO.
              {
             //   echo "ENTRA2";
                $groupedSeries[]=$actualGroupSerie;
              }
        
              //NUEVO GRUPO ORDENAR
              $lastGroup=$serie->first;
              $actualGroupSerie=array();
              $actualGroupSerie[]=$serie;
            }else //NUEVO ELEMENTO. LO AÑADIMOS AL GRUPO
            {
           //   echo "ENTRA3";
              $actualGroupSerie[]=$serie;
            }
        }


        $groupedSeries[]=$actualGroupSerie;       
        
        $groupedSeriesResult= array();
        foreach($groupedSeries as $groupedSerie)          
        {
              usort($groupedSerie, function ($item1, $item2) {
                return @$item1->second <=> @$item2->second;
              });
              foreach($groupedSerie as $serie)          
              {
                $groupedSeriesResult[]=$serie;
              }
        
        //FIN
        }


          return array("id" => 1, "items"=> $groupedSeriesResult); 
        }else
        {
          $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
          return $error;
        }
}
function getBillsPDFByCollectionId($collectionId,$userId)
{
  global $mysqli;
      
   
      /*  $queryString ="SELECT DISTINCT series.serieId as serieIdText, series.*,subSeries.*,MAX(bills.id) as billId, bills.ownerId as isInUserPossesion, 
  
        countries.name as countryName FROM subSeries 
        LEFT OUTER JOIN bills ON bills.subSerieId=subSeries.id
        LEFT OUTER JOIN  series ON series.id=subSeries.serieId
        INNER JOIN countries ON series.countryId=countries.id
        INNER JOIN collectionsSeries ON series.id=collectionsSeries.serieId    
        WHERE collectionsSeries.collectionId=? AND (bills.ownerId=?)
        GROUP BY series.id, series.serieId, series.countryId, series.billValue, series.issuer,
         series.dateText, series.initYear, series.endYear, series.printer, series.overPrinter, 
         series.extraData, series.imageData1, series.imageData2, series.originalUrl, series.subSeries,
         subSeries.id, subSeries.serieId,subSeries.subSerieId,subSeries.remark, countries.name, bills.id,
          bills.ownerId, bills.countryId, bills.serieId, bills.subSerieId, bills.grade, bills.frontSerie, 
          bills.numSerie, bills.backSerie, bills.purchasePrice, bills.sellerId, bills.purchaseDate, bills.soldDate, 
          bills.publicNotes, bills.privateNotes, bills.sellPrice, bills.sellActive, bills.restored, bills.errorNote,
           bills.replacement, bills.specimen, bills.proof, bills.billYear, bills.falseBill, bills.managingFor,serieIdText,isInUserPossesion,countryName
          ORDER BY countries.name ASC, series.countryId ASC, serieIdText ASC, subSeries.subSerieId ASC";
*/
   $queryString ="SELECT DISTINCT series.serieId as serieIdText, series.*, subSeries.subSerieId as subSerieIdText,subSeries.*,bills.id as billId, bills.ownerId as isInUserPossesion,
    bills.*, CONCAT(bills.frontSerie,bills.numSerie, bills.backSerie) AS fullNumSerie,  expertReviews.*,
        countries.name as countryName, users.nickname, grades.es, grades.en FROM subSeries 
        LEFT OUTER JOIN bills ON bills.subSerieId=subSeries.id
        LEFT OUTER JOIN  series ON series.id=subSeries.serieId
        LEFT OUTER JOIN expertReviews ON bills.serieId=expertReviews.serieId AND bills.subSerieId=expertReviews.subSerieId
        AND bills.frontSerie=expertReviews.frontSerie AND bills.numSerie=expertReviews.numSerie AND bills.backSerie=expertReviews.backSerie
        INNER JOIN countries ON series.countryId=countries.id
        INNER JOIN collectionsSeries ON series.id=collectionsSeries.serieId    
        LEFT JOIN users ON expertReviews.ownerId=users.id
        LEFT JOIN grades ON bills.grade=grades.id
        WHERE collectionsSeries.collectionId=? AND (bills.ownerId=?)  AND (bills.sellActive!=2)  
          ORDER BY countries.name ASC, series.countryId ASC, serieIdText ASC, subSeries.subSerieId ASC";

//        INNER JOIN collectionsSeries ON series.id=collectionsSeries.serieId     
  //      LEFT OUTER JOIN bills ON series.id = bills.serieId
    //    INNER JOIN countries ON series.countryId=countries.id
      //  LEFT OUTER JOIN subSeries ON series.id=subSeries.serieId
        // WHERE collectionsSeries.collectionId=? AND (bills.ownerId=? OR bills.ownerId IS NULL)  ORDER BY series.serieId ASC, subSeries.subSerieId ASC";

    if ($stmt = $mysqli->prepare($queryString)) {
          $stmt->bind_param("ii", $collectionId,$userId);     // Bind variables in order
          $stmt->execute();                               // Execute query    
          $results = $stmt->get_result();
        }
      $count=0;
      $myArray = array();
        while ($row = $results->fetch_array()) {  
          $myArray[]=$row;
          $count++;
        }
        if ($count>0)
        {
          $newSeries = array();
          $countries = array();
          $actualCountry= array();
          $lastCountry="";
          $auxCount=0;
          foreach($myArray as $serie)
          {
            $serie=(object) $serie;

            
            if ($serie->countryName==$lastCountry)
            {
              array_push($actualCountry,$serie);
            }else
            {
              if ($auxCount>0)
              {
                array_push($countries,$actualCountry);              
              }
                
              $actualCountry = (array) null;
              $actualCountry= array();
              array_push($actualCountry,$serie);
            }
            $auxCount++;
            $lastCountry=$serie->countryName;
          }
          array_push($countries,$actualCountry);     
       //   var_dump($countries);
        //  die();
          $groupedSeriesResult= array();
          $OrderedCountries = array();
          $groupedSeries = array();   
          foreach($countries as $countryArray)
          {
                          foreach($countryArray as $countrySerie)
                          {
                            preg_match_all('/([a-zA-Z]+|[0-9]+)/',$countrySerie->serieIdText,$matches);
                            if ($matches!=null)
                            {
                              if ($matches[0]!=null)
                              {
                                $countrySerie->first= $matches[0][0];
                          
                                if (count($matches[0])>1)
                                {
                                  $countrySerie->second= $matches[0][1];
                                }else
                                {
                                  $countrySerie->second="";
                                }
                              
                                if (count($matches[0])>2)
                                {
                                  $countrySerie->third= $matches[0][2];
                                }else
                                {
                                  $countrySerie->third= "";
                                }
                              }else
                              {
                                $countrySerie->first=$countrySerie->serieIdText;
                              }
                            
                          
                            }else
                            {
                              $countrySerie->first=$countrySerie->serieIdText;
                            }
                          
                            $newSeries[]=$countrySerie;
                
                          }
  
                          usort($newSeries, function ($item1, $item2) {
                            return $item1->first <=> $item2->first;
                          });
                      

                             
                          $lastGroup="";
                          $actualGroupSerie=array();
                          foreach($newSeries as $serie)          
                          {
                              if ($serie->first!=$lastGroup)
                              {
                                //echo "ENTRA1";
                                if (count($actualGroupSerie)>0)//VIENE DE UN GRUPO ANTERIOR. LO AÑADIMOS AL MULTI GRUPO.
                                {
                              //   echo "ENTRA2";
                                  $groupedSeries[]=$actualGroupSerie;
                                }
                          
                                //NUEVO GRUPO ORDENAR
                                $lastGroup=$serie->first;
                                $actualGroupSerie=array();
                                $actualGroupSerie[]=$serie;
                              }else //NUEVO ELEMENTO. LO AÑADIMOS AL GRUPO
                              {
                            //   echo "ENTRA3";
                                $actualGroupSerie[]=$serie;
                              }
                          }
                    $groupedSeries[]=$actualGroupSerie;       
                    foreach($groupedSeries as $groupedSerie)          
                    {
                              usort($groupedSerie, function ($item1, $item2) {
                                return $item1->second <=> $item2->second;
                              });
                              foreach($groupedSerie as $serie)          
                              {
                                $groupedSeriesResult[]=$serie;
                              }
                    }
          }
     

          $newSeries = array();
          $countries = array();
          $actualCountry= array();
          $lastCountry="";
          $auxCount=0;
          foreach($groupedSeriesResult as $serie)
          {
            $serie=(object) $serie;

            
            if ($serie->countryName==$lastCountry)
            {
              array_push($actualCountry,$serie);
            }else
            {
              if ($auxCount>0)
              {
                array_push($countries,$actualCountry);              
              }
                
              $actualCountry = (array) null;
              $actualCountry= array();
              array_push($actualCountry,$serie);
            }
            $auxCount++;
            $lastCountry=$serie->countryName;
          }
          array_push($countries,$actualCountry);     
         
          $groupedSeriesResult=array();
          $lastCountry="";
          $auxCount=0;
          $allIsDone=false;
          foreach($countries as $countryArray)
          {
                          foreach($countryArray as $serie)
                          {
                            $serie->isDone=false;
                          }
             }


          do{

            $allIsDoneCount=0;
            foreach($countries as $countryArray)
            {
                            foreach($countryArray as $serie)
                            {
                              if (!$serie->isDone)
                              {
                                if ($auxCount==0)
                                {
                                  array_push($groupedSeriesResult,$serie); 
                                  $allIsDoneCount++; 
                                  $lastCountry=$serie->countryName;
                                  $serie->isDone=true;
                                }else
                                {
                                  if ($lastCountry==$serie->countryName)
                                  {
                                    $allIsDoneCount++;
                                    array_push($groupedSeriesResult,$serie); 
                                    $serie->isDone=true;
                                  }else
                                  {
                                    $serie->isDone=false;
                                  }
                                }
                              }
                            }
            }



            if ($allIsDoneCount==0)
            {
              $allIsDone=true;
            }
            
          }while(!$allIsDone);

      
         
     
          


          return array("id" => 1, "items"=> $groupedSeriesResult);//, "items2"=> $myArray); 
        }else
        {
          $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
          return $error;
        }
}
function getSeriesByCollectionId($collectionId,$userId)
{
  global $mysqli;
      
   

  $queryString="SELECT DISTINCT series.serieId as serieIdText,series.*, subSeries.subSerieId, bills.ownerId as isInUserPossesion, countries.name as countryName FROM subSeries           
  LEFT OUTER JOIN bills ON bills.subSerieId=subSeries.id
  LEFT OUTER JOIN  series ON series.id=subSeries.serieId
   INNER JOIN countries ON series.countryId=countries.id
  WHERE series.countryId=? AND (bills.ownerId=? OR bills.ownerId IS NULL) ORDER BY series.serieId ASC, subSeries.subSerieId ASC";


        $queryString ="SELECT DISTINCT series.serieId as serieIdText, series.*,subSeries.*, bills.ownerId as isInUserPossesion, countries.name as countryName FROM subSeries 
        LEFT OUTER JOIN bills ON bills.subSerieId=subSeries.id
        LEFT OUTER JOIN  series ON series.id=subSeries.serieId
        INNER JOIN countries ON series.countryId=countries.id
        INNER JOIN collectionsSeries ON series.id=collectionsSeries.serieId    
        WHERE collectionsSeries.collectionId=? AND (bills.ownerId=? OR bills.ownerId IS NULL)  ORDER BY countries.name ASC, series.countryId ASC, serieIdText ASC, subSeries.subSerieId ASC";


//        INNER JOIN collectionsSeries ON series.id=collectionsSeries.serieId     
  //      LEFT OUTER JOIN bills ON series.id = bills.serieId
    //    INNER JOIN countries ON series.countryId=countries.id
      //  LEFT OUTER JOIN subSeries ON series.id=subSeries.serieId
        // WHERE collectionsSeries.collectionId=? AND (bills.ownerId=? OR bills.ownerId IS NULL)  ORDER BY series.serieId ASC, subSeries.subSerieId ASC";

    if ($stmt = $mysqli->prepare($queryString)) {
          $stmt->bind_param("ii", $collectionId,$userId);     // Bind variables in order
          $stmt->execute();                               // Execute query    
          $results = $stmt->get_result();
        }
      $count=0;
      $myArray = array();
        while ($row = $results->fetch_array()) {  
          $myArray[]=$row;
          $count++;
        }
        if ($count>0)
        {
          $newSeries = array();
          $countries = array();
          $actualCountry= array();
          $lastCountry="";
          $auxCount=0;
          foreach($myArray as $serie)
          {
            $serie=(object) $serie;

            
            if ($serie->countryName==$lastCountry)
            {
              array_push($actualCountry,$serie);
            }else
            {
              if ($auxCount>0)
              {
                array_push($countries,$actualCountry);              
              }
                
              $actualCountry = (array) null;
              $actualCountry= array();
              array_push($actualCountry,$serie);
            }
            $auxCount++;
            $lastCountry=$serie->countryName;
          }
          array_push($countries,$actualCountry);     
       //   var_dump($countries);
        //  die();
          $groupedSeriesResult= array();
          $OrderedCountries = array();
          $groupedSeries = array();   
          foreach($countries as $countryArray)
          {
                          foreach($countryArray as $countrySerie)
                          {
                            preg_match_all('/([a-zA-Z]+|[0-9]+)/',$countrySerie->serieIdText,$matches);
                            if ($matches!=null)
                            {
                              if ($matches[0]!=null)
                              {
                                $countrySerie->first= $matches[0][0];
                          
                                if (count($matches[0])>1)
                                {
                                  $countrySerie->second= $matches[0][1];
                                }else
                                {
                                  $countrySerie->second="";
                                }
                              
                                if (count($matches[0])>2)
                                {
                                  $countrySerie->third= $matches[0][2];
                                }else
                                {
                                  $countrySerie->third= "";
                                }
                              }else
                              {
                                $countrySerie->first=$countrySerie->serieIdText;
                              }
                            
                          
                            }else
                            {
                              $countrySerie->first=$countrySerie->serieIdText;
                            }
                          
                            $newSeries[]=$countrySerie;
                
                          }
  
                          usort($newSeries, function ($item1, $item2) {
                            return $item1->first <=> $item2->first;
                          });
                      

                             
                          $lastGroup="";
                          $actualGroupSerie=array();
                          foreach($newSeries as $serie)          
                          {
                              if ($serie->first!=$lastGroup)
                              {
                                //echo "ENTRA1";
                                if (count($actualGroupSerie)>0)//VIENE DE UN GRUPO ANTERIOR. LO AÑADIMOS AL MULTI GRUPO.
                                {
                              //   echo "ENTRA2";
                                  $groupedSeries[]=$actualGroupSerie;
                                }
                          
                                //NUEVO GRUPO ORDENAR
                                $lastGroup=$serie->first;
                                $actualGroupSerie=array();
                                $actualGroupSerie[]=$serie;
                              }else //NUEVO ELEMENTO. LO AÑADIMOS AL GRUPO
                              {
                            //   echo "ENTRA3";
                                $actualGroupSerie[]=$serie;
                              }
                          }
                    $groupedSeries[]=$actualGroupSerie;       
                    foreach($groupedSeries as $groupedSerie)          
                    {
                              usort($groupedSerie, function ($item1, $item2) {
                                return $item1->second <=> $item2->second;
                              });
                              foreach($groupedSerie as $serie)          
                              {
                                $groupedSeriesResult[]=$serie;
                              }
                    }
          }
     

          $newSeries = array();
          $countries = array();
          $actualCountry= array();
          $lastCountry="";
          $auxCount=0;
          foreach($groupedSeriesResult as $serie)
          {
            $serie=(object) $serie;

            
            if ($serie->countryName==$lastCountry)
            {
              array_push($actualCountry,$serie);
            }else
            {
              if ($auxCount>0)
              {
                array_push($countries,$actualCountry);              
              }
                
              $actualCountry = (array) null;
              $actualCountry= array();
              array_push($actualCountry,$serie);
            }
            $auxCount++;
            $lastCountry=$serie->countryName;
          }
          array_push($countries,$actualCountry);     
         
          $groupedSeriesResult=array();
          $lastCountry="";
          $auxCount=0;
          $allIsDone=false;
          foreach($countries as $countryArray)
          {
                          foreach($countryArray as $serie)
                          {
                            $serie->isDone=false;
                          }
             }


          do{

            $allIsDoneCount=0;
            foreach($countries as $countryArray)
            {
                            foreach($countryArray as $serie)
                            {
                              if (!$serie->isDone)
                              {
                                if ($auxCount==0)
                                {
                                  array_push($groupedSeriesResult,$serie); 
                                  $allIsDoneCount++; 
                                  $lastCountry=$serie->countryName;
                                  $serie->isDone=true;
                                }else
                                {
                                  if ($lastCountry==$serie->countryName)
                                  {
                                    $allIsDoneCount++;
                                    array_push($groupedSeriesResult,$serie); 
                                    $serie->isDone=true;
                                  }else
                                  {
                                    $serie->isDone=false;
                                  }
                                }
                              }
                            }
            }



            if ($allIsDoneCount==0)
            {
              $allIsDone=true;
            }
            
          }while(!$allIsDone);

      
         
     
          


          return array("id" => 1, "items"=> $groupedSeriesResult);//, "items2"=> $myArray); 
        }else
        {
          $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
          return $error;
        }
}
function getSerieRealIdByIdAndCountryId($serieId,$countryId)
{
global $mysqli;

    $queryString= "SELECT * FROM series WHERE  serieId=? AND countryId=?"; 
    
if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->bind_param("si", $serieId,$countryId);     // Bind variables in order
      $stmt->execute();                               // Execute query    
      $results = $stmt->get_result();
    }
 
$count=0;
$myArray = array();
    while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
    }
  
if ($count>0)
{
  return intval($myArray[0][0]);
}else
	{
		
    return -1;
	}
    
 
}

function getSerieById($id)
{
global $mysqli;

    $queryString= "SELECT series.*, countries.name as countryName, continents.name as continentName
     FROM series INNER JOIN countries ON series.countryId=countries.id 
                 INNER JOIN continents ON countries.continentId=continents.id 
                 WHERE  series.id=?";  
//echo "SELECT series.* FROM series INNER JOIN countries ON series.countryId=countries.id WHERE  series.serieId=$serieId AND countries.canonical=$countryCanonical";      

//echo $queryString;
    if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->bind_param("i", $id);     // Bind variables in order
      $stmt->execute();                               // Execute query    
      $results = $stmt->get_result();
    }
$count=0;
$myArray = array();
    while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
    }
    if ($count>0)
    {
	
      return array("id" =>$id, "item"=> $myArray[0]);
     
    } 
    $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
    return $error;
 
 
}
function getSerieByIdAndCountry($serieId,$countryCanonical)
{
global $mysqli;

    $queryString= "SELECT series.*, countries.name as countryName, continents.name as continentName
     FROM series INNER JOIN countries ON series.countryId=countries.id 
                 INNER JOIN continents ON countries.continentId=continents.id 
                 WHERE  series.serieId=? AND countries.canonical=?";  
//echo "SELECT series.* FROM series INNER JOIN countries ON series.countryId=countries.id WHERE  series.serieId=$serieId AND countries.canonical=$countryCanonical";      

    if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->bind_param("ss", $serieId,$countryCanonical);     // Bind variables in order
      $stmt->execute();                               // Execute query    
      $results = $stmt->get_result();
    }
$count=0;
$myArray = array();
    while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
    }
    if ($count>0)
    {
  	  $queryString= "SELECT * FROM subSeries WHERE serieId=?";
      if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->bind_param("i", $myArray[0][0]);     // Bind variables in order
      $stmt->execute();                               // Execute query    
      $results = $stmt->get_result();
    }
	$myarraySubSeries = array();
    while ($row = $results->fetch_array()) {  
      $myarraySubSeries[]=$row;
    }

      return array("id" =>$myArray[0][0], "item"=> $myArray[0] , "subSeries"=> $myarraySubSeries);
     
    }else
	{
		$error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
    return $error;
	}
    
 
}
function getSubSeriesBySerie($id)
{
  global $mysqli;

  $queryString= "SELECT subSeries.* FROM subSeries 
    WHERE subSeries.serieId=? ORDER BY subSerieId ASC";
  
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("i", $id);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
$count=0;
$myArray = array();
  while ($row = $results->fetch_array()) {  
    $myArray[]=$row;
    $count++;
  }
  if ($count>0)
  {
    return array("id" => 1, "items"=> $myArray);   
  } 
  $error = array("id" => -1, "message" => "No hay datos con esa coleccion. Err: " . $mysqli->error);
  return $error;  
}
function getSubSeriesByCollection($id)
{
  global $mysqli;

  $queryString= "SELECT subSeries.id, subSeries.subSerieId, series.serieId, countries.name as country FROM subSeries
  INNER JOIN series ON subSeries.serieId=series.id
  INNER JOIN countries ON countries.id=series.countryId
  INNER JOIN collectionsSubSeries ON subSeries.id= collectionsSubSeries.subSerieId 
  INNER JOIN collections ON collectionsSubSeries.collectionId=collections.id  WHERE collections.id=?";
  
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("i", $id);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
$count=0;
$myArray = array();
  while ($row = $results->fetch_array()) {  
    $myArray[]=$row;
    $count++;
  }
  if ($count>0)
  {
    return array("id" => 1, "items"=> $myArray);   
  } 
  $error = array("id" => -1, "message" => "No hay datos con esa coleccion. Err: " . $mysqli->error);
  return $error;  
}
function getSeriesByCollection($id)
{  
  global $mysqli;

  $queryString= "SELECT series.id, series.serieId, countries.name as country FROM series 
  INNER JOIN countries ON countries.id=series.countryId
  INNER JOIN collectionsSeries ON series.id= collectionsSeries.serieId 
  INNER JOIN collections ON collectionsSeries.collectionId=collections.id  WHERE collections.id=?";
  
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("i", $id);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
$count=0;
$myArray = array();
  while ($row = $results->fetch_array()) {  
    $myArray[]=$row;
    $count++;
  }
  if ($count>0)
  {

    return array("id" => 1, "items"=> $myArray);
   
  } 
  $error = array("id" => -1, "message" => "No hay datos con esa coleccion. Err: " . $mysqli->error);
  return $error;  
}
function getSeriesAndSubSeriesByCountry($countryId)
{
  global $mysqli;

  $queryString= "SELECT series.id, series.serieId, subSeries.id as id2, subSeries.subSerieId FROM series LEFT JOIN subSeries ON series.id = subSeries.serieId WHERE series.countryId=?";
  
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("i", $countryId);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
$count=0;
$myArray = array();
  while ($row = $results->fetch_array()) {  
    $myArray[]=$row;
    $count++;
  }
  if ($count>0)
  {

    return array("id" => 1, "items"=> $myArray);
   
  } 
  $error = array("id" => -1, "message" => "No hay datos con ese canonical. Err: " . $mysqli->error);
  return $error;  
}
function removeSerieFromCollection($serieId,$id)
{
  global $mysqli;
    $queryString= "DELETE FROM collectionsSeries WHERE collectionId=" . $id . " AND serieId=" . $serieId; 
    $mysqli->query($queryString);
    //echo $queryString;
    $affectedRows=$mysqli->affected_rows;
    if ($affectedRows>0)
    {
        $myArray = array("id" => 1, "message" => "Se ha eliminado correctamente.");
        return $myArray;
    }else
    {
        $myArray = array("id" => -1, "message" => "Error al eliminar la serie de la coleccion en la base de datos. Err: " . $mysqli->error);
        return $myArray;
    }
}
function removeSubSerieFromCollection($subSerieId,$id)
{
  global $mysqli;
    $queryString= "DELETE FROM collectionsSubSeries WHERE collectionId=" . $id . " AND subSerieId=" . $subSerieId; 
    $mysqli->query($queryString);
    //echo $queryString;
    $affectedRows=$mysqli->affected_rows;
    if ($affectedRows>0)
    {
        $myArray = array("id" => 1, "message" => "Se ha eliminado correctamente.");
        return $myArray;
    }else
    {
        $myArray = array("id" => -1, "message" => "Error al eliminar la sub serie de la coleccion en la base de datos. Err: " . $mysqli->error);
        return $myArray;
    }
}
function  getCollectionById($id)
{  
  global $mysqli;
  

    $queryString= "SELECT collections.*,  COALESCE(users.name,'banknotescollection') as createdBy  FROM collections  LEFT JOIN users  ON collections.ownerId=users.id WHERE collections.id=" . $id;
  

if ($stmt = $mysqli->prepare($queryString)) {
   $stmt->execute();                               // Execute query
  $results = $stmt->get_result();
}

  $count=0;
 $myArray = array();
  while ($row = $results->fetch_array()) {
    $myArray[]=$row;
     $count++;
  }
  if($count>0)
  {        
   
   return array("id" => $id , "item"=> $myArray[0]);
  } 
  
  $error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> [], "count" => 0);
  return $error;

}
function getPrinters()
{
  global $mysqli;
  

  $queryString= "SELECT DISTINCT printer from series ORDER BY printer ASC";
//   echo $queryString;
if ($stmt = $mysqli->prepare($queryString)) {

$stmt->execute();                               // Execute query
$results = $stmt->get_result();
}

$count=0;
$myArray = array();
while ($row = $results->fetch_array()) {
  $myArray[]=$row;
   $count++;
}

if($count>0)
{        
 
 return array("count" => $count , "items"=> $myArray);
} 

$error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> [], "count" => 0);
return $error;
  
}
function getIssuers()
{
  global $mysqli;
  

  $queryString= "SELECT DISTINCT issuer from series ORDER BY issuer ASC";
//   echo $queryString;
if ($stmt = $mysqli->prepare($queryString)) {

$stmt->execute();                               // Execute query
$results = $stmt->get_result();
}

$count=0;
$myArray = array();
while ($row = $results->fetch_array()) {
  $myArray[]=$row;
   $count++;
}

if($count>0)
{        
 
 return array("count" => $count , "items"=> $myArray);
} 

$error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> [], "count" => 0);
return $error;
  

}

function getCountriesByExpertOwnerId($ownerId)
{  
  global $mysqli;
  

  $queryString= "SELECT DISTINCT countries.id, countries.name, countries.canonical FROM countries 
   INNER JOIN expertReviews ON countries.id=expertReviews.countryId WHERE expertReviews.ownerId=?  ORDER BY name ASC";
if ($stmt = $mysqli->prepare($queryString)) {
  $stmt->bind_param("i", $ownerId );     // Bind variables in order
  $stmt->execute();    
                               // Execute query
        $results = $stmt->get_result();
}

$count=0;
$myArray = array();
while ($row = $results->fetch_array()) {
  $myArray[]=$row;
   $count++;
}

if($count>0)
{        
 
 return array("count" => $count , "items"=> $myArray);
} 

$error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> [], "count" => 0);
return $error;
}
function getCountriesByOwnerId($ownerId)
{  
  global $mysqli;
  

  $queryString= "SELECT countries.id, countries.name, countries.canonical, COUNT(bills.id) as billCount FROM countries 
   INNER JOIN bills ON countries.id=bills.countryId WHERE bills.ownerId=? AND bills.sellActive<>2 GROUP BY countries.id, countries.name, countries.canonical ORDER BY name ASC";
if ($stmt = $mysqli->prepare($queryString)) {
  $stmt->bind_param("i", $ownerId );     // Bind variables in order
  $stmt->execute();    
                               // Execute query
        $results = $stmt->get_result();
}

$count=0;
$myArray = array();
while ($row = $results->fetch_array()) {
  $myArray[]=$row;
   $count++;
}

if($count>0)
{        
 
 return array("count" => $count , "items"=> $myArray);
} 

$error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> [], "count" => 0);
return $error;
}
function getCountriesOnSale()
{  
  global $mysqli;
  

  $queryString= "SELECT countries.id, countries.name, countries.canonical, COUNT(bills.id) as billCount FROM countries  INNER JOIN bills ON countries.id=bills.countryId WHERE bills.sellActive=1 GROUP BY countries.id, countries.name, countries.canonical ORDER BY name ASC";
if ($stmt = $mysqli->prepare($queryString)) {
        $stmt->execute();                               // Execute query
        $results = $stmt->get_result();
}

$count=0;
$myArray = array();
while ($row = $results->fetch_array()) {
  $myArray[]=$row;
   $count++;
}

if($count>0)
{        
 
 return array("count" => $count , "items"=> $myArray);
} 

$error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> [], "count" => 0);
return $error;
}
function getCountries()
{
  global $mysqli;
  

    $queryString= "SELECT * FROM countries ORDER BY name ASC";
 //   echo $queryString;
if ($stmt = $mysqli->prepare($queryString)) {
  
  $stmt->execute();                               // Execute query
  $results = $stmt->get_result();
}

  $count=0;
 $myArray = array();
  while ($row = $results->fetch_array()) {
    $myArray[]=$row;
     $count++;
  }

  if($count>0)
  {        
   
   return array("count" => $count , "items"=> $myArray);
  } 
  
  $error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> [], "count" => 0);
  return $error;
}
function getMyOtherCollectionsByOwner($ownerId)
{
  global $mysqli;
  //$queryString= "SELECT collections.*,users.name as createdBy FROM collections 
   // INNER JOIN usersCollections ON collections.id=usersCollections.collectionId
    //INNER JOIN users ON usersCollections.userId=users.id  WHERE usersCollections.userId=?";
    //SELECT collections.*,users.name as createdBy FROM collections LEFT JOIN usersCollections ON collections.id=usersCollections.collectionId LEFT JOIN users ON usersCollections.userId=users.id WHERE usersCollections.userId=6 OR collections.ownerId=6
    $queryString= "SELECT collections.*,users.name as createdBy FROM collections 
    INNER JOIN usersCollections ON collections.id=usersCollections.collectionId
    INNER JOIN users ON usersCollections.userId=users.id  WHERE usersCollections.userId=?";
 //   echo $queryString;
if ($stmt = $mysqli->prepare($queryString)) {
  $stmt->bind_param("i", $ownerId );     // Bind variables in order
  $stmt->execute();                               // Execute query
  $results = $stmt->get_result();
}

  $count=0;
 $myArray = array();
  while ($row = $results->fetch_array()) {
    $myArray[]=$row;
     $count++;
  }


  



  $queryString= "SELECT countries.*, 'banknotescollection' as createdBy FROM countries 
  INNER JOIN usersCountriesCollections ON countries.id=usersCountriesCollections.countryId
  INNER JOIN users ON usersCountriesCollections.userId=users.id  WHERE usersCountriesCollections.userId=?";
//   echo $queryString;
if ($stmt = $mysqli->prepare($queryString)) {
$stmt->bind_param("i", $ownerId );     // Bind variables in order
$stmt->execute();                               // Execute query
$results = $stmt->get_result();
}

$myArray2 = array();
while ($row = $results->fetch_array()) {
  $myArray2[]=$row;
   $count++;
}
  if($count>0)
  {        
   
   return array("count" => $count , "items"=> $myArray, "items2"=>$myArray2);
  } 
  
  $error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> [], "items2"=> [], "count" => 0);
  return $error;
}
function getCollectionsByOwner($ownerId)
{
  global $mysqli;
  

    $queryString= "SELECT collections.*  FROM collections  WHERE ownerId=?";
    
if ($stmt = $mysqli->prepare($queryString)) {
  $stmt->bind_param("i", $ownerId );     // Bind variables in order
  $stmt->execute();                               // Execute query
  $results = $stmt->get_result();
}

  $count=0;
 $myArray = array();
  while ($row = $results->fetch_array()) {
    $myArray[]=$row;
     $count++;
  }
  if($count>0)
  {        
   
   return array("count" => $count , "items"=> $myArray);
  } 
  
  $error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> [], "count" => 0);
  return $error;
}function getBougthBillsByUser($userId,$limit,$start)
{
  global $mysqli;

  $queryString= "SELECT ALLBILLS.id, ALLBILLS.grade, ALLBILLS.frontSerie, ALLBILLS.numSerie, ALLBILLS.backSerie, ALLBILLS.sellPrice, ALLBILLS.sellActive,ALLBILLS.purchasePrice,
  ALLBILLS.restored, ALLBILLS.errorNote,ALLBILLS.replacement, ALLBILLS.specimen, ALLBILLS.proof, ALLBILLS.publicNotes,ALLBILLS.purchaseDate, ALLBILLS.soldDate,
   series.serieId, series.billValue, series.dateText, series.printer,
  subSeries.subSerieId,  countries.name, series.id as realSerieId, subSeries.id as realSubSerieId, grades.es, grades.en, users.nickname FROM ALLBILLS 
  LEFT JOIN series ON ALLBILLS.serieId=series.id 
  LEFT JOIN subSeries ON ALLBILLS.subSerieId=subSeries.id 
  LEFT JOIN countries ON ALLBILLS.countryId=countries.id
  LEFT JOIN grades ON ALLBILLS.grade=grades.id
  LEFT JOIN users ON ALLBILLS.ownerId=users.id
  WHERE ALLBILLS.ownerId=? AND ALLBILLS.purchasePrice>0";
  $queryString2= "SELECT COUNT(id) FROM ALLBILLS WHERE ownerId=?";

$queryString= $queryString . " ORDER BY id DESC LIMIT ?,?";
//echo $queryString2 . "--FIN";
if ($stmt = $mysqli->prepare($queryString2)) { 
  $stmt->bind_param("i",$userId );
  $stmt->execute();      // Execute query   
$resultsCount = $stmt->get_result();
}  
$countRow = $resultsCount->fetch_row(); 
if ($stmt = $mysqli->prepare($queryString)) {
$stmt->bind_param("iii",$userId, $start,$limit );     // Bind variables in order
$stmt->execute();                               // Execute query
$results = $stmt->get_result();
}

$count=0;
$myArray = array();
while ($row = $results->fetch_array()) {
  $myArray[]=$row;
   $count++;
}
if
 ($countRow[0]>0)
{        
 
 return array("id" => $countRow[0] , "items"=> $myArray);
} 

$error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> [], "count" => 0);
return $error;

}
function getSoldBillsByUser($userId,$limit,$start)
{
  global $mysqli;

  $queryString= "SELECT billsOld.id, billsOld.grade, billsOld.frontSerie, billsOld.numSerie, billsOld.backSerie, billsOld.sellPrice, billsOld.sellActive,
  billsOld.restored, billsOld.errorNote,billsOld.replacement, billsOld.specimen, billsOld.proof, billsOld.publicNotes, billsOld.purchasePrice, billsOld.purchaseDate, billsOld.soldDate,
   series.serieId, series.billValue, series.dateText, series.printer,
  subSeries.subSerieId,  countries.name, series.id as realSerieId, subSeries.id as realSubSerieId, grades.es, grades.en, users.nickname FROM billsOld 
  LEFT JOIN series ON billsOld.serieId=series.id 
  LEFT JOIN subSeries ON billsOld.subSerieId=subSeries.id 
  LEFT JOIN countries ON billsOld.countryId=countries.id
  LEFT JOIN grades ON billsOld.grade=grades.id
  LEFT JOIN users ON billsOld.ownerId=users.id
  WHERE billsOld.ownerId=?";
  $queryString2= "SELECT COUNT(id) FROM billsOld WHERE ownerId=?";

$queryString= $queryString . " ORDER BY purchaseDAte DESC LIMIT ?,?";
//echo $queryString . "--FIN";
if ($stmt = $mysqli->prepare($queryString2)) { 
  $stmt->bind_param("i",$userId );
  $stmt->execute();      // Execute query   
$resultsCount = $stmt->get_result();
}  
$countRow = $resultsCount->fetch_row(); 
if ($stmt = $mysqli->prepare($queryString)) {
$stmt->bind_param("iii",$userId, $start,$limit );     // Bind variables in order
$stmt->execute();                               // Execute query
$results = $stmt->get_result();
}

$count=0;
$myArray = array();
while ($row = $results->fetch_array()) {
  $myArray[]=$row;
   $count++;
}
if
 ($countRow[0]>0)
{        
 
 return array("id" => $countRow[0] , "items"=> $myArray);
} 

$error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> [], "count" => 0);
return $error;

}
function  getCollections($limit,$start)
{  
  global $mysqli;
  

    $queryString= "SELECT collections.*,  COALESCE(users.name,'banknotescollection') as createdBy  FROM collections  LEFT JOIN users  ON collections.ownerId=users.id ";
    $queryString2= "SELECT COUNT(id) FROM collections";
  
  $queryString= $queryString . " ORDER BY id LIMIT ?,?";
//echo $queryString . "--FIN";
if ($stmt = $mysqli->prepare($queryString2)) { 
  $stmt->execute();      // Execute query   
  $resultsCount = $stmt->get_result();
}  
$countRow = $resultsCount->fetch_row(); 
if ($stmt = $mysqli->prepare($queryString)) {
  $stmt->bind_param("ii", $start,$limit );     // Bind variables in order
  $stmt->execute();                               // Execute query
  $results = $stmt->get_result();
}

  $count=0;
 $myArray = array();
  while ($row = $results->fetch_array()) {
    $myArray[]=$row;
     $count++;
  }
  if
   ($countRow[0]>0)
  {        
   
   return array("count" => $countRow[0] , "items"=> $myArray);
  } 
  
  $error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> [], "count" => 0);
  return $error;

}
function getSeriesByCountry($country)
{
//	SELECT series.* FROM series INNER JOIN countries ON series.countryId=countries.id WHERE countries.canonical="algeria"
global $mysqli;

    $queryString= "SELECT series.*, countries.name as countryName FROM series INNER JOIN countries ON series.countryId=countries.id WHERE countries.canonical=? ORDER BY series.serieId ASC";
    
    if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->bind_param("s", $country);     // Bind variables in order
      $stmt->execute();                               // Execute query    
      $results = $stmt->get_result();
    }
$count=0;
$myArray = array();
    while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
    }
    if ($count>0)
    {
	
      return array("id" => 1, "items"=> $myArray);
     
    } 
    $error = array("id" => -1, "message" => "No hay datos con ese canonical. Err: " . $mysqli->error);
    return $error;
 
}
function addSerie($serieId,$collectionId)
{
  global $mysqli;    
  
  $queryString= "INSERT INTO collectionsSeries(serieId,collectionId) VALUES (?,?)";
 
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("ii", $serieId,$collectionId);     // Bind variables in order
    if ($stmt->execute()) { 
      $id=1;
   } else {
    $id=-1;
   }
  }
 
    if ($id>0)
    {
  
      $myArray = array("id" => $id, "message" => "Se ha insertado una nueva serie correctamente.");
      return $myArray;
    }else
    {
      $myArray = array("id" => -1, "message" => "Error al insertar la serieen la base de datos.");
      return $myArray;
    }  
}
function addSubSerie($subSerieId,$collectionId)
{
  global $mysqli;    
  
  $queryString= "INSERT INTO collectionsSubSeries(subSerieId,collectionId) VALUES (?,?)";
 
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("ii", $subSerieId,$collectionId);     // Bind variables in order
    if ($stmt->execute()) { 
      $id=1;
   } else {
    $id=-1;
   }
  }

    if ($id>0)
    {
  
      $myArray = array("id" => $id, "message" => "Se ha insertado una nueva serie correctamente.");
      return $myArray;
    }else
    {
      $myArray = array("id" => -1, "message" => "Error al insertar la serieen la base de datos.");
      return $myArray;
    }  
}
//INSERT INTO Customers (CustomerName, City, Country)
//SELECT SupplierName, City, Country FROM Suppliers;

function addAllSeriesCountries($id,$countryId)
{
 
  global $mysqli;    

  $queryString= "INSERT INTO collectionsSeries(serieId,collectionId) SELECT id, " . $id . " FROM series WHERE countryId=" . $countryId;

  //echo $queryString;

  if ($stmt = $mysqli->prepare($queryString)) {    
    if ($stmt->execute()) { 
      $id=1;
   } else {
    $id=-1;
   }                             
  }
 
    if ($id>0)
    {
  
      $myArray = array("id" => $id, "message" => "Se han insertado las nuevas  series correctamente.");
      return $myArray;
    }else
    {
      $myArray = array("id" => -1, "message" => "Error al insertar las series  la base de datos.");
      return $myArray;
    }  
}

function addAllSubSeries($data,$collectionId)
{
  $data = rtrim($data, ',');
  global $mysqli;    
  $aux= explode(",",$data);

  $queryString= "INSERT INTO collectionsSubSeries(subSerieId,collectionId) VALUES ";
 foreach($aux as $subSerieId)
 {
   $queryString= $queryString . "(" . $subSerieId . "," . $collectionId . "),";
 }
 $queryString = rtrim($queryString, ',');
 //echo $queryString;
  if ($stmt = $mysqli->prepare($queryString)) {    
    if ($stmt->execute()) { 
      $id=1;
   } else {
    $id=-1;
   }                             
  }
 
    if ($id>0)
    {
  
      $myArray = array("id" => $id, "message" => "Se han insertado las nuevas sub series correctamente.");
      return $myArray;
    }else
    {
      $myArray = array("id" => -1, "message" => "Error al insertar las subseries  la base de datos.");
      return $myArray;
    }  
}
function createProvisionalSerie($serieId,$countryId,$userId)
{
    global $mysqli;    
    
    $queryString= "INSERT INTO provisionalSeries(id, serieId,countryId,userId) VALUES (NULL,?,?,?)";
   
    if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->bind_param("sii", $serieId,$countryId,$userId);     // Bind variables in order
      try {
        $stmt->execute();                               // Execute query
    } catch (Exception $e) {
     $id=-1;
    }
  }
       //echo "el error es " .  $mysqli->error;
      $id=$mysqli->insert_id;
      if ($id>0)
      {
    
        $myArray = array("id" => $id, "message" => "Se ha insertado una nueva serie correctamente.");
        return $myArray;
      }else
      {
       
        $serieExists= getSerieRealIdByIdAndCountryId($serieId,$countryId);
     //echo $serieExists;
        if ($serieExists>0)
        {
          
          $myArray = array("id" => -1, "otherId"=>$serieExists,  "message" => "La serie ya existe");
          
        }else
        {
          $myArray = array("id" => -1, "otherId"=>-1,  "message" => "Error al insertar la serien la base de datos.");
        }

        
        return $myArray;
      }  
}
function createSerie($serieId,$countryId)
{
    global $mysqli;    
    
    $queryString= "INSERT INTO series(id, serieId,countryId) VALUES (NULL,?,?)";
   
    if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->bind_param("si", $serieId,$countryId);     // Bind variables in order
      try {
        $stmt->execute();                               // Execute query
    } catch (Exception $e) {
     $id=-1;
    }
  }
       //echo "el error es " .  $mysqli->error;
      $id=$mysqli->insert_id;
      if ($id>0)
      {
    
        $myArray = array("id" => $id, "message" => "Se ha insertado una nueva serie correctamente.");
        return $myArray;
      }else
      {
       
        $serieExists= getSerieRealIdByIdAndCountryId($serieId,$countryId);
     //echo $serieExists;
        if ($serieExists>0)
        {
          
          $myArray = array("id" => -1, "otherId"=>$serieExists,  "message" => "La serie ya existe");
          
        }else
        {
          $myArray = array("id" => -1, "otherId"=>-1,  "message" => "Error al insertar la serien la base de datos.");
        }

        
        return $myArray;
      }  
}
function createProvisionalSubReference($serieId,$subSerieId,$userId)
{
  global $mysqli;    
  
  $queryString= "INSERT INTO provisionalSubSeries(id, serieId,subSerieId,userId) VALUES (NULL,?,?,?)";
 
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("isi", $serieId,$subSerieId,$userId);     // Bind variables in order
    $stmt->execute();                               // Execute query
    $results = $stmt->get_result();
  }
     //echo "el error es " .  $mysqli->error;
    $id=$mysqli->insert_id;
    if ($id>0)
    {
  
      $myArray = array("id" => $id, "message" => "Se ha insertado una nueva sub serie provisionalSubSeries correctamente.");
      return $myArray;
    }else
    {
      $myArray = array("id" => -1, "message" => "Error al insertar la sub serie provisionalSubSeries en la base de datos.");
      return $myArray;
    }  
}

function createSubSerie($serieId,$subSerieId)
{
    global $mysqli;    
    
    $queryString= "INSERT INTO subSeries(id, serieId,subSerieId) VALUES (NULL,?,?)";
   
    if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->bind_param("is", $serieId,$subSerieId);     // Bind variables in order
      $stmt->execute();                               // Execute query
      $results = $stmt->get_result();
    }
       //echo "el error es " .  $mysqli->error;
      $id=$mysqli->insert_id;
      if ($id>0)
      {
    
        $myArray = array("id" => $id, "message" => "Se ha insertado una nueva sub serie correctamente.");
        return $myArray;
      }else
      {
        $myArray = array("id" => -1, "message" => "Error al insertar la sub serie en la base de datos.");
        return $myArray;
      }  
}


function deleteFromTable($table, $id)
{
    global $mysqli;
    $queryString= "DELETE FROM " . $table . " WHERE id=" . $id; 
    $mysqli->query($queryString);
    //echo $queryString;
    $affectedRows=$mysqli->affected_rows;
    if ($affectedRows>0)
    {
        $myArray = array("id" => $id, "message" => "Se ha eliminado correctamente.");
        return $myArray;
    }else
    {
        $myArray = array("id" => -1, "message" => "Error al eliminar en la base de datos. Err: " . $mysqli->error);
        return $myArray;
    }
}
function getBillOwnerDataById($id)
{
  global $mysqli;

  $queryString= "SELECT bills.*, series.billValue, series.issuer,series.dateText,series.initYear,series.endYear,series.printer,series.extraData,series.imageData1,series.imageData2
  ,series.serieId as serieIdName, subSeries.remark, subSeries.subSerieId as subSerieIdName, users.nickname, users.name as userName, users.surnames,users.email,users.phone,
  users.shippingAddress,users.shippingRules, countries.name as countryName, continents.name as continentName, grades.es as ES, grades.en as EN FROM bills INNER JOIN series ON bills.serieId=series.id 
  LEFT JOIN subSeries ON bills.subSerieId=subSeries.id 
  LEFT JOIN countries on bills.countryId=countries.id
  LEFT JOIN continents on countries.continentId=continents.id
  INNER JOIN users on bills.ownerId=users.id
  LEFT JOIN grades on bills.grade=grades.id  
  WHERE bills.id=?";  
  
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("i", $id);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
$count=0;
$myArray = array();
  while ($row = $results->fetch_array()) {  
    $myArray[]=$row;
    $count++;
  }
  if ($count>0)
  {

    return array("id" =>$id, "item"=> $myArray[0]);
   
  } 
  $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
  return $error;

}
function getByCanonical($canonical, $table)
{
    global $mysqli;

    $queryString= "SELECT * FROM " . $table . "  WHERE  canonical=?";  
    
    
    if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->bind_param("s", $canonical);     // Bind variables in order
      $stmt->execute();                               // Execute query    
      $results = $stmt->get_result();
    }
$count=0;
$myArray = array();
    while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
    }
    if ($count>0)
    {
	
      return array("id" =>$myArray[0][0], "item"=> $myArray[0]);
     
    } 
    $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
    return $error;
 
}
function getById($id, $table)
{
    global $mysqli;

    $queryString= "SELECT * FROM " . $table . "  WHERE  id=?";  
    
    if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->bind_param("i", $id);     // Bind variables in order
      $stmt->execute();                               // Execute query    
      $results = $stmt->get_result();
    }
$count=0;
$myArray = array();
    while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
    }
    if ($count>0)
    {
	
      return array("id" =>$id, "item"=> $myArray[0]);
     
    } 
    $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
    return $error;
 
}
function getProvisionalSubSerieById($id)
{
    global $mysqli;

    $queryString= "SELECT provisionalSubSeries.*, series.countryId as countryId, series.serieId as serieIdText FROM provisionalSubSeries 
    INNER JOIN series ON provisionalSubSeries.serieId=series.id  WHERE  provisionalSubSeries.id=?";  
    
    if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->bind_param("i", $id);     // Bind variables in order
      $stmt->execute();                               // Execute query    
      $results = $stmt->get_result();
    }
$count=0;
$myArray = array();
    while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
    }
    if ($count>0)
    {
	
      return array("id" =>$id, "item"=> $myArray[0]);
     
    } 
    $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
    return $error;
 
}


function getSubSerieSugestionById($id)
{
    global $mysqli;

    $queryString= "SELECT provisionalSubSeries.*, series.countryId as countryId, series.serieId as serieIdText FROM provisionalSubSeries 
    INNER JOIN series ON provisionalSubSeries.serieId=series.id  WHERE  provisionalSubSeries.id=?";  
    
    if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->bind_param("i", $id);     // Bind variables in order
      $stmt->execute();                               // Execute query    
      $results = $stmt->get_result();
    }
$count=0;
$myArray = array();
    while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
    }
    if ($count>0)
    {
	
      return array("id" =>$id, "item"=> $myArray[0]);
     
    } 
    $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
    return $error;
 
}
function getSubSerieById($id)
{
    global $mysqli;

    $queryString= "SELECT subSeries.*, series.countryId as countryId, series.serieId as serieIdText, series.billValue, series.dateText, countries.name as countryName FROM subSeries 
    INNER JOIN series ON subSeries.serieId=series.id  INNER JOIN countries on series.countryId=countries.id WHERE  subSeries.id=?";  
    
    if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->bind_param("i", $id);     // Bind variables in order
      $stmt->execute();                               // Execute query    
      $results = $stmt->get_result();
    }
$count=0;
$myArray = array();
    while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
    }
    if ($count>0)
    {
	
      return array("id" =>$id, "item"=> $myArray[0]);
     
    } 
    $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
    return $error;
 
}
function updateBillPrice($billId,$sellPrice)
{
  global $mysqli;
  
  $queryString= "UPDATE bills SET sellPrice=? WHERE id=?";
  
  //$queryString= "UPDATE bills SET serieId=$serieId , subSerieId=$subSerieId, grade=$grade,frontSerie=$frontSerie,backSerie=$backSerie,
   //firstSerial=$firstSerial, lastSerial=$lastSerial,purchaseDate=$purchaseDate,publicNotes=$publicNotes,privateNotes=$privateNotes, sellPrice=$sellPrice,
   //sellActive=$sellActive, purchasePrice=$purchasePrice  WHERE id=?";

    if ($stmt = $mysqli->prepare($queryString)) 
    {
      $stmt->bind_param("di",$sellPrice, $billId);     // Bind variables in order
      $stmt->execute();                               // Execute query    
    }
    $affectedRows=$mysqli->affected_rows;
    if ($affectedRows>0)
    {
        $myArray = array("id" => $billId, "message" => "Se ha actualizado el billete correctamente.");
        return $myArray;
    }else
    {
          $myArray = array("id" => -1, "message" => "Error al actualizar el billete en la base de datos. Err: " . $mysqli->error);
        return $myArray;
    }
}
function updateBillState($billId,$state)
{
  global $mysqli;
  
  $queryString= "UPDATE bills SET sellActive=? WHERE id=?";
  
  //$queryString= "UPDATE bills SET serieId=$serieId , subSerieId=$subSerieId, grade=$grade,frontSerie=$frontSerie,backSerie=$backSerie,
   //firstSerial=$firstSerial, lastSerial=$lastSerial,purchaseDate=$purchaseDate,publicNotes=$publicNotes,privateNotes=$privateNotes, sellPrice=$sellPrice,
   //sellActive=$sellActive, purchasePrice=$purchasePrice  WHERE id=?";

    if ($stmt = $mysqli->prepare($queryString)) 
    {
      $stmt->bind_param("ii",$state, $billId);     // Bind variables in order
      $stmt->execute();                               // Execute query    
    }
    $affectedRows=$mysqli->affected_rows;
    if ($affectedRows>0)
    {
        $myArray = array("id" => $billId, "message" => "Se ha actualizado el billete correctamente.");
        return $myArray;
    }else
    {
          $myArray = array("id" => -1, "message" => "Error al actualizar el billete en la base de datos. Err: " . $mysqli->error);
        return $myArray;
    }
}

function activateStatus($table,$id,$status)
{
  global $mysqli;
  
  $queryString= "UPDATE " . $table . " SET status=? WHERE id=?";
  
  //$queryString= "UPDATE bills SET serieId=$serieId , subSerieId=$subSerieId, grade=$grade,frontSerie=$frontSerie,backSerie=$backSerie,
   //firstSerial=$firstSerial, lastSerial=$lastSerial,purchaseDate=$purchaseDate,publicNotes=$publicNotes,privateNotes=$privateNotes, sellPrice=$sellPrice,
   //sellActive=$sellActive, purchasePrice=$purchasePrice  WHERE id=?";

    if ($stmt = $mysqli->prepare($queryString)) 
    {
      $stmt->bind_param("ii",$status, $id);     // Bind variables in order
      $stmt->execute();                               // Execute query    
    }
    $affectedRows=$mysqli->affected_rows;
    if ($affectedRows>0)
    {
        $myArray = array("id" => $id, "message" => "Se ha actualizado el estado correctamente.");
        return $myArray;
    }else
    {
          $myArray = array("id" => -1, "message" => "Error al actualizar el estado en la base de datos. Err: " . $mysqli->error);
        return $myArray;
    }
}
function updateBillOwner($billId,$buyer,$seller,$sellPrice)
{
  global $mysqli;
  
  $queryString= "UPDATE bills SET ownerId=?, sellerId=? , purchasePrice=?, privateNotes='', sellActive=0 WHERE id=?";
  
  //$queryString= "UPDATE bills SET serieId=$serieId , subSerieId=$subSerieId, grade=$grade,frontSerie=$frontSerie,backSerie=$backSerie,
   //firstSerial=$firstSerial, lastSerial=$lastSerial,purchaseDate=$purchaseDate,publicNotes=$publicNotes,privateNotes=$privateNotes, sellPrice=$sellPrice,
   //sellActive=$sellActive, purchasePrice=$purchasePrice  WHERE id=?";

    if ($stmt = $mysqli->prepare($queryString)) 
    {
      $stmt->bind_param("iidi",$buyer, $seller, $sellPrice, $billId);     // Bind variables in order
      $stmt->execute();                               // Execute query    
    }
    $affectedRows=$mysqli->affected_rows;
    if ($affectedRows>0)
    {
        $myArray = array("id" => $billId, "message" => "Se ha actualizado el billete correctamente.");
        return $myArray;
    }else
    {
          $myArray = array("id" => -1, "message" => "Error al actualizar el billete en la base de datos. Err: " . $mysqli->error);
        return $myArray;
    }
}
function updateBill($id,$serieId,$subSerieId,$countryId,$grade,$frontSerie,$backSerie,$numSerie
,$purchaseDate,$publicNotes,$privateNotes,$sellPrice,
$sellActive,$purchasePrice,$restored,$errorNote,$replacement,$specimen,$proof,$falseBill,$year, $managingFor)
{
  global $mysqli;
  
  $queryString= "UPDATE bills SET serieId=? , subSerieId=?, countryId=?, grade=?,
  frontSerie=?,backSerie=?,  purchaseDate=?,publicNotes=?,privateNotes=?,
   sellPrice=?,  sellActive=?, purchasePrice=?, numSerie=?, 
   restored=?, errorNote=?, replacement=?, specimen=?, proof=?, falseBill=?, billYear=?, managingFor=? WHERE id=?";
  
  //$queryString2= "UPDATE bills SET serieId=$serieId , subSerieId=$subSerieId, countryId=$countryId, grade=$grade,
  //frontSerie=$frontSerie,backSerie=$backSerie,purchaseDate=$purchaseDate,publicNotes=$publicNotes,privateNotes=$privateNotes,
  //sellPrice=$sellPrice, sellActive=$sellActive, purchasePrice=$purchasePrice, numSerie=$numSerie,
  //restored=$restored, errorNote=$errorNote, replacement=$replacement, specimen=$specimen, proof=$proof, falseBill=$falseBill, billYear=$year, managingFor=$managingFor
   // WHERE id=$id";

    //echo $queryString2;

    if ($stmt = $mysqli->prepare($queryString)) 
    {
      $stmt->bind_param("iiiisssssdidsiiiiiiiii", $serieId, $subSerieId,$countryId,$grade,$frontSerie,$backSerie,
      $purchaseDate,$publicNotes,$privateNotes,$sellPrice,
      $sellActive, $purchasePrice, $numSerie, $restored, $errorNote, $replacement,$specimen,$proof,$falseBill, $year,$managingFor,$id);     // Bind variables in order
      $stmt->execute();                               // Execute query    
    //  echo "LLEGA";
    }
    $affectedRows=$mysqli->affected_rows;
    //echo "LLEGA2";
    if ($affectedRows>0)
    {
      //echo "LLEGA3";
        $myArray = array("id" => $id, "message" => "Se ha actualizado el billete correctamente.");
        return $myArray;
    }else
    {
      //echo "LLEGA4";
          $myArray = array("id" => -1, "message" => "Error al actualizar el billete en la base de datos. Err: " . $mysqli->error);
        return $myArray;
    }
}
function updateInteraction($id,$status)
{
  global $mysqli;
  
  $queryString= "UPDATE interactions2 SET status=?  WHERE id=?";

    if ($stmt = $mysqli->prepare($queryString)) 
    {
      $stmt->bind_param("ii", $status,$id);     // Bind variables in order
      $stmt->execute();                               // Execute query    
    }
    $affectedRows=$mysqli->affected_rows;
    if ($affectedRows>0)
    {
        $myArray = array("id" => $id, "message" => "Se ha actualizado la interaccion correctamente.");
        return $myArray;
    }else
    {
          $myArray = array("id" => -1, "message" => "Error al actualizar la interaccion en la base de datos. Err: " . $mysqli->error);
        return $myArray;
    }
}
function updateArticle($id,$title,$description,$canonical,$resume,$fullArticle,$tags)
{
  global $mysqli;
  //$fullArticle=mysql_real_escape_string($mysqli,$fullArticle);
  $queryString= "UPDATE blog SET title=? , canonical=?, metaDescription=?,tags=?, resumen=?, fullArticle=? WHERE id=?";

    if ($stmt = $mysqli->prepare($queryString)) 
    {
      $stmt->bind_param("ssssssi", $title,$canonical, $description,$tags,$resume, $fullArticle, $id);     // Bind variables in order
      $stmt->execute();                               // Execute query    
    }
    $affectedRows=$mysqli->affected_rows;
    if ($affectedRows>0)
    {
        $myArray = array("id" => $id, "message" => "Se ha actualizado la articulo correctamente.");
        return $myArray;
    }else
    {
          $myArray = array("id" => -1, "message" => "Error al actualizar la articulo en la base de datos. Err: " . $mysqli->error);
        return $myArray;
    }
}
function updateCollection($id,$name,$description,$active)
{
  global $mysqli;
  
  $queryString= "UPDATE collections SET name=? ,  description=?,status=? WHERE id=?";

    if ($stmt = $mysqli->prepare($queryString)) 
    {
      $stmt->bind_param("ssii", $name,$description,$active,$id);     // Bind variables in order
      $stmt->execute();                               // Execute query    
    }
    $affectedRows=$mysqli->affected_rows;
    if ($affectedRows>0)
    {
        $myArray = array("id" => $id, "message" => "Se ha actualizado la coleccion correctamente.");
        return $myArray;
    }else
    {
          $myArray = array("id" => -1, "message" => "Error al actualizar la coleccion en la base de datos. Err: " . $mysqli->error);
        return $myArray;
    }
}
function approveSubSerieSugestion($id)
{
  global $mysqli;
  $queryString= "INSERT INTO subSeries (id, serieId, subSerieId, remark)
SELECT null, serieId, subSerieId,remark
  FROM provisionalSubSeries
WHERE provisionalSubSeries.id=" . $id;

$mysqli->query($queryString);
$id=$mysqli->insert_id;
return $id;
}
function approveSugestion($id)
{
  global $mysqli;
  $queryString= "INSERT INTO series (id, serieId, countryId,billValue,issuer,dateText,initYear,endYear,printer,overPrinter,extraData,imageData1,
  imageData2, originalUrl)  
SELECT null, serieId, countryId,billValue,issuer,dateText,initYear,endYear,printer,overPrinter,extraData,imageData1, imageData2, originalUrl
  FROM provisionalSeries
WHERE provisionalSeries.id=" . $id;

$mysqli->query($queryString);
$id=$mysqli->insert_id;
return $id;
}
function updateProvisionalSerie($id,$serieId,$billValue,$issuer,$dateText,$printer,$initYear,$endYear,$countryId,$imageData1,$imageData2,$extraData)
{
    global $mysqli;
    
    $queryString= "UPDATE provisionalSeries SET serieId=? , billValue=?, issuer=?,dateText=?,
    printer=?,initYear=?,endYear=?, extraData=?, countryId=?, imageData1=?, imageData2=? WHERE id=?";

      if ($stmt = $mysqli->prepare($queryString)) 
      {
        $stmt->bind_param("sssssiisissi", $serieId, $billValue,$issuer,$dateText,$printer,$initYear,$endYear,$extraData,$countryId,$imageData1,$imageData2,$id);     // Bind variables in order
        $stmt->execute();                               // Execute query    
      }
      $affectedRows=$mysqli->affected_rows;
      if ($affectedRows>0)
      {
          $myArray = array("id" => $id, "message" => "Se ha actualizado la serie correctamente.");
          return $myArray;
      }else
      {
            $myArray = array("id" => -1, "message" => "Error al actualizar la serie en la base de datos. Err: " . $mysqli->error);
          return $myArray;
      }
}
function updateSerie2($id,$serieId,$billValue,$issuer,$dateText,$printer,$countryId,$imageData1,$imageData2,$extraData,$imageName1,$imageName2, $newImageName1,$newImageName2)
{
    global $mysqli;
    $imageInfo="No existe";
    $queryString= "UPDATE series SET serieId=? , billValue=?, issuer=?,dateText=?,
    printer=?, extraData=?, countryId=?, imageData1=?, imageData2=? WHERE id=?";

  // echo $queryString;
     //rename Images
    echo '../images/billetes/' . $imageName1 . "<br/>";
    echo '../images/billetes/' . $newImageName1 . "<br/>";
    echo '../images/billetes/' . $imageName2 . "<br/>";
    echo '../images/billetes/' . $newImageName2 . "<br/>";
    //die();
          if (file_exists('../images/billetes/' . $imageName1))
          {
            $imageInfo = '../images/billetes/' . $imageName1 . " ---EXISTE";
            if   (rename('../images/billetes/' . $imageName1, '../images/billetes/' . $newImageName1))
            {
              $imageInfo="Renombrada con exito a " .  '../images/billetes/' . $newImageName1 ;
            }else
            {
              $imageInfo="Error en el rename a " .  '../images/billetes/' . $newImageName1 ;
            }
          }
            
          if (file_exists('../images/billetes/' . $imageName2))
          {
            rename('../images/billetes/' . $imageName2, '../images/billetes/' . $newImageName2);
          }
          updateSubReferencesImagesFromSerie($id,$imageName1,$imageName2,$newImageName1, $newImageName2);
          $myArray = array("id" => $id, "message" => "Se ha actualizado la serie correctamente.", "imagen"=> $imageInfo );
          return $myArray;
    
}
function updateSerie($id,$serieId,$billValue,$issuer,$dateText,$printer,$countryId,$imageData1,$imageData2,$extraData,$imageName1,$imageName2, $newImageName1,$newImageName2)
{
    global $mysqli;
    $imageInfo="No existe";
    $queryString= "UPDATE series SET serieId=? , billValue=?, issuer=?,dateText=?,
    printer=?, extraData=?, countryId=?, imageData1=?, imageData2=? WHERE id=?";

      if ($stmt = $mysqli->prepare($queryString)) 
      {
        $stmt->bind_param("ssssssissi", $serieId, $billValue,$issuer,$dateText,$printer,$extraData,$countryId,$imageData1,$imageData2,$id);     // Bind variables in order
        $stmt->execute();                               // Execute query    
      }
      $affectedRows=$mysqli->affected_rows;
      if ($affectedRows>0)
      {
          //rename Images
         // echo $_SERVER['DOCUMENT_ROOT'] .'/images/billetes/' . $imageName1;
          clearstatcache();
          if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/images/billetes/' . $imageName1))
          {
        //    echo "EXISTE 1";
            $imageInfo = $_SERVER['DOCUMENT_ROOT'] .'/images/billetes/' . $imageName1 . " ---EXISTE";
            
            if   (rename($_SERVER['DOCUMENT_ROOT'] .'/images/billetes/' . $imageName1, $_SERVER['DOCUMENT_ROOT'] .'/images/billetes/' . $newImageName1))
            {
              $imageInfo="Renombrada con exito a " .  $_SERVER['DOCUMENT_ROOT'] .'/images/billetes/' . $newImageName1 ;
            }else
            {
              $imageInfo="Error en el rename a " .  $_SERVER['DOCUMENT_ROOT'] .'/images/billetes/' . $newImageName1 ;
            }
          }
            
          if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/images/billetes/' . $imageName2))
          {
           // echo "EXISTE 2";
            rename($_SERVER['DOCUMENT_ROOT'] .'/images/billetes/' . $imageName2, $_SERVER['DOCUMENT_ROOT'] .'/images/billetes/' . $newImageName2);
          }
          updateSubReferencesImagesFromSerie($id,$imageName1,$imageName2,$newImageName1, $newImageName2);
          $myArray = array("id" => $id, "message" => "Se ha actualizado la serie correctamente.", "imagen"=> $imageInfo );
          return $myArray;
      }else
      {
            $myArray = array("id" => -1, "message" => "Error al actualizar la serie en la base de datos. Err: " . $mysqli->error);
          return $myArray;
      }
}
function  updateSubReferencesImagesFromSerie($id,$oldImageName1, $oldImageName2, $newImageName1,$newImageName2)
{
  global $mysqli;

  $queryString= "SELECT subSeries.*  FROM subSeries  WHERE  subSeries.serieId=?";  
  
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("i", $id);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
$count=0;
$myArray = array();
  while ($row = $results->fetch_array()) {  
    $myArray[]=$row;
    $count++;
  }
  $subSeries=$myArray;
  
  foreach($subSeries as $subSerie)
  {
   // echo "La subserie es: " .  $subSerie[2] . "<br>";
        $oldSubSerieImageName1= str_replace("_1.jpg",  "-" . $subSerie[2] . "_1.jpg",$oldImageName1);
        $oldSubSerieImageName2= str_replace("_2.jpg",  "-" . $subSerie[2] . "_2.jpg",$oldImageName2);

        $newSubSerieImageName1= str_replace("_1.jpg",  "-" .$subSerie[2] . "_1.jpg",$newImageName1);
        $newSubSerieImageName2= str_replace("_2.jpg",  "-" . $subSerie[2] . "_2.jpg",$newImageName2);

        


      // echo '../images/billetes/' . $oldSubSerieImageName1 . "<br/>" ;
      // echo '../images/billetes/' . $newSubSerieImageName1  . "<br/><br/>";

       //echo '../images/billetes/' . $oldSubSerieImageName2 . "<br/>" ;
       //echo '../images/billetes/' . $newSubSerieImageName2 . "<br/>";
        if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/images/billetes/' . $oldSubSerieImageName1))
        {
       //echo "Entra en renombrar1";
         rename($_SERVER['DOCUMENT_ROOT'] .'/images/billetes/' . $oldSubSerieImageName1, $_SERVER['DOCUMENT_ROOT'] .'/images/billetes/' . $newSubSerieImageName1);
        
        }
          
        if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/images/billetes/' . $oldSubSerieImageName2))
        {
         // echo "Entra en renombrar2";
          rename($_SERVER['DOCUMENT_ROOT'] .'/images/billetes/' . $oldSubSerieImageName2, $_SERVER['DOCUMENT_ROOT'] .'/images/billetes/' . $newSubSerieImageName2);
        }

  }
}
function updateProvisionalSubSerie($id,$subSerieId,$remark)
{
    global $mysqli;
    
    $queryString= "UPDATE provisionalSubSeries SET subSerieId=? , remark=? WHERE id=?";

      if ($stmt = $mysqli->prepare($queryString)) 
      {
        $stmt->bind_param("ssi", $subSerieId,$remark,$id);     // Bind variables in order
        $stmt->execute();                               // Execute query    
      }
      $affectedRows=$mysqli->affected_rows;
      if ($affectedRows>0)
      {
          $myArray = array("id" => $id, "message" => "Se ha actualizado la sub serie provisional correctamente.");
          return $myArray;
      }else
      {
            $myArray = array("id" => -1, "message" => "Error al actualizar la sub serie provisional en la base de datos. Err: " . $mysqli->error);
          return $myArray;
      }
}
function updateSubSerie($id,$subSerieId,$remark,$imageName1,$imageName2, $newImageName1,$newImageName2)
{
    global $mysqli;
    $imageInfo ="";
    $queryString= "UPDATE subSeries SET subSerieId=? , remark=? WHERE id=?";

      if ($stmt = $mysqli->prepare($queryString)) 
      {
        $stmt->bind_param("ssi", $subSerieId,$remark,$id);     // Bind variables in order
        $stmt->execute();                               // Execute query    
      }
      $affectedRows=$mysqli->affected_rows;
      if ($affectedRows>0)
      {
        if (file_exists('../images/billetes/' . $imageName1))
          {
            $imageInfo = '../images/billetes/' . $imageName1 . " ---EXISTE";
            if   (rename('../images/billetes/' . $imageName1, '../images/billetes/' . $newImageName1))
            {
              $imageInfo="Renombrada con exito a " .  '../images/billetes/' . $newImageName1 ;
            }else
            {
              $imageInfo="Error en el rename a " .  '../images/billetes/' . $newImageName1 ;
            }
          }
            
          if (file_exists('../images/billetes/' . $imageName2))
          {
            rename('../images/billetes/' . $imageName2, '../images/billetes/' . $newImageName2);
          }
          $myArray = array("id" => $id, "message" => "Se ha actualizado la sub serie correctamente.", "imageInfo"=> $imageInfo);
          return $myArray;
      }else
      {
            $myArray = array("id" => -1, "message" => "Error al actualizar la sub serie en la base de datos. Err: " . $mysqli->error);
          return $myArray;
      }
}
function addBillToOldSold($billId)
{
        global $mysqli;
        $queryString= "INSERT INTO billsOld (id, ownerId, countryId, serieId, subSerieId, 
        grade, frontSerie, numSerie, backSerie, purchasePrice, sellerId, purchaseDate, publicNotes, 
        privateNotes, sellPrice, sellActive, restored, errorNote,originalBillId)  
      SELECT null, ownerId, countryId, serieId, subSerieId, 
        grade, frontSerie, numSerie, backSerie, purchasePrice, sellerId, purchaseDate, publicNotes, 
        privateNotes, sellPrice, sellActive, restored, errorNote,id
        FROM bills
      WHERE bills.id=" . $billId;

      $mysqli->query($queryString);
      $id=$mysqli->insert_id;
     return $id;

}
function getInteractionById($id)
{
  global $mysqli;
  
 
  //  $queryString= "SELECT interactions2.*,bills.id as billId, bills.frontSerie,bills.numSerie,bills.backSerie, grades.en, 
  //  grades.es,bills.sellPrice,bills.publicNotes, bills.sellActive, bills.restored,bills.errorNote,bills.replacement,
  //  bills.proof, bills.specimen,
  //  series.countryId, series.id as serieId, series.serieId as serieIdName,subSeries.id as subSerieId, subSeries.subSerieId as subSerieIdName, series.billValue, series.dateText, 
 //   series.issuer,series.initYear, series.endYear, series.printer, series.extraData, series.imageData1, series.imageData2,subSeries.remark,countries.name as countryName FROM interactions2 
  //  INNER JOIN bills on interactions2.billsIds=bills.id 
  //  LEFT JOIN grades on bills.grade=grades.id
 //   INNER JOIN series on bills.serieId=series.id
 //   LEFT JOIN subSeries on bills.subSerieId=subSeries.id
 //   INNER JOIN countries on bills.countryId=countries.id    
 //   WHERE interactions2.id=?";

 $queryString="SELECT interactions2.*, users.*  FROM interactions2 INNER JOIN users ON interactions2.receptorId=users.id  WHERE interactions2.id=?";
//echo $queryString;
if ($stmt = $mysqli->prepare($queryString)) {
  $stmt->bind_param("i", $id);     // Bind variables in order
  $stmt->execute();                               // Execute query    
  $results = $stmt->get_result();
}
$count=0;
$myArray = array();
while ($row = $results->fetch_array()) {  
  $myArray[]=$row;
  $count++;
}
if ($count>0)
{
  return array("id" =>$id, "item"=> $myArray[0]);
 
} 
$error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
return $error;
}

function getMyInteractions($userId,$limit,$start)
{
  global $mysqli;
   
    $queryString= "SELECT interactions2.*, usr1.nickname as user1, usr2.nickname as user2 FROM interactions2   
    INNER JOIN users as usr1 ON usr1.id=interactions2.requesterId 
    INNER JOIN users as usr2 ON usr2.id=interactions2.receptorId
    WHERE requesterId=" . $userId . " OR receptorId=" . $userId ;
 
    $queryString2= "SELECT COUNT(interactions2.id) FROM interactions2 
    INNER JOIN users as usr1 ON usr1.id=interactions2.requesterId 
    INNER JOIN users as usr2 ON usr2.id=interactions2.receptorId
    WHERE requesterId=" . $userId . " OR receptorId=" . $userId ;
 
  $queryString= $queryString . " ORDER BY updateDate DESC LIMIT ?,?";
//echo $queryString . "--FIN";
    if ($stmt = $mysqli->prepare($queryString2)) { 
      $stmt->execute();      // Execute query   
      $resultsCount = $stmt->get_result();
    }  
    $countRow = $resultsCount->fetch_row(); 
    if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->bind_param("ii", $start,$limit);     // Bind variables in order
      $stmt->execute();                               // Execute query
      $results = $stmt->get_result();
    }

     $count=0;
     $myArray = array();
      while ($row = $results->fetch_array()) {
        $myArray[]=$row;
        $count++;
      }
      if ($countRow[0]>0)
      {    
          return array("count" => $countRow[0] , "items"=> $myArray);
      } 
  
  $error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> [], "count" => 0);
  return $error;
}
function getMyInteractions2($userId,$limit,$start)
{
  global $mysqli;
  
 
    $queryString= "SELECT interactions2.*, bills.frontSerie,bills.numSerie,bills.backSerie, bills.publicNotes, bills.restored,bills.errorNote,bills.replacement,
    bills.proof, bills.specimen, grades.en, grades.es,bills.sellPrice,
     series.serieId, subSeries.subSerieId, series.billValue, series.dateText, countries.name as countryName, usr1.nickname as user1, usr2.nickname as user2 FROM interactions2 
    INNER JOIN bills on interactions2.billsIds=bills.id 
    LEFT JOIN grades on bills.grade=grades.id
    INNER JOIN series on bills.serieId=series.id
    LEFT JOIN subSeries on bills.subSerieId=subSeries.id
    INNER JOIN countries on bills.countryId=countries.id    
    INNER JOIN users as usr1 ON usr1.id=interactions2.requesterId 
    INNER JOIN users as usr2 ON usr2.id=interactions2.receptorId
    WHERE requesterId=" . $userId . " OR receptorId=" . $userId ;
 
    $queryString2= "SELECT COUNT(interactions2.id) FROM interactions2 
 INNER JOIN bills on interactions2.billsIds=bills.id 
 LEFT JOIN grades on bills.grade=grades.id
 INNER JOIN series on bills.serieId=series.id
 LEFT JOIN subSeries on bills.subSerieId=subSeries.id
 INNER JOIN countries on bills.countryId=countries.id
 INNER JOIN users as usr1 ON usr1.id=interactions2.requesterId 
    INNER JOIN users as usr2 ON usr2.id=interactions2.receptorId
 WHERE requesterId=" . $userId . " OR receptorId=" . $userId ;
 
  $queryString= $queryString . " ORDER BY updateDate DESC LIMIT ?,?";
//echo $queryString . "--FIN";
if ($stmt = $mysqli->prepare($queryString2)) { 
  $stmt->execute();      // Execute query   
  $resultsCount = $stmt->get_result();
}  
$countRow = $resultsCount->fetch_row(); 
if ($stmt = $mysqli->prepare($queryString)) {
  $stmt->bind_param("ii", $start,$limit);     // Bind variables in order
  $stmt->execute();                               // Execute query
  $results = $stmt->get_result();
}

  $count=0;
 $myArray = array();
  while ($row = $results->fetch_array()) {
    $myArray[]=$row;
     $count++;
  }
  if ($countRow[0]>0)
  {        
   
   return array("count" => $countRow[0] , "items"=> $myArray);
  } 
  
  $error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> [], "count" => 0);
  return $error;
}
function getSugestions()
{
  
  global $mysqli;  
  
  $queryString2= "SELECT provisionalSubSeries.*, users.nickname FROM provisionalSubSeries INNER JOIN users ON provisionalSubSeries.userId=users.id";
  $queryString= "SELECT provisionalSeries.*, users.nickname FROM provisionalSeries INNER JOIN users ON provisionalSeries.userId=users.id";
  
  if ($stmt = $mysqli->prepare($queryString)) {
   // $stmt->bind_param("ii", $start,$limit );     // Bind variables in order
    $stmt->execute();                               // Execute query
    $results = $stmt->get_result();
  }

  $count=0;
  $myArray = array();
  while ($row = $results->fetch_array()) {
    $myArray[]=$row;
     $count++;
  }


  if ($stmt = $mysqli->prepare($queryString2)) {
    // $stmt->bind_param("ii", $start,$limit );     // Bind variables in order
     $stmt->execute();                               // Execute query
     $results = $stmt->get_result();
   }

   $myArray2 = array();
   while ($row = $results->fetch_array()) {
     $myArray2[]=$row;
      $count++;
   }
  if (($count>0))
  {        
   return array("count" => $count ,  "series"=> $myArray, "subSeries"=>$myArray2);
  } 
  $error = array("count" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> []);
  return $error;
  
}
function getUsersByIds($userId1,$userId2)
{
  global $mysqli;

    $queryString= "SELECT DISTINCT users.* 
     FROM users      
      WHERE  users.id= $userId1 OR users.id=$userId2";
    
    if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->execute();                               // Execute query    
      $results = $stmt->get_result();
    }
      $count=0;
      $myArray = array();
    while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
    }
    if ($count>0)
    {
	
      return  $myArray;
     
    } 
    
    return null;
}

function getOwnersByIds($ids)
{
  //echo "<h1>Los ids son: " . $ids . "</h1>";
  //SELECT users.* FROM users INNER JOIN bills ON bills.ownerId=users.id WHERE  bills.id in (0,1932,1128,1212,1922)
  //SELECT users.* , bills.* FROM users INNER JOIN bills ON bills.ownerId=users.id WHERE  bills.id in (0,1932,1128,1212,1922) ORDER BY users.id ASC
  global $mysqli;

    $queryString= "SELECT DISTINCT users.* , bills.*, countries.name as countryName, series.serieId as serieName,
     series.billValue, series.issuer, series.dateText, series.printer, subSeries.id as subSerieId, subSeries.subSerieId as subSerieName , 
     series.initYear,series.endYear, series.extraData, series.imageData1, series.imageData2, subSeries.remark,
     grades.en as gradeEN,grades.es as gradeES
     FROM users 
     INNER JOIN bills ON bills.ownerId=users.id
     INNER JOIN series ON bills.serieId=series.id
     LEFT JOIN subSeries ON bills.subSerieId=subSeries.id
     INNER JOIN countries ON bills.countryId=countries.id
     INNER JOIN grades ON bills.grade=grades.id
      WHERE  bills.id in (" . $ids . ") ORDER BY users.id ASC";
    
    if ($stmt = $mysqli->prepare($queryString)) {
   //   $stmt->bind_param("s", $country);     // Bind variables in order
      $stmt->execute();                               // Execute query    
      $results = $stmt->get_result();
    }
      $count=0;
      $myArray = array();
    while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
    }
    if ($count>0)
    {
	
      return array("count" => $count, "items"=> $myArray);
     
    } 
    $error = array("count" => 0, "message" => "No hay datos con ese canonical. Err: " . $mysqli->error);
    return $error;
}
function getGrades()
{
  global $mysqli;  
  $queryString = "SELECT * FROM grades ORDER BY gradeOrder ASC";
 
  if ($stmt = $mysqli->prepare($queryString)) {
    // $stmt->bind_param("ii", $userId,$userId );     // Bind variables in order
     $stmt->execute();                               // Execute query
     $results = $stmt->get_result();
   }
 
   $count=0;
   $myArray = array();
   while ($row = $results->fetch_array()) {
     $myArray[]=$row;
      $count++;
   }
   if ($count>0)
   {        
    return array("id" => $count , "count"=> $myArray[0], "items"=>$myArray);
   } 
   $error = array("id" => -1, "count"=>0, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> []);
   return $error;
}
function getTableData($table,$filter, $limit, $start) {
  global $mysqli;
  
  if ($filter!="")
  {
    $queryString= "SELECT * FROM " . $table . "  WHERE " . $filter;
    $queryString2= "SELECT COUNT(id) FROM " . $table . " WHERE " . $filter;
  }else
  {
    $queryString= "SELECT * FROM " . $table ;
    $queryString2= "SELECT COUNT(id) FROM " . $table;
  }
  $queryString= $queryString . " ORDER BY id LIMIT ?,?";
//echo $queryString . "--FIN";
if ($stmt = $mysqli->prepare($queryString2)) { 
  $stmt->execute();      // Execute query   
  $resultsCount = $stmt->get_result();
}  
$countRow = $resultsCount->fetch_row(); 
if ($stmt = $mysqli->prepare($queryString)) {
  $stmt->bind_param("ii", $start,$limit );     // Bind variables in order
  $stmt->execute();                               // Execute query
  $results = $stmt->get_result();
}

  $count=0;
 $myArray = array();
  while ($row = $results->fetch_array()) {
    $myArray[]=$row;
     $count++;
  }
  if ($countRow[0]>0)
  {        
   
   return array("count" => $countRow[0] , "items"=> $myArray);
  } 
  
  $error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> [], "count" => 0);
  return $error;
}

function getSeriesByFilter($filter, $limit, $start, $order) {
  global $mysqli;
  
  if ($filter!="")
  {
    $queryString= "SELECT series.*, countries.name as countryName FROM series INNER JOIN countries ON series.countryId=countries.id   WHERE " . $filter;
    $queryString2= "SELECT COUNT(series.id) FROM series INNER JOIN countries ON series.countryId=countries.id   WHERE " . $filter;
  }else
  {
    $queryString= "SELECT series.*, countries.name as countryName FROM series INNER JOIN countries ON series.countryId=countries.id";
    $queryString2= "SELECT COUNT(series.id) FROM series INNER JOIN countries ON series.countryId=countries.id";
  }
  $queryString= $queryString . " ORDER BY " . $order . " LIMIT ?,?";
//echo $queryString ;
if ($stmt = $mysqli->prepare($queryString2)) { 
  $stmt->execute();      // Execute query   
  $resultsCount = $stmt->get_result();
}  
$countRow = $resultsCount->fetch_row(); 
if ($stmt = $mysqli->prepare($queryString)) {
  $stmt->bind_param("ii", $start,$limit );     // Bind variables in order
  $stmt->execute();                               // Execute query
  $results = $stmt->get_result();
}

  $count=0;
 $myArray = array();
  while ($row = $results->fetch_array()) {
    $myArray[]=$row;
     $count++;
  }
  if ($countRow[0]>0)
  {        
   

//EMPIEZA
$series=$myArray;
$newSeries = array();
foreach($series as $serie)
{
  $serie=(object)$serie;       
  preg_match_all('/([a-zA-Z]+|[0-9]+)/',$serie->serieId,$matches);
  $serie->second="";
  $serie->third="";
  $serie->first="";
  if ($matches!=null)
  {
    if ($matches[0]!=null)
    {
      $serie->first= $matches[0][0];
      $serie->second="";
      $serie->third="";
      if (count($matches[0])>1)
      {
        $serie->second= $matches[0][1];
      }else
      {
        $serie->second="";
      }
    
      if (count($matches[0])>2)
      {
        $serie->third= $matches[0][2];
      }else
      {
        $serie->third= "";
      }
    }else
    {
      $serie->first=$serie->serieId;
    }
   

  }else
  {
    $serie->first=$serie->serieId;
  }
 
  $newSeries[]=$serie;

}

usort($newSeries, function ($item1, $item2) {
  return $item1->first <=> $item2->first;
});

$groupedSeries = array();

$lastGroup="";
$actualGroupSerie=array();
foreach($newSeries as $serie)          
{
    if ($serie->first!=$lastGroup)
    {
      //echo "ENTRA1";
      if (count($actualGroupSerie)>0)//VIENE DE UN GRUPO ANTERIOR. LO AÑADIMOS AL MULTI GRUPO.
      {
     //   echo "ENTRA2";
        $groupedSeries[]=$actualGroupSerie;
      }

      //NUEVO GRUPO ORDENAR
      $lastGroup=$serie->first;
      $actualGroupSerie=array();
      $actualGroupSerie[]=$serie;
    }else //NUEVO ELEMENTO. LO AÑADIMOS AL GRUPO
    {
   //   echo "ENTRA3";
      $actualGroupSerie[]=$serie;
    }
}

$groupedSeries[]=$actualGroupSerie;


$groupedSeriesResult= array();
foreach($groupedSeries as $groupedSerie)          
{
      usort($groupedSerie, function ($item1, $item2) {
        return $item1->second <=> $item2->second;
      });
      foreach($groupedSerie as $serie)          
      {
      $groupedSeriesResult[]=$serie;
      }

//FIN
}




//FIN



    
   return array("count" => $countRow[0] , "items"=> $groupedSeriesResult, "query" => $queryString);
  } 
  
  $error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> [], "count" => 0 , "query" => $queryString);
  return $error;
}
function getTableDatByORDER($table,$filter, $limit, $start, $order) {
  global $mysqli;
  
  if ($filter!="")
  {
    $queryString= "SELECT * FROM " . $table . "  WHERE " . $filter;
    $queryString2= "SELECT COUNT(id) FROM " . $table . " WHERE " . $filter;
  }else
  {
    $queryString= "SELECT * FROM " . $table ;
    $queryString2= "SELECT COUNT(id) FROM " . $table;
  }
  $queryString= $queryString . " ORDER BY " . $order . " LIMIT ?,?";
//echo $queryString . "--FIN";
if ($stmt = $mysqli->prepare($queryString2)) { 
  $stmt->execute();      // Execute query   
  $resultsCount = $stmt->get_result();
}  
$countRow = $resultsCount->fetch_row(); 
if ($stmt = $mysqli->prepare($queryString)) {
  $stmt->bind_param("ii", $start,$limit );     // Bind variables in order
  $stmt->execute();                               // Execute query
  $results = $stmt->get_result();
}

  $count=0;
 $myArray = array();
  while ($row = $results->fetch_array()) {
    $myArray[]=$row;
     $count++;
  }
  if ($countRow[0]>0)
  {        
   
   return array("count" => $countRow[0] , "items"=> $myArray);
  } 
  
  $error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> [], "count" => 0);
  return $error;
}

function getTableData2($table,$filter, $limit, $start) {
  global $mysqli;
  
  if ($filter!="")
  {
    $queryString= "SELECT * FROM " . $table . "  WHERE " . $filter;
    $queryString2= "SELECT COUNT(id) FROM " . $table . " WHERE " . $filter;
  }else
  {
    $queryString= "SELECT * FROM " . $table ;
    $queryString2= "SELECT COUNT(id) FROM " . $table;
  }
  $queryString= $queryString . " ORDER BY id LIMIT ?,?";
//echo $queryString . "--FIN";
if ($stmt = $mysqli->prepare($queryString2)) { 
  $stmt->execute();      // Execute query   
   $stmt->bind_result($auxCount);

    /* fetch values */
    while ($stmt->fetch()) {
        $resultsCount=$auxCount;
    }
//  $resultsCount = $stmt->get_result();
}  
//$countRow = $resultsCount->fetch_row(); 
if ($stmt = $mysqli->prepare($queryString)) {
  $stmt->bind_param("ii", $start,$limit );     // Bind variables in order
  $stmt->execute();                               // Execute query
//  $results = $stmt->get_result();
   $stmt->bind_result($auxResult);

  $count=0;
 $myArray = array();
    /* fetch values */
    while ($stmt->fetch()) {
       
		   $myArray[]=$auxResult;
     $count++;
    } 
}


  if ($countRow[0]>0)
  {        
   
   return array("count" => $countRow[0] , "items"=> $myArray);
  } 
  
  $error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> [], "count" => 0);
  return $error;
}
function bulkUpdateStatus($extraData,$status)
{
  global $mysqli;

  $ids= explode(",",$extraData);
  $insertQuery="";  
  foreach($ids as $id)
  {
          $insertQuery = $insertQuery . "(" . $id . "," . $status . "),";

  }
  $insertQuery=substr_replace($insertQuery ,"",-1);
  $queryString= "INSERT into bills (id, sellActive)  VALUES " . $insertQuery . " ON DUPLICATE KEY UPDATE sellActive = VALUES(sellActive)";

  $mysqli->query($queryString);
  //echo $queryString;
  $affectedRows=$mysqli->affected_rows;
  if ($affectedRows>0)
  {
      $myArray = array("id" => 1, "message" => "Se ha actualizado correctamente.");
      return $myArray;
  }else
  {
      $myArray = array("id" => -1, "message" => "Error al actualizar los billetes en la base de datos. Err: " . $mysqli->error);
      return $myArray;
  }
 
}
function bulkUpdateStatusPrice($extraData,$status)
{
  global $mysqli;

  //$ids . "|||" . $usersId . "|||" . $prices;
  $aux1= explode("|||",$extraData);
  $ids=$aux1[0];
  $prices=$aux1[1];



  $ids= explode(",",$ids);
  $prices=explode(",",$prices);
  $insertQuery="";  
  $pos=0;
  foreach($ids as $id)
  {
          $insertQuery = $insertQuery . "(" . $id . "," . $status . "," . $prices[$pos] . "),";
          $pos++;
  }
  $insertQuery=substr_replace($insertQuery ,"",-1);
  $queryString= "INSERT into bills (id, sellActive,sellPrice)  VALUES " . $insertQuery . " ON DUPLICATE KEY UPDATE sellActive = VALUES(sellActive), sellPrice=VALUES(sellPrice)";
  
  $mysqli->query($queryString);
  
  $affectedRows=$mysqli->affected_rows;
  if ($affectedRows>0)
  {
      $myArray = array("id" => 1, "message" => "Se ha actualizado correctamente.");
      return $myArray;
  }else
  {
      $myArray = array("id" => -1, "message" => "Error al actualizar los billetes en la base de datos. Err: " . $mysqli->error);
      return $myArray;
  }
 
}
function bulkDelete($extraData)
{
  global $mysqli;
  $queryString= "DELETE from bills WHERE id IN (" . $extraData . ")" ;
  $mysqli->query($queryString);
  //echo $queryString;
  $affectedRows=$mysqli->affected_rows;
  if ($affectedRows>0)
  {
      $myArray = array("id" => 1, "message" => "Se ha eliminado correctamente.");
      return $myArray;
  }else
  {
      $myArray = array("id" => -1, "message" => "Error al eliminar los billetes en la base de datos. Err: " . $mysqli->error);
      return $myArray;
  }
 
}
function bulkBills($userId,$countryId,$serieId, $subSerieId, $purchaseDate,$publicNotes,$privateNotes,$sellPrice, $sellActive,$purchasePrice,$restored,$errorNote,$extraData)
{
  $lineCount=0;


  if ($purchasePrice=="")
  {
    $purchasePrice="NULL";
  }

  global $mysqli;

  $queryString="INSERT INTO bills (id, ownerId,countryId, serieId, subSerieId,grade,frontSerie,backSerie,purchaseDate,publicNotes,privateNotes,sellPrice,sellActive,purchasePrice,numSerie,restored,errorNote) VALUES ";
  $lines= explode("***",$extraData);
  foreach($lines as $line)
  {

    $auxLine= explode("-",$line);
    $front=$auxLine[0];
    $ini=$auxLine[1];
    $end=$auxLine[2];
    $back=$auxLine[3];
    $grade=$auxLine[4];   
    $newSellPrice=$sellPrice;
    if ($auxLine[5]!="")
    {
      $newSellPrice=$auxLine[5];
    }
    if ($newSellPrice=="")
    {
      $newSellPrice="NULL";
    }
    $newPublicNotes=$auxLine[6];
    if ($auxLine[6]!="")
    {
    //  $newPublicNotes=$auxLine[6];
    }
    
    if (strlen($end)>0) //SON VARIOS
    {

      $iniNumber= intval($ini);
      $endNumber= intval($end);
      $charCount=strlen($ini);


      for ($x = $iniNumber; $x <= $endNumber; $x++) {
        if ($lineCount<100)
        {
    
          $actualCharCount=strlen(strval($x));
          $diff= $charCount-$actualCharCount;
          $ceros="";
          for ($z=1; $z<=$diff; $z++)
          {
            $ceros=$ceros . "0";
          }
      
         $queryString= $queryString . "  (NULL," . $userId . "," . $countryId . "," . $serieId . "," . $subSerieId . "," . $grade . ",'" . $front .
                   "','" . $back . "','" .  $purchaseDate . "','" . $newPublicNotes . "','" . $privateNotes . "'," . $newSellPrice . "," . $sellActive . ","
           . $purchasePrice . ",'" . $ceros. $x . "'," . $restored . "," . $errorNote . "),";
        
         // $queryString= $queryString . "PEP";
           
      

        }
        
         $lineCount++;
      }
    }else// ES UNO
    {
      if ($lineCount<100)
      {
        
        $queryString= $queryString . "  (NULL," . $userId . "," . $countryId . "," . $serieId . "," . $subSerieId . "," . $grade . ",'" . $front .
        "','" . $back . "','" .  $purchaseDate . "','" . $newPublicNotes . "','" . $privateNotes . "'," . $newSellPrice . "," . $sellActive . ","
         . $purchasePrice . ",'" . $ini . "'," . $restored . "," . $errorNote . "),";
      }
      $lineCount++;
    }

   
  }

  $queryString=trim($queryString,",");

  //$myArray = array("id" =>15, "message" => "Se ha insertado un nuevo billete correctamente.", "sql" => $queryString);
  //return $myArray;
   // echo $queryString;
    $mysqli->query($queryString);


    $id=$mysqli->insert_id;
//$id=1;
    if ($id>0)
    {
    
      $myArray = array("id" => $id, "message" => "Se ha insertado un nuevo billete correctamente.", "sql" => $queryString);
      return $myArray;
    }else
    {
      $myArray = array("id" => -1, "message" => "Error al insertar el billete en la base de datos.", "sql" => $queryString);
      return $myArray;
    }  

}
function createInteraction($billId,$userId,$userId2,$option){
  
  global $mysqli;

    $queryString= "INSERT INTO interactions2 (id, billsIds, status, requesterId,receptorId,shipmentRules)
    VALUES (NULL,'" .  $billId . "',-1," . $userId . "," . $userId2 . "," . $option . ")";
    
   // echo $queryString;

    if ($stmt = $mysqli->prepare($queryString)) 
    {
      $stmt->execute();                               // Execute query    
    }
     $id=$mysqli->insert_id;
    if ($id>0)
    {
    
      $myArray = array("id" => $id, "message" => "Se ha insertado una nueva interaccion correctamente.");
      return $myArray;
    }else
    {
      $myArray = array("id" => -1, "message" => "Error al insertar la interaccion en la base de datos.");
      return $myArray;
    }  

}
function updateExpertReview($id, $ownerId, $countryId, $serieId, $subSerieId, $grade, $frontSerie, $numSerie, $backSerie, $centering, $holes, $paper, $smell, $manipulation, $note)
{
  global $mysqli;
  
  $queryString= "UPDATE expertReviews SET serieId=? , subSerieId=?, countryId=?, grade=?,
  frontSerie=?, numSerie=?, backSerie=?,  centering=?, holes=?, paper=?, smell=?, manipulation=?, 
    note=? WHERE id=?";
  

    if ($stmt = $mysqli->prepare($queryString)) 
    {
      $stmt->bind_param("iiiisssiiiiisi", $serieId, $subSerieId,$countryId,$grade,$frontSerie, $numSerie,$backSerie,
      $centering,$holes,$paper,$smell,
      $manipulation, $note,$id);     // Bind variables in order
      $stmt->execute();                               // Execute query    
    //  echo "LLEGA";
    }
    $affectedRows=$mysqli->affected_rows;
    //echo "LLEGA2";
    if ($affectedRows>0)
    {
      //echo "LLEGA3";
        $myArray = array("id" => $id, "message" => "Se ha actualizado el review correctamente.");
        return $myArray;
    }else
    {
      //echo "LLEGA4";
          $myArray = array("id" => -1, "message" => "Error al actualizar el review en la base de datos. Err: " . $mysqli->error);
        return $myArray;
    }
}
function createExpertReview($id, $ownerId, $countryId, $serieId, $subSerieId, $grade, $frontSerie, $numSerie, $backSerie, $centering, $holes, $paper, $smell, $manipulation, $note)
{
  global $mysqli;
  global $baseUrl;
  //INSERT INTO bills (id, ownerId,countryId, serieId, subSerieId,grade,frontSerie,backSerie,purchaseDate,publicNotes,privateNotes,sellPrice, sellActive,purchasePrice,numSerie,restored,errorNote,replacement,specimen,proof,billYear) VALUES (NULL,6,509,93786,-1,-1,'','','','','',,-1,,'',false,,false,false,false,)
if ((is_null($grade)) || ($grade==""))
{
  $grade="NULL";
}
if ((is_null($centering)) || ($centering==""))
{
  $centering="NULL";
}
if ((is_null($holes)) || ($holes==""))
{
  $holes="NULL";
}
if ((is_null($paper)) || ($paper==""))
{
  $paper="NULL";
}
if ((is_null($smell)) || ($smell==""))
{
  $smell="NULL";
}
if ((is_null($manipulation)) || ($manipulation==""))
{
  $manipulation="NULL";
}

    $queryString= "INSERT INTO expertReviews (id, ownerId, countryId, serieId, subSerieId, grade, frontSerie, numSerie, backSerie, centering, holes, paper, smell, manipulation, note) 
    VALUES (NULL," . $ownerId . "," . $countryId . "," . $serieId . "," . $subSerieId . "," . $grade . ",'" . $frontSerie . "','" . $numSerie . "','" . $backSerie . "'," .
     $centering . "," . $holes . "," . $paper . "," . $smell . "," . $manipulation .   ",'" . $note . "')";
  

    //echo $queryString;
    $mysqli->query($queryString);
    $id=$mysqli->insert_id;
    if ($id>0)
    {
    
      $myArray = array("id" => $id, "message" => "Se ha insertado un nuevo experte review correctamente.");
      return $myArray;
    }else
    {
      $myArray = array("id" => -1, "message" => "Error al insertar el experte review en la base de datos.");
      return $myArray;
    }  

}
function createBill($id,$ownerId,$countryId,$serieId, $subSerieId,$grade,$frontSerie,$backSerie,$numSerie
,$purchaseDate,$publicNotes,$privateNotes,$sellPrice,
$sellActive,$purchasePrice,$restored,$errorNote,$replacement,$specimen,$proof,$false,$year)
{
  global $mysqli;
  global $baseUrl;
  //INSERT INTO bills (id, ownerId,countryId, serieId, subSerieId,grade,frontSerie,backSerie,purchaseDate,publicNotes,privateNotes,sellPrice, sellActive,purchasePrice,numSerie,restored,errorNote,replacement,specimen,proof,billYear) VALUES (NULL,6,509,93786,-1,-1,'','','','','',,-1,,'',false,,false,false,false,)
if ((is_null($grade)) || ($grade==""))
{
  $grade="NULL";
}
if ((is_null($sellPrice)) || ($sellPrice==""))
{
  $sellPrice="NULL";
}
if ((is_null($sellActive)) || ($sellActive==""))
{
  $sellActive="NULL";
}
if ((is_null($purchasePrice)) || ($purchasePrice==""))
{
  $purchasePrice="NULL";
}
if ((is_null($restored)) || ($restored==""))
{
  $restored="NULL";
}
if ((is_null($errorNote)) || ($errorNote==""))
{
  $errorNote="NULL";
}
if ((is_null($replacement)) || ($replacement==""))
{
  $replacement="NULL";
}
if ((is_null($specimen)) || ($specimen==""))
{
  $specimen="NULL";
}
if ((is_null($proof)) || ($proof==""))
{
  $proof="NULL";
}
if ((is_null($false)) || ($false==""))
{
  $false="NULL";
}
if ((is_null($year)) || ($year==""))
{
  $year="NULL";
}
    $queryString= "INSERT INTO bills (id, ownerId,countryId, serieId, subSerieId,grade,frontSerie,backSerie,purchaseDate,publicNotes,privateNotes,sellPrice,
    sellActive,purchasePrice,numSerie,restored,errorNote,replacement,specimen,proof,falseBill,billYear) 
    VALUES (NULL," . $ownerId . "," . $countryId . "," . $serieId . "," . $subSerieId . "," . $grade . ",'" . $frontSerie . "','" . $backSerie . "','" .
  $purchaseDate . "','" . $publicNotes . "','" . $privateNotes . "'," . $sellPrice . "," . $sellActive . "," . $purchasePrice . ",'" . $numSerie . "'," 
  . $restored . "," . $errorNote . "," . $replacement . "," . $specimen . "," . $proof . "," .$false . "," . $year . ")";
  

 //   echo $queryString;
    $mysqli->query($queryString);
    $id=$mysqli->insert_id;
    if ($id>0)
    {
    
      $myArray = array("id" => $id, "message" => "Se ha insertado un nuevo billete correctamente.");
      return $myArray;
    }else
    {
      $myArray = array("id" => -1, "message" => "Error al insertar el billete en la base de datos.");
      return $myArray;
    }  

}
function removeCollection($userId,$collectionId)
{
  global $mysqli;
    $queryString= "DELETE FROM usersCollections WHERE userId=" . $userId . " 
    AND collectionId=" . $collectionId; 
    $mysqli->query($queryString);
    //echo $queryString;
    $affectedRows=$mysqli->affected_rows;
    if ($affectedRows>0)
    {
        $myArray = array("id" => 1, "message" => "Se ha eliminado correctamente.");
        return $myArray;
    }else
    {
        $myArray = array("id" => -1, "message" => "Error al eliminar el turno en la base de datos. Err: " . $mysqli->error);
        return $myArray;
    }
}
function addCollection($userId,$collectionId)
{
  global $mysqli;
  
    $queryString= "INSERT INTO usersCollections (userId,collectionId) VALUES (" . $userId . "," . $collectionId . ")";
    
   if ($mysqli->query($queryString))
   {
     $id=1;
   }else
{
  $id=0;
}

    if ($id>0)
    {
 
      $myArray = array("id" => $id, "message" => "Se ha insertado una nueva coleccion correctamente.");      
      return $myArray;
    }else
    {
      $myArray = array("id" => -1, "message" => "Error al insertar la coleccion en la base de datos.");
      return $myArray;
    }    
}
function removeCountryCollection($userId,$collectionId)
{
  global $mysqli;
    $queryString= "DELETE FROM usersCountriesCollections WHERE userId=" . $userId . " 
    AND countryId=" . $collectionId; 
    $mysqli->query($queryString);
    //echo $queryString;
    $affectedRows=$mysqli->affected_rows;
    if ($affectedRows>0)
    {
        $myArray = array("id" => 1, "message" => "Se ha eliminado correctamente.");
        return $myArray;
    }else
    {
        $myArray = array("id" => -1, "message" => "Error al eliminar el turno en la base de datos. Err: " . $mysqli->error);
        return $myArray;
    }
}
function addCountryCollection($userId,$collectionId)
{
  global $mysqli;
  
    $queryString= "INSERT INTO usersCountriesCollections (userId,countryId) VALUES (" . $userId . "," . $collectionId . ")";
    
   if ($mysqli->query($queryString))
   {
     $id=1;
   }else
{
  $id=0;
}

    if ($id>0)
    {
 
      $myArray = array("id" => $id, "message" => "Se ha insertado una nueva coleccion correctamente.");      
      return $myArray;
    }else
    {
      $myArray = array("id" => -1, "message" => "Error al insertar la coleccion en la base de datos.");
      return $myArray;
    }    
}

function createArticle($title)
{
  global $mysqli;
  $canonical=toCanonical($title);
  $queryString= "INSERT INTO blog (id, title, canonical) VALUES (NULL, '" . $title . "','" . $canonical . "')";
  
 $mysqli->query($queryString);
  $id=$mysqli->insert_id;
 
  if ($id>0)
  {

    $myArray = array("id" => $id, "message" => "Se ha insertado una nueva articulo correctamente.");      
    return $myArray;
  }else
  {
    $myArray = array("id" => -1, "message" => "Error al insertar la articulo en la base de datos.");
    return $myArray;
  }  
}
function createCollection($name,$ownerId)
{
  global $mysqli;
  
    $queryString= "INSERT INTO collections (id, name, ownerId) VALUES (NULL, '" . $name . "'," . $ownerId . ")";
    
   $mysqli->query($queryString);
    $id=$mysqli->insert_id;
   
    if ($id>0)
    {
 
      $myArray = array("id" => $id, "message" => "Se ha insertado una nueva coleccion correctamente.");      
      return $myArray;
    }else
    {
      $myArray = array("id" => -1, "message" => "Error al insertar la coleccion en la base de datos.");
      return $myArray;
    }  
}
function registerUser($name,$email, $pass)
{
    global $mysqli;
    global $baseUrl;
    if (strlen($name)<1)
    {
      $myArray = array("id" => -1, "message" => "El nombre es obligatorio");
      return $myArray;
    }
    if (strlen($email)<1)
    {
      $myArray = array("id" => -1, "message" => "El email es obligatorio");
      return $myArray;
    }
    if (strlen($pass)<1)
    {
      $myArray = array("id" => -1, "message" => "El password es obligatorio");
      return $myArray;
    }
      $name=utf8_decode($name);
      $email=utf8_decode($email);
      $pass=utf8_decode($pass);
      $queryString= "INSERT INTO users (id, name, pass, email,active) VALUES (NULL, '" . $name . "', '" . $pass . "','" . $email . "',0)";
      
      //echo $queryString;
      $mysqli->query($queryString);
      $id=$mysqli->insert_id;
      if ($id>0)
      {
        $msg="<p>Pulse el siguiente enlace o copialo en tu navegador para activar el usuario</p><a href='" . $baseUrl . "/activateUser.php' target='blank'>Activar</a>";

        //mail($email,"Turnminator",$msg);
        $myArray = array("id" => $id, "message" => "Se ha insertado un nuevo usuario correctamente.");
        return $myArray;
      }else
      {
        $myArray = array("id" => -1, "message" => "Error al insertar el usuario en la base de datos.");
        return $myArray;
      }  
}
 
function updateUser($id,$name,$surnames,$phone,$shippingRules,$shippingAddress,$status,$nickname,$currency,$payment)
{
    global $mysqli;
   

    $queryString= "UPDATE users SET name=?, surnames=?,phone=?,shippingAddress=?,shippingRules=?, active=?, nickname=?, currency=? , payment=?  WHERE id=?";

      if ($stmt = $mysqli->prepare($queryString)) 
      {
        $stmt->bind_param("sssssisssi", $name,$surnames,$phone,$shippingAddress,$shippingRules,$status,$nickname,$currency, $payment,$id);     // Bind variables in order
        $stmt->execute();                               // Execute query    
      }
      $affectedRows=$mysqli->affected_rows;
      if ($affectedRows>0)
      {
          $myArray = array("id" => $id, "message" => "Se ha actualizado el usuario correctamente.");
          return $myArray;
      }else
      {
            $myArray = array("id" => -1, "message" => "Error al actualizar el usuario en la base de datos. Err: " . $mysqli->error);
          return $myArray;
      }
}


function updatePasswordAdmin($id,$newPass,$table)
{
      global $mysqli;      
      
      if (strlen($newPass)<1)
      {
         $myArray = array("id" => -1, "message" => "La contraseña es obligatoria");
          return $myArray;
      }
      $queryString= "UPDATE " . $table . " SET pass=? "
                . " WHERE id=?";
        

            
      if ($stmt = $mysqli->prepare($queryString)) 
      {
        $stmt->bind_param("si", $newPass,$id);     // Bind variables in order
        $stmt->execute();                               // Execute query    
      }

      $affectedRows=$mysqli->affected_rows;
      if ($affectedRows>0)
      {
        $myArray = array("id" => $id, "message" => "Se ha actualizado la contrasena correctamente.");
        return $myArray;
      }else
      {
        $myArray = array("id" => -1, "message" => "La contrasena no es correcta.");
        return $myArray;
      } 
}
function updateMyPendingInteractions($userId)
{
  global $mysqli;
  
  $queryString= "UPDATE interactions2 SET receptorViewed=1"
              . " WHERE receptorId=?";
      
  //echo "UPDATE interactions2 SET billsIds=? WHERE id=?";
          if ($stmt = $mysqli->prepare($queryString)) 
          {
            $stmt->bind_param("i", $userId);     // Bind variables in order
            $stmt->execute();                               // Execute query    
          }
  
          $affectedRows=$mysqli->affected_rows;

          $queryString= "UPDATE interactions2 SET requesterViewed=1"
          . " WHERE requesterId=?";

          if ($stmt = $mysqli->prepare($queryString)) 
          {
            $stmt->bind_param("i", $userId);     // Bind variables in order
            $stmt->execute();                               // Execute query    
          }
  
          $affectedRows=$mysqli->affected_rows;
     
}
function getMyPendingInteractions($userId)
{
  global $mysqli;  
  //$queryString = "SELECT COUNT(id) FROM `interactions2` WHERE (receptorId=? or requesterId=?) AND (status=0 OR status=4 OR status=3)";
  $queryString = "SELECT COUNT(id) FROM `interactions2` WHERE (receptorViewed=0 && receptorId=?) OR (requesterViewed=0 && requesterId=?)";
 
  if ($stmt = $mysqli->prepare($queryString)) {
     $stmt->bind_param("ii", $userId,$userId );     // Bind variables in order
     $stmt->execute();                               // Execute query
     $results = $stmt->get_result();
   }
 
   $count=0;
   $myArray = array();
   while ($row = $results->fetch_array()) {
     $myArray[]=$row;
      $count++;
   }
   if ($count>0)
   {        
    return array("id" => $count , "count"=> $myArray[0]);
   } 
   $error = array("id" => -1, "count"=>0, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> []);
   return $error;
}
function getBillsStats($userId)
{
  global $mysqli;  
  $queryString = "SELECT totalBilletesEnVenta, costeBilletesEnVenta, billetesVendidos ,totalInvertido
  FROM (SELECT SUM(sellPrice) as totalBilletesEnVenta, SUM(purchasePrice) as costeBilletesEnVenta FROM bills WHERE sellActive=1 AND ownerId=" 
  . $userId . ") as table1,
    (SELECT SUM(sellPrice) as billetesVendidos FROM billsOld WHERE ownerId=" . $userId . ") as table2,
    (SELECT SUM(purchasePrice) as totalInvertido FROM bills WHERE ownerId=" . $userId . ") as table3";
 
  if ($stmt = $mysqli->prepare($queryString)) {
    // $stmt->bind_param("ii", $start,$limit );     // Bind variables in order
     $stmt->execute();                               // Execute query
     $results = $stmt->get_result();
   }
 
   $count=0;
   $myArray = array();
   while ($row = $results->fetch_array()) {
     $myArray[]=$row;
      $count++;
   }
   if ($count>0)
   {        
    return array("id" => $count , "items"=> $myArray);
   } 
   $error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> []);
   return $error;
}
function getBillsStatsAdmin()
{
  global $mysqli;  
  $queryString = "SELECT totalBilletesEnVenta, costeBilletesEnVenta, billetesVendidos ,totalInvertido
  FROM (SELECT SUM(sellPrice) as totalBilletesEnVenta, SUM(purchasePrice) as costeBilletesEnVenta FROM bills WHERE sellActive=1) as table1,
    (SELECT SUM(sellPrice) as billetesVendidos FROM billsOld) as table2,
    (SELECT SUM(purchasePrice) as totalInvertido FROM bills) as table3";
 
  if ($stmt = $mysqli->prepare($queryString)) {
    // $stmt->bind_param("ii", $start,$limit );     // Bind variables in order
     $stmt->execute();                               // Execute query
     $results = $stmt->get_result();
   }
 
   $count=0;
   $myArray = array();
   while ($row = $results->fetch_array()) {
     $myArray[]=$row;
      $count++;
   }
   if ($count>0)
   {        
    return array("id" => $count , "items"=> $myArray);
   } 
   $error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> []);
   return $error;
}
function getStats()
{

  global $mysqli;  
  
  $queryString= "SELECT
  (SELECT COUNT(*) FROM series ) as series, 
  (SELECT COUNT(*) FROM users ) as users,
  (SELECT COUNT(*) FROM subSeries ) as subSeries";
  
  
  if ($stmt = $mysqli->prepare($queryString)) {
   // $stmt->bind_param("ii", $start,$limit );     // Bind variables in order
    $stmt->execute();                               // Execute query
    $results = $stmt->get_result();
  }

  $count=0;
  $myArray = array();
  while ($row = $results->fetch_array()) {
    $myArray[]=$row;
     $count++;
  }
  if ($count>0)
  {        
   return array("count" => $count , "items"=> $myArray);
  } 
  $error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> []);
  return $error;
  
}

function login($email,$pass,$table) {
  global $mysqli;
      
  $queryString="SELECT * FROM " . $table . " WHERE email='" . $email . "' AND pass='" . $pass . "'";
  $results = $mysqli->query($queryString); 
 while($row = $results->fetch_array()) {
     $myArray = array("id" => $row["id"], "item" => $row);
     return $myArray;   
  }
  
  $myArray = array("id" => 0, "message" => "Usuario o contrasena invalidos.");
  return $myArray;


}
//BORRAR SALVO GETTABLEDATA








function getChatsByUserId($userId)
{
  global $mysqli;  
  
  $queryString= "select DISTINCT users.* from users inner join messages ON users.id=messages.userId OR users.Id= messages.userId2 where userId=? OR userId2=?" ;
  
  
  
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("ii", $userId,$userId);     // Bind variables in order
    $stmt->execute();                               // Execute query
    $results = $stmt->get_result();
  }

  $count=0;
  $myArray = array();
  while ($row = $results->fetch_array()) {
    if ($row[0]!=$userId)
    {
    $myArray[]=$row;
     $count++;
    }
  }
  if ($count>0)
  {        
   return array("count" => $count , "items"=> $myArray);
  } 
  $error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> []);
  return $error;
  
}

function getCalendarUsers($calendarId)
{
  global $mysqli;  
  
  $queryString= "SELECT users.*, calendarUsers.* FROM  users INNER JOIN calendarUsers  ON users.id=calendarUsers.userId WHERE calendarUsers.calendarId=" . $calendarId;
  
  
  
  if ($stmt = $mysqli->prepare($queryString)) {
  //  $stmt->bind_param("ii", $start,$limit );     // Bind variables in order
    $stmt->execute();                               // Execute query
    $results = $stmt->get_result();
  }

  $count=0;
  $myArray = array();
  while ($row = $results->fetch_array()) {
    $myArray[]=$row;
     $count++;
  }
  if ($count>0)
  {        
   return array("count" => $count , "items"=> $myArray);
  } 
  $error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> []);
  return $error;
  
}

function getBillsBySerie($serieId)
{  

  global $mysqli;

  $queryString= "SELECT DISTINCT bills.*, series.serieId as serieIdText, series.billValue, 
   series.dateText,  subSeries.subSerieId as subSerieIdText, countries.name as countryName,
    grades.es as gradeES, grades.en as gradeEN, users.name as userName, users.surnames, users.nickname FROM bills 
  LEFT JOIN series ON bills.serieId=series.id  
  LEFT JOIN subSeries ON bills.subSerieId=subSeries.id  
  LEFT JOIN countries ON bills.countryId=countries.id
  LEFT JOIN users ON bills.ownerId=users.id
  LEFT JOIN grades ON bills.grade=grades.id
  WHERE  series.id=? ORDER BY bills.sellActive ASC, subSeries.subSerieId ASC, bills.frontSerie ASC , bills.numSerie ASC , bills.backSerie ASC ";  
  
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("i", $serieId);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
$count=0;
$myArray = array();
  while ($row = $results->fetch_array()) {  
    $myArray[]=$row;
    $count++;
  }
  if ($count>0)
  {

    return array("id"=> 1 ,"count" =>$count, "items"=> $myArray);
   
  } 
  $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
  return $error;


}
function getBillsBySerieAndFilter($serieId,$subSerieId,$grade,$numSerie,$country,$status,$userId)
{
  global $mysqli;

  $queryString= "SELECT DISTINCT bills.*, series.serieId as serieIdText, series.billValue, 
   series.dateText,  subSeries.subSerieId as subSerieIdText, countries.name as countryName,
    grades.es as gradeES, grades.en as gradeEN, users.name as userName, users.surnames, users.nickname, COUNT(expertReviews.id) as countReviews FROM bills 
  LEFT JOIN series ON bills.serieId=series.id  
  LEFT JOIN subSeries ON bills.subSerieId=subSeries.id  
  LEFT JOIN countries ON bills.countryId=countries.id
  LEFT JOIN users ON bills.ownerId=users.id
  LEFT JOIN grades ON bills.grade=grades.id
  LEFT JOIN expertReviews ON bills.serieId=expertReviews.serieId AND bills.subSerieId=expertReviews.subSerieId
  AND bills.frontSerie=expertReviews.frontSerie AND bills.numSerie=expertReviews.numSerie AND bills.backSerie=expertReviews.backSerie
  WHERE  1=1 ";  

/*
SELECT DISTINCT bills.*, series.serieId as serieIdText, series.billValue, 
   series.dateText,  subSeries.subSerieId as subSerieIdText, countries.name as countryName,
    grades.es as gradeES, grades.en as gradeEN, users.name as userName, users.surnames, users.nickname, COUNT(expertReviews.id)  FROM bills 
  LEFT JOIN series ON bills.serieId=series.id  
  LEFT JOIN subSeries ON bills.subSerieId=subSeries.id  
  LEFT JOIN countries ON bills.countryId=countries.id
  LEFT JOIN users ON bills.ownerId=users.id
  LEFT JOIN grades ON bills.grade=grades.id
  LEFT JOIN expertReviews ON bills.serieId=expertReviews.serieId AND bills.subSerieId=expertReviews.subSerieId
  AND bills.frontSerie=expertReviews.frontSerie AND bills.numSerie=expertReviews.numSerie AND bills.backSerie=expertReviews.backSerie
  WHERE  1=1 GROUP BY   bills.id, bills.ownerId, bills.countryId, bills.serieId, bills.subSerieId, bills.grade, bills.frontSerie, bills.numSerie, bills.backSerie, bills.purchasePrice, bills.sellerId, bills.purchaseDate, bills.soldDate, bills.publicNotes, bills.privateNotes, bills.sellPrice, bills.sellActive, bills.restored, bills.errorNote, bills.replacement, bills.specimen, bills.proof, bills.billYear, bills.falseBill, bills.managingFor,series.serieId, series.billValue, 
   series.dateText,  subSeries.subSerieId, countries.name,
    grades.es, grades.en, users.name, users.surnames, users.nickname
*/
  if (($userId!=null) || ($userId!=""))
  {
  
    if ($userId>0)
    {
      $queryString = $queryString . " AND bills.ownerId=" . $userId;    
    }
      
  }



    if (($serieId!=null) || ($serieId!=""))
    {
    
        $queryString = $queryString . " AND bills.serieId=" . $serieId;    
    }
    
    if ($country=="undefined")
    {
      $queryString = $queryString . " AND bills.countryId=-1";    
    }else{
      if (($country!=null) || ($country!=""))
      {     
           if ($country>1)
          {
            $queryString = $queryString . " AND bills.countryId=" . $country;    
          }
      }
    }
    
    
    
      if (($numSerie!=null) || ($numSerie!=""))
      {
        if ($numSerie>1)
        {
          $queryString = $queryString . " AND concat(bills.frontSerie,bills.numSerie,bills.backSerie)  LIKE '%" . $numSerie . "%'";  
        }
        
      }
      if (($grade!=null) || ($grade!=""))
      {
        if ($grade>-1)
        {
          $queryString = $queryString . " AND grade=" . $grade;  
        }
        
      }
      
    
      if (($status!=null) || ($status!=""))
      {
        if ($status>-1)
        {
          $queryString = $queryString . " AND sellActive=" . $status;  
        }
        
      }
    
      if ($subSerieId!=-1)
      {
        $queryString = $queryString .  " AND bills.subSerieId=" . $subSerieId;
      }
  
  
  $queryString = $queryString .  " GROUP BY bills.id, bills.ownerId, bills.countryId, bills.serieId, bills.subSerieId, bills.grade, bills.frontSerie, bills.numSerie, bills.backSerie, bills.purchasePrice, bills.sellerId, bills.purchaseDate, bills.soldDate, bills.publicNotes, bills.privateNotes, bills.sellPrice, bills.sellActive, bills.restored, bills.errorNote, bills.replacement, bills.specimen, bills.proof, bills.billYear, bills.falseBill, bills.managingFor,series.serieId, series.billValue, 
  series.dateText,  subSeries.subSerieId, countries.name,
   grades.es, grades.en, users.name, users.surnames, users.nickname";
//echo $queryString;
  if ($stmt = $mysqli->prepare($queryString)) {
    
   // $stmt->bind_param("i", $userId);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
    $count=0;
    $myArray = array();
  while ($row = $results->fetch_array()) {  
    $myArray[]=$row;

    $count++;
  }
  if ($count>0)
  {

    return array("count" =>$count, "items"=> $myArray );
   
  } 
  $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error, "sql"=> $queryString);
  return $error;

}
function getBillsBySerieAndUserAndFilter($serieId,$subSerieId,$userId,$grade,$numSerie, $country)
{
  global $mysqli;

  $queryString= "SELECT DISTINCT bills.*, series.serieId as serieIdText, series.billValue, 
   series.dateText,  subSeries.subSerieId as subSerieIdText, countries.name as countryName,
    grades.es as gradeES, grades.en as gradeEN, users.name as userName, users.surnames FROM bills 
  LEFT JOIN series ON bills.serieId=series.id  
  LEFT JOIN subSeries ON bills.subSerieId=subSeries.id  
  LEFT JOIN countries ON bills.countryId=countries.id
  LEFT JOIN users ON bills.ownerId=users.id
  LEFT JOIN grades ON bills.grade=grades.id
  WHERE  (bills.sellActive=1 or bills.sellActive=0 or bills.sellActive=3) AND bills.ownerId=?";  

if (($serieId!=null) || ($serieId!=""))
{

    $queryString = $queryString . " AND bills.serieId=" . $serieId;    
}

if ($country=="undefined")
{
  $queryString = $queryString . " AND bills.countryId=-1";    
}else{
  if (($country!=null) || ($country!=""))
  {     
       if ($country>1)
      {
        $queryString = $queryString . " AND bills.countryId=" . $country;    
      }
  }
}



  if (($numSerie!=null) || ($numSerie!=""))
  {
    if ($numSerie>1)
    {
      $queryString = $queryString . " AND concat(bills.frontSerie,bills.numSerie,bills.backSerie)  LIKE '%" . $numSerie . "%'";  
    }
    
  }
  if (($grade!=null) || ($grade!=""))
  {
    if ($grade>-1)
    {
      $queryString = $queryString . " AND grade=" . $grade;  
    }
    
  }
  
  if ($subSerieId!=-1)
  {
    $queryString = $queryString .  " AND bills.subSerieId=" . $subSerieId;
  }


//echo $queryString;
  if ($stmt = $mysqli->prepare($queryString)) {
    
    $stmt->bind_param("i", $userId);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
    $count=0;
    $myArray = array();
  while ($row = $results->fetch_array()) {  
    $myArray[]=$row;

    $count++;
  }
  if ($count>0)
  {

    return array("count" =>$count, "items"=> $myArray );
   
  } 
  $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error, "sql"=> $queryString);
  return $error;

}

function getBillsBySerieAndUser($serieId,$subSerieId,$userId)
{
  global $mysqli;

  $queryString= "SELECT DISTINCT bills.*, series.serieId as serieIdText, series.billValue, 
   series.dateText,  subSeries.subSerieId as subSerieIdText, countries.name as countryName,
    grades.es as gradeES, grades.en as gradeEN, users.name as userName, users.surnames FROM bills 
  LEFT JOIN series ON bills.serieId=series.id  
  LEFT JOIN subSeries ON bills.subSerieId=subSeries.id  
  LEFT JOIN countries ON bills.countryId=countries.id
  LEFT JOIN users ON bills.ownerId=users.id
  LEFT JOIN grades ON bills.grade=grades.id
  WHERE  series.id=?  AND bills.ownerId=?";  
  if ($subSerieId!=-1)
  {
    $queryString = $queryString .  " AND subSeries.id=" . $subSerieId;
  }
  
  if ($stmt = $mysqli->prepare($queryString)) {
    
    $stmt->bind_param("ii", $serieId,$userId);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
$count=0;
$myArray = array();
  while ($row = $results->fetch_array()) {  
    $myArray[]=$row;
    $count++;
  }
  if ($count>0)
  {

    return array("count" =>$count, "items"=> $myArray);
   
  } 
  $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
  return $error;

}

function getBillsByFilter($limit,$start,$queryString)
{  

  global $mysqli;

  $queryString2="SELECT  COUNT(bills.id) as count FROM bills 
  LEFT JOIN series ON bills.serieId=series.id 
  LEFT JOIN subSeries ON bills.subSerieId=subSeries.id 
  LEFT JOIN countries ON bills.countryId=countries.id
  LEFT JOIN grades ON bills.grade=grades.id
  LEFT JOIN users ON bills.ownerId=users.id
   WHERE 1=1 " . $queryString ;
   
  $queryString= "SELECT bills.id, bills.grade, bills.frontSerie, bills.numSerie, bills.backSerie, bills.sellPrice, bills.sellActive,
   bills.restored, bills.errorNote,bills.replacement, bills.specimen, bills.proof, bills.publicNotes,bills.falseBill,
    series.serieId, series.billValue, series.dateText, series.printer,
   subSeries.subSerieId,  countries.name, series.id as realSerieId, subSeries.id as realSubSerieId, grades.es, grades.en, users.nickname FROM bills 
   LEFT JOIN series ON bills.serieId=series.id 
   LEFT JOIN subSeries ON bills.subSerieId=subSeries.id 
   LEFT JOIN countries ON bills.countryId=countries.id
   LEFT JOIN grades ON bills.grade=grades.id
   LEFT JOIN users ON bills.ownerId=users.id
    WHERE 1=1 " . $queryString;  
    $queryString= $queryString . " ORDER BY bills.id DESC LIMIT ?,?";

    if ($stmt = $mysqli->prepare($queryString2)) { 

      $stmt->execute();      // Execute query   
      $resultsCount = $stmt->get_result();
    }  
    $auxCount=0;
    while ($row = $resultsCount->fetch_array()) {  
     
      $auxCount++;
    }
    
  
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("ii",$start,$limit);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
$count=0;
$myArray = array();
  while ($row = $results->fetch_array()) {  
    $myArray[]=$row;
    $count++;
  }
  if ($count>0)
  {

    return array("id"=>1, "count" =>$auxCount, "items"=> $myArray);
   
  } 
  $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
  return $error;


}
function nextSerie($id)
{
//  SELECT * FROM foo WHERE id = (SELECT MIN(id) FROM foo WHERE id > 4)
  global $mysqli;

    $queryString= "SELECT series.*  FROM series  WHERE series.id= (SELECT MIN(id) FROM series WHERE id>?)";  
//echo "SELECT series.* FROM series INNER JOIN countries ON series.countryId=countries.id WHERE  series.serieId=$serieId AND countries.canonical=$countryCanonical";      

//echo $queryString;
    if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->bind_param("i", $id);     // Bind variables in order
      $stmt->execute();                               // Execute query    
      $results = $stmt->get_result();
    }
$count=0;
$myArray = array();
    while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
    }
    if ($count>0)
    {
	
      return array("id" => $myArray[0][0], "item"=> $myArray[0]);
     
    } 
    $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
    return $error;
 

}
function getGroupedBillsByFilter($limit,$start,$queryString)
{  

  global $mysqli;

  $queryString2="SELECT  COUNT(series.id) as count FROM bills 
  LEFT JOIN series ON bills.serieId=series.id 
  LEFT JOIN subSeries ON bills.subSerieId=subSeries.id 
  LEFT JOIN countries ON bills.countryId=countries.id
   WHERE " . $queryString . " GROUP BY series.serieId, series.billValue, series.dateText, subSeries.subSerieId, countries.name";   
  
  $queryString= "SELECT DISTINCT COUNT(bills.id) as count, MAX(bills.id) as maxId,series.serieId, series.billValue, series.dateText, subSeries.subSerieId,
   countries.name, countries.id as countryId, bills.serieId as realSerieId, bills.subSerieId as realSubSerieId FROM bills 
   LEFT JOIN series ON bills.serieId=series.id 
   LEFT JOIN subSeries ON bills.subSerieId=subSeries.id 
   LEFT JOIN countries ON bills.countryId=countries.id
    WHERE " . $queryString . " GROUP BY series.serieId, series.billValue, series.dateText, subSeries.subSerieId, countries.name, countries.id";  
    $queryString= $queryString . " ORDER BY countries.id ASC, series.serieId  ASC, subSeries.subSerieId ASC LIMIT ?,?";
    //return array("id"=>1, "count" =>$auxCount, "items"=> $groupedSeriesResult,  "sql"=>$queryString);
    if ($stmt = $mysqli->prepare($queryString2)) { 
  //    $stmt->bind_param("i", $userId);
      $stmt->execute();      // Execute query   
      $resultsCount = $stmt->get_result();
    }  
    $auxCount=0;
    while ($row = $resultsCount->fetch_array()) {  
     
      $auxCount++;
    }
    
  
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("ii", $start,$limit);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
$count=0;
$myArray = array();
  while ($row = $results->fetch_array()) {  
    $myArray[]=$row;
    $count++;
  }
  if ($count>0)
  {

    $newSeries = array();
    foreach($myArray as $serie)
    {
      $serie=(object) $serie;
      preg_match_all('/([a-zA-Z]+|[0-9]+)/',$serie->serieId,$matches);
      if ($matches!=null)
      {
        if ($matches[0]!=null)
        {
          $serie->first= $matches[0][0];
    
          if (count($matches[0])>1)
          {
            $serie->second= $matches[0][1];
          }else
          {
            $serie->second="";
          }
        
          if (count($matches[0])>2)
          {
            $serie->third= $matches[0][2];
          }else
          {
            $serie->third= "";
          }
        }else
        {
          $serie->first=$serie->serieId;
        }
       
    
      }else
      {
        $serie->first=$serie->serieId;
      }
     
      $newSeries[]=$serie;

    }

    usort($newSeries, function ($item1, $item2) {
      return $item1->first <=> $item2->first;
    });

    $groupedSeries = array();
  
    $lastGroup="";
    $actualGroupSerie=array();

    foreach($newSeries as $serie)          
  {
      if ($serie->first!=$lastGroup)
      {
        //echo "ENTRA1";
        if (count($actualGroupSerie)>0)//VIENE DE UN GRUPO ANTERIOR. LO AÑADIMOS AL MULTI GRUPO.
        {
       //   echo "ENTRA2";
          $groupedSeries[]=$actualGroupSerie;
        }
  
        //NUEVO GRUPO ORDENAR
        $lastGroup=$serie->first;
        $actualGroupSerie=array();
        $actualGroupSerie[]=$serie;
      }else //NUEVO ELEMENTO. LO AÑADIMOS AL GRUPO
      {
     //   echo "ENTRA3";
        $actualGroupSerie[]=$serie;
      }
  }


  $groupedSeries[]=$actualGroupSerie;       
  
  $groupedSeriesResult= array();
  foreach($groupedSeries as $groupedSerie)          
  {
        usort($groupedSerie, function ($item1, $item2) {
          return $item1->second <=> $item2->second;
        });
        foreach($groupedSerie as $serie)          
        {
          $groupedSeriesResult[]=$serie;
        
        }
  }
  
  //FIN

    return array("id"=>1, "count" =>$auxCount, "items"=> $groupedSeriesResult,  "sql"=>$queryString);
   
  } 
  $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error, "sql"=>$queryString);
  return $error;


}
function getGroupedBillsByFilter2($limit,$start,$queryString)
{  

  global $mysqli;

  $queryString2="SELECT  COUNT(series.id) as count FROM bills 
  LEFT JOIN series ON bills.serieId=series.id 
  LEFT JOIN subSeries ON bills.subSerieId=subSeries.id 
  LEFT JOIN countries ON bills.countryId=countries.id
   WHERE " . $queryString . " GROUP BY series.serieId, series.billValue, series.dateText, subSeries.subSerieId, countries.name";
   
  
  $queryString= "SELECT DISTINCT COUNT(bills.id) as count, series.serieId, series.billValue, series.dateText, subSeries.subSerieId,
   countries.name, countries.id as countryId, bills.serieId as realSerieId, bills.subSerieId as realSubSerieId FROM bills 
   LEFT JOIN series ON bills.serieId=series.id 
   LEFT JOIN subSeries ON bills.subSerieId=subSeries.id 
   LEFT JOIN countries ON bills.countryId=countries.id
    WHERE " . $queryString . " GROUP BY series.serieId, series.billValue, series.dateText, subSeries.subSerieId, countries.name, countries.id";  
    $queryString= $queryString . " ORDER BY countries.name ASC, series.serieId LIMIT ?,?";
//echo $queryString;
    if ($stmt = $mysqli->prepare($queryString2)) { 
      //$stmt->bind_param("i", $userId);
      $stmt->execute();      // Execute query   
      $resultsCount = $stmt->get_result();
    }  
    $auxCount=0;
    while ($row = $resultsCount->fetch_array()) {  
     
      $auxCount++;
    }
    
  
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("ii",$start,$limit);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
$count=0;
$myArray = array();
  while ($row = $results->fetch_array()) {  
    $myArray[]=$row;
    $count++;
  }
  if ($count>0)
  {

    $newSeries = array();
    foreach($myArray as $serie)
    {
      $serie=(object) $serie;
      preg_match_all('/([a-zA-Z]+|[0-9]+)/',$serie->serieId,$matches);
      if ($matches!=null)
      {
        if ($matches[0]!=null)
        {
          $serie->first= $matches[0][0];
    
          if (count($matches[0])>1)
          {
            $serie->second= $matches[0][1];
          }else
          {
            $serie->second="";
          }
        
          if (count($matches[0])>2)
          {
            $serie->third= $matches[0][2];
          }else
          {
            $serie->third= "";
          }
        }else
        {
          $serie->first=$serie->serieId;
        }
       
    
      }else
      {
        $serie->first=$serie->serieId;
      }
     
      $newSeries[]=$serie;

    }

    usort($newSeries, function ($item1, $item2) {
      return $item1->first <=> $item2->first;
    });

    $groupedSeries = array();
  
    $lastGroup="";
    $actualGroupSerie=array();

    foreach($newSeries as $serie)          
  {
      if ($serie->first!=$lastGroup)
      {
        //echo "ENTRA1";
        if (count($actualGroupSerie)>0)//VIENE DE UN GRUPO ANTERIOR. LO AÑADIMOS AL MULTI GRUPO.
        {
       //   echo "ENTRA2";
          $groupedSeries[]=$actualGroupSerie;
        }
  
        //NUEVO GRUPO ORDENAR
        $lastGroup=$serie->first;
        $actualGroupSerie=array();
        $actualGroupSerie[]=$serie;
      }else //NUEVO ELEMENTO. LO AÑADIMOS AL GRUPO
      {
     //   echo "ENTRA3";
        $actualGroupSerie[]=$serie;
      }
  }


  $groupedSeries[]=$actualGroupSerie;       
  
  $groupedSeriesResult= array();
  foreach($groupedSeries as $groupedSerie)          
  {
        usort($groupedSerie, function ($item1, $item2) {
          return $item1->second <=> $item2->second;
        });
        foreach($groupedSerie as $serie)          
        {
          $groupedSeriesResult[]=$serie;
        
        }
  }
  
  //FIN

    return array("id"=>1, "count" =>$auxCount, "items"=> $groupedSeriesResult,  "sql"=>$queryString);
   
  } 
  $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
  return $error;



}
function getExpertReviewsByBillData($countryId,$serieId,$subSerieId,$frontSerie,$numSerie,$backSerie)
{
  global $mysqli;


   
  
  $queryString= "SELECT DISTINCT expertReviews.*, users.nickname FROM expertReviews 
   LEFT JOIN series ON expertReviews.serieId=series.id 
   LEFT JOIN subSeries ON expertReviews.subSerieId=subSeries.id 
   LEFT JOIN countries ON expertReviews.countryId=countries.id
   LEFT JOIN users ON expertReviews.ownerId=users.id
    WHERE  expertReviews.countryId=? AND expertReviews.serieId=? 
    AND  expertReviews.subSerieId=? AND  expertReviews.frontSerie=? 
    AND  expertReviews.numSerie=? AND expertReviews.backSerie=?";
   
   $queryString2= "SELECT DISTINCT expertReviews.* FROM expertReviews 
   LEFT JOIN series ON expertReviews.serieId=series.id 
   LEFT JOIN subSeries ON expertReviews.subSerieId=subSeries.id 
   LEFT JOIN countries ON expertReviews.countryId=countries.id
    WHERE  expertReviews.countryId=$countryId AND expertReviews.serieId=$serieId
    AND  expertReviews.subSerieId=$subSerieId AND  expertReviews.frontSerie=$frontSerie 
    AND  expertReviews.numSerie=$numSerie AND expertReviews.backSerie=$backSerie";

    //echo $queryString2;
  
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("iiisss", $countryId,$serieId,$subSerieId,$frontSerie,$numSerie,$backSerie);    // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
$count=0;
$myArray = array();
  while ($row = $results->fetch_array()) {  
    $myArray[]=$row;
    $count++;
  }
  if ($count>0)
  {

    return array("id"=>1, "count" =>$auxCount, "items"=> $myArray,  "sql"=>$queryString);
   
  } 
  $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
  return $error;


}
function getExpertReviewsByUser($userId,$limit,$start,$whereQueryString)
{  

  global $mysqli;

  $queryString2="SELECT  COUNT(series.id) as count FROM expertReviews 
  LEFT JOIN series ON expertReviews.serieId=series.id 
  LEFT JOIN subSeries ON expertReviews.subSerieId=subSeries.id 
  LEFT JOIN countries ON expertReviews.countryId=countries.id
   WHERE  expertReviews.ownerId=? " . $whereQueryString . " GROUP BY expertReviews.id";
   //echo $queryString2;
  
  $queryString= "SELECT DISTINCT  series.serieId, series.billValue, series.dateText, subSeries.subSerieId,
   countries.name, countries.id as countryId, expertReviews.serieId as realSerieId, expertReviews.subSerieId as realSubSerieId, expertReviews.frontSerie, expertReviews.numSerie, expertReviews.backSerie, expertReviews.id FROM expertReviews 
   LEFT JOIN series ON expertReviews.serieId=series.id 
   LEFT JOIN subSeries ON expertReviews.subSerieId=subSeries.id 
   LEFT JOIN countries ON expertReviews.countryId=countries.id
    WHERE  expertReviews.ownerId=? " . $whereQueryString ;  
    $queryString= $queryString . " ORDER BY countries.name ASC, series.serieId, subSeries.subSerieId LIMIT ?,?";

    if ($stmt = $mysqli->prepare($queryString2)) { 
      $stmt->bind_param("i", $userId);
      $stmt->execute();      // Execute query   
      $resultsCount = $stmt->get_result();
    }  
    $auxCount=0;
    while ($row = $resultsCount->fetch_array()) {  
     
      $auxCount++;
    }
    
  
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("iii", $userId,$start,$limit);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
$count=0;
$myArray = array();
  while ($row = $results->fetch_array()) {  
    $myArray[]=$row;
    $count++;
  }
  if ($count>0)
  {

    return array("id"=>1, "count" =>$auxCount, "items"=> $myArray,  "sql"=>$queryString);
   
  } 
  $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
  return $error;


}
function getGroupedBillsByUser($userId,$limit,$start,$queryString)
{  

  global $mysqli;

  $queryString2="SELECT  COUNT(series.id) as count FROM bills 
  LEFT JOIN series ON bills.serieId=series.id 
  LEFT JOIN subSeries ON bills.subSerieId=subSeries.id 
  LEFT JOIN countries ON bills.countryId=countries.id
   WHERE (bills.sellActive=0 OR bills.sellActive=1 OR bills.sellActive=3) AND bills.ownerId=? " . $queryString . " GROUP BY series.serieId, series.billValue, series.dateText, subSeries.subSerieId, countries.name";
   
  
  $queryString= "SELECT DISTINCT COUNT(bills.id) as count, series.serieId, series.billValue, series.dateText, subSeries.subSerieId,
   countries.name, countries.id as countryId, bills.serieId as realSerieId, bills.subSerieId as realSubSerieId FROM bills 
   LEFT JOIN series ON bills.serieId=series.id 
   LEFT JOIN subSeries ON bills.subSerieId=subSeries.id 
   LEFT JOIN countries ON bills.countryId=countries.id
    WHERE (bills.sellActive=0 OR bills.sellActive=1 OR bills.sellActive=3) AND bills.ownerId=? " . $queryString . " GROUP BY series.serieId, series.billValue, series.dateText, subSeries.subSerieId, countries.name, countries.id";  
    $queryString= $queryString . " ORDER BY countries.name ASC, series.serieId, subSeries.subSerieId LIMIT ?,?";

    if ($stmt = $mysqli->prepare($queryString2)) { 
      $stmt->bind_param("i", $userId);
      $stmt->execute();      // Execute query   
      $resultsCount = $stmt->get_result();
    }  
    $auxCount=0;
    while ($row = $resultsCount->fetch_array()) {  
     
      $auxCount++;
    }
    
  
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("iii", $userId,$start,$limit);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
$count=0;
$myArray = array();
  while ($row = $results->fetch_array()) {  
    $myArray[]=$row;
    $count++;
  }
  if ($count>0)
  {

    $newSeries = array();
    foreach($myArray as $serie)
    {
      $serie=(object) $serie;
      preg_match_all('/([a-zA-Z]+|[0-9]+)/',$serie->serieId,$matches);
      if ($matches!=null)
      {
        if ($matches[0]!=null)
        {
          $serie->first= $matches[0][0];
    
          if (count($matches[0])>1)
          {
            $serie->second= $matches[0][1];
          }else
          {
            $serie->second="";
          }
        
          if (count($matches[0])>2)
          {
            $serie->third= $matches[0][2];
          }else
          {
            $serie->third= "";
          }
        }else
        {
          $serie->first=$serie->serieId;
        }
       
    
      }else
      {
        $serie->first=$serie->serieId;
      }
     
      $newSeries[]=$serie;

    }

    usort($newSeries, function ($item1, $item2) {
      return $item1->first <=> $item2->first;
    });

    $groupedSeries = array();
  
    $lastGroup="";
    $actualGroupSerie=array();

    foreach($newSeries as $serie)          
  {
      if ($serie->first!=$lastGroup)
      {
        //echo "ENTRA1";
        if (count($actualGroupSerie)>0)//VIENE DE UN GRUPO ANTERIOR. LO AÑADIMOS AL MULTI GRUPO.
        {
       //   echo "ENTRA2";
          $groupedSeries[]=$actualGroupSerie;
        }
  
        //NUEVO GRUPO ORDENAR
        $lastGroup=$serie->first;
        $actualGroupSerie=array();
        $actualGroupSerie[]=$serie;
      }else //NUEVO ELEMENTO. LO AÑADIMOS AL GRUPO
      {
     //   echo "ENTRA3";
        $actualGroupSerie[]=$serie;
      }
  }


  $groupedSeries[]=$actualGroupSerie;       
  
  $groupedSeriesResult= array();
  foreach($groupedSeries as $groupedSerie)          
  {
        usort($groupedSerie, function ($item1, $item2) {
          return $item1->second <=> $item2->second;
        });
        foreach($groupedSerie as $serie)          
        {
          $groupedSeriesResult[]=$serie;
        
        }
  }
  
  //FIN

    return array("id"=>1, "count" =>$auxCount, "items"=> $groupedSeriesResult,  "sql"=>$queryString);
   
  } 
  $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
  return $error;


}
function getBillsByUser($userId)
{  

  global $mysqli;

  $queryString= "SELECT DISTINCT bills.*, series.serieId as serieIdText, series.billValue,  series.dateText,
  subSeries.subSerieId as subSerieIdText, countries.name as countryName, grades.es as gradeES, grades.en as gradeEN
   FROM bills 
  LEFT JOIN series ON bills.serieId=series.id  
  LEFT JOIN subSeries ON bills.subSerieId=subSeries.id  
  LEFT JOIN countries ON bills.countryId=countries.id
  LEFT JOIN grades ON bills.grade=grades.id
  WHERE  bills.ownerId=?";  
  
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("i", $userId);     // Bind variables in order
    $stmt->execute();                               // Execute query    
    $results = $stmt->get_result();
  }
$count=0;
$myArray = array();
  while ($row = $results->fetch_array()) {  
    $myArray[]=$row;
    $count++;
  }
  if ($count>0)
  {

    return array("id" => 1,"count" =>$count, "items"=> $myArray);
   
  } 
  $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
  return $error;


}

function getUsersByProfesional($limit,$start,$profesionalId)
{
  global $mysqli;  
  
  $queryString= "SELECT users.* FROM  users INNER JOIN usersProfesionals  ON users.id=usersProfesionals.userId WHERE usersProfesionals.profesionalId=" . $profesionalId;
  $queryString2= "SELECT COUNT(users.id) FROM users INNER JOIN usersProfesionals  ON users.id=usersProfesionals.userId WHERE usersProfesionals.profesionalId=" . $profesionalId;
  
  $queryString= $queryString . " ORDER BY id LIMIT ?,?";

  if ($stmt = $mysqli->prepare($queryString2)) { 
    $stmt->execute();      // Execute query   
    $resultsCount = $stmt->get_result();
  }  
  $countRow = $resultsCount->fetch_row(); 
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("ii", $start,$limit );     // Bind variables in order
    $stmt->execute();                               // Execute query
    $results = $stmt->get_result();
  }

  $count=0;
  $myArray = array();
  while ($row = $results->fetch_array()) {
    $myArray[]=$row;
     $count++;
  }
  if ($countRow[0]>0)
  {        
   return array("count" => $countRow[0] , "items"=> $myArray);
  } 
  $error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> []);
  return $error;
  
}


function createEvent($userId,$profesionalId,$type,$eventDate,$start,$end,$info)
{
  //echo "la fecha es " .$eventDate;
    global $mysqli;    
    
    $queryString= "INSERT INTO events(id, userId,profesionalId,eventType,eventDate,start,end,eventInfo) VALUES (NULL,?,?,?,?,?,?,?)";
   
    if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->bind_param("iiissss", $userId,$profesionalId,$type,$eventDate,$start,$end,$info);     // Bind variables in order
      $stmt->execute();                               // Execute query
      $results = $stmt->get_result();
    }
       //echo "el error es " .  $mysqli->error;
      $id=$mysqli->insert_id;
      if ($id>0)
      {
    
        $myArray = array("id" => $id, "message" => "Se ha insertado un nuevo evento correctamente.");
        return $myArray;
      }else
      {
        $myArray = array("id" => -1, "message" => "Error al insertar el evento en la base de datos.");
        return $myArray;
      }  
}

function removeBillFromInteraction($id,$billsIds)
{
  global $mysqli;
  
$queryString= "UPDATE interactions2 SET billsIds=?"
            . " WHERE id=?";
    
//echo "UPDATE interactions2 SET billsIds=? WHERE id=?";
        if ($stmt = $mysqli->prepare($queryString)) 
        {
          $stmt->bind_param("si", $billsIds,$id);     // Bind variables in order
          $stmt->execute();                               // Execute query    
        }

        $affectedRows=$mysqli->affected_rows;
        if ($affectedRows>0)
        {
          $myArray = array("id" => 1, "message" => "Se ha actualizado la interaccion correctamente.");
          return $myArray;
        }else
        {
          $myArray = array("id" => -1, "message" => "No se ha actualizado la interaccion.");
          return $myArray;
  } 
}
function updateInteractionMessage($extraData,$id)
{
  global $mysqli;
  
$queryString= "UPDATE interactions2 SET receptorNote=?"
            . " WHERE id=?";
    

        if ($stmt = $mysqli->prepare($queryString)) 
        {
          $stmt->bind_param("si", $extraData,$id);     // Bind variables in order
          $stmt->execute();                               // Execute query    
        }

        $affectedRows=$mysqli->affected_rows;
        if ($affectedRows>0)
        {
          $myArray = array("id" => 1, "message" => "Se ha actualizado la interaccion correctamente.");
          return $myArray;
        }else
        {
          $myArray = array("id" => -1, "message" => "No se ha actualizado la interaccion.");
          return $myArray;
  } 
}
function updateSmsStatus($userId,$profesionalId)
{
  global $mysqli;
  
$queryString= "UPDATE messages SET state=1 "
            . " WHERE userId=? AND profesionalId=? AND state=0";
    

  if ($stmt = $mysqli->prepare($queryString)) 
  {
    $stmt->bind_param("ii", $userId,$profesionalId);     // Bind variables in order
    $stmt->execute();                               // Execute query    
  }

  $affectedRows=$mysqli->affected_rows;
  if ($affectedRows>0)
  {
    $myArray = array("id" => $userId, "message" => "Se han actualizado los sms correctamente.");
    return $myArray;
  }else
  {
    $myArray = array("id" => -1, "message" => "No se ha actualizado ningun sms.");
    return $myArray;
  } 
}
function updatePassword($id,$pass,$newPass,$table)
{
      global $mysqli;
      $pass=utf8_decode($pass);
      $newPass=utf8_decode($newPass);
      
  
      if (strlen($newPass)<1)
      {
         $myArray = array("id" => -1, "message" => "La contrase鍗榓 es obligatoria");
          return $myArray;
      }
      $queryString= "UPDATE " . $table . " SET password=? "
                . " WHERE id=? AND password=?";
        

      if ($stmt = $mysqli->prepare($queryString)) 
      {
        $stmt->bind_param("sis", $newPass,$id,$pass);     // Bind variables in order
        $stmt->execute();                               // Execute query    
      }

      $affectedRows=$mysqli->affected_rows;
      if ($affectedRows>0)
      {
        $myArray = array("id" => $id, "message" => "Se ha actualizado la contrasena correctamente.");
        return $myArray;
      }else
      {
        $myArray = array("id" => -1, "message" => "La contrasena no es correcta.");
        return $myArray;
      } 
}
function updateToken($id,$token,$table)
{
      global $mysqli;      
      
      if (strlen($token)<1)
      {
         $myArray = array("id" => -1, "message" => "El token es obligatorio");
          return $myArray;
      }
      $queryString= "UPDATE " . $table . " SET pushkey=? "
                . " WHERE id=?";
        

      if ($stmt = $mysqli->prepare($queryString)) 
      {
        $stmt->bind_param("si", $token,$id);     // Bind variables in order
        $stmt->execute();                               // Execute query    
      }

      $affectedRows=$mysqli->affected_rows;
      if ($affectedRows>0)
      {
        $myArray = array("id" => $id, "message" => "Se ha actualizado el token correctamente.");
        return $myArray;
      }else
      {
        $myArray = array("id" => -1, "message" => "La contrasena no es correcta.");
        return $myArray;
      } 
}

//updateUserBasic($id,$name,$email,$address,$web,$phone,$description,$active

function updateProfesional($id,$name,$surnames,$bornDate,$sex,$address,$dni,$phone)
{
    global $mysqli;
 if ($bornDate=="")
   {
       $bornDate=null;
   }
    //UPDATE `profesionals` SET `id`=[value-1],`name`=[value-2],`surnames`=[value-3],
    //`bornDate`=[value-4],`sex`=[value-5],`email`=[value-6],`address`=[value-7],
    //`dni`=[value-8],`phone`=[value-9],`password`=[value-10],`pushkey`=[value-11] WHERE 1
        $queryString= "UPDATE profesionals SET name=?, surnames=?,bornDate=?,
    sex=?, address=?,dni=?,phone=? WHERE id=?";

      if ($stmt = $mysqli->prepare($queryString)) 
      {
        $stmt->bind_param("sssisssi", $name,$surnames,$bornDate,$sex,$address,$dni,$phone,$id);     // Bind variables in order
        $stmt->execute();                               // Execute query    
      }
      $affectedRows=$mysqli->affected_rows;
      if ($affectedRows>0)
      {
          $myArray = array("id" => $id, "message" => "Se ha actualizado el profesional correctamente.");
          return $myArray;
      }else
      {
            $myArray = array("id" => -1, "message" => "Error al actualizar el profesional en la base de datos. Err: " . $mysqli->error);
          return $myArray;
      }
}
function updateBusiness($id,$name,$surnames,$bornDate,$sex,$address,$dni,$phone)
{
    global $mysqli;
 if ($bornDate=="")
   {
       $bornDate=null;
   }
    //UPDATE `profesionals` SET `id`=[value-1],`name`=[value-2],`surnames`=[value-3],
    //`bornDate`=[value-4],`sex`=[value-5],`email`=[value-6],`address`=[value-7],
    //`dni`=[value-8],`phone`=[value-9],`password`=[value-10],`pushkey`=[value-11] WHERE 1
        $queryString= "UPDATE business SET name=?, surnames=?,bornDate=?,
    sex=?, address=?,dni=?,phone=? WHERE id=?";

      if ($stmt = $mysqli->prepare($queryString)) 
      {
        $stmt->bind_param("sssisssi", $name,$surnames,$bornDate,$sex,$address,$dni,$phone,$id);     // Bind variables in order
        $stmt->execute();                               // Execute query    
      }
      $affectedRows=$mysqli->affected_rows;
      if ($affectedRows>0)
      {
          $myArray = array("id" => $id, "message" => "Se ha actualizado el negocio correctamente.");
          return $myArray;
      }else
      {
            $myArray = array("id" => -1, "message" => "Error al actualizar el negocio en la base de datos. Err: " . $mysqli->error);
          return $myArray;
      }
}
function acceptCalendarUser($calendarId,$userId)
{
  global $mysqli;

  //UPDATE `events` SET `id`=[value-1],`userId`=[value-2],`profesionalId`=[value-3],
  //`eventType`=[value-4],`eventDate`=[value-5],`start`=[value-6],`end`=[value-7],
  //`eventInfo`=[value-8] WHERE 1
      $queryString= "UPDATE calendarUsers SET linkType=1 WHERE userId=? AND calendarId=?";
//echo $queryString;
    if ($stmt = $mysqli->prepare($queryString)) 
    {
      $stmt->bind_param("ii", $userId,$calendarId);     // Bind variables in order
      $stmt->execute();                               // Execute query    
    }
    $affectedRows=$mysqli->affected_rows;
    if ($affectedRows>0)
    {
        $myArray = array("id" => 1, "message" => "Se ha actualizado el usuario correctamente.");
        return $myArray;
    }else
    {
          $myArray = array("id" => -1, "message" => "Error al actualizar el usuario en la base de datos. Err: " . $mysqli->error);
        return $myArray;
    }
}
function updateEvent($id,$type,$eventDate,$start,$end,$info)
{
    global $mysqli;

    //UPDATE `events` SET `id`=[value-1],`userId`=[value-2],`profesionalId`=[value-3],
    //`eventType`=[value-4],`eventDate`=[value-5],`start`=[value-6],`end`=[value-7],
    //`eventInfo`=[value-8] WHERE 1
        $queryString= "UPDATE events SET eventType=?, eventDate=?, start=?, end=?, eventInfo=? WHERE id=?";

      if ($stmt = $mysqli->prepare($queryString)) 
      {
        $stmt->bind_param("issssi", $type,$eventDate,$start,$end,$info,$id);     // Bind variables in order
        $stmt->execute();                               // Execute query    
      }
      $affectedRows=$mysqli->affected_rows;
      if ($affectedRows>0)
      {
          $myArray = array("id" => $id, "message" => "Se ha actualizado el profesional correctamente.");
          return $myArray;
      }else
      {
            $myArray = array("id" => -1, "message" => "Error al actualizar el profesional en la base de datos. Err: " . $mysqli->error);
          return $myArray;
      }
}
function getBusiness($limit,$start,$filter)
{  
  return getTableData("business",$filter,$limit,$start);
}
function  getProfesionals($limit,$start,$filter)
{  
  return getTableData("profesionals",$filter,$limit,$start);
}
function getProfesionalByUser($userId)
{
  global $mysqli;    
  $queryString= "SELECT profesionals.* FROM  profesionals INNER JOIN usersProfesionals  ON profesionals.id=usersProfesionals.profesionalId WHERE usersProfesionals.userId=" . $userId;
 
if ($stmt = $mysqli->prepare($queryString)) {
  //$stmt->bind_param("ii", $start,$limit );     // Bind variables in order
  $stmt->execute();                               // Execute query
  $results = $stmt->get_result();
}

  $count=0;
 $myArray = array();
  while ($row = $results->fetch_array()) {
    $myArray[]=$row;
     $count++;
  }
  if ($count>0)
  {        
   return array("id" => $userId , "profesional"=> $myArray[0]);
  } 
  $error = array("id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> []);
  return $error;
  
}
function getChangeRequestsByCalendar($calendarId,$month,$year)
{
    global $mysqli;
    $queryString= "SELECT * FROM sustitutionRequest  WHERE calendarId=" . $calendarId . " AND month=" . $month . " AND year=" . $year;
    //echo $queryString;
    if ($stmt = $mysqli->prepare($queryString)) {
      //$stmt->bind_param("s", $email);     // Bind variables in order
      $stmt->execute();                               // Execute query    
      $results = $stmt->get_result();
    }
    $count=0;
    $myArray = array();
    while ($row = $results->fetch_array()) {  
        $myArray[]=$row;
        $count++;
    }
    if ($count>0)
    {
      return array("id" =>1, "item"=> $myArray);
     
    } 
    $error = array("id" => -1, "message" => "No hay cambios con ese calendario. Err: " . $mysqli->error);
    return $error;
}
function getTurnsByCalendarIdAndMonth($calendarId,$month,$year)
{
    global $mysqli;
    $queryString= "SELECT * FROM turns  WHERE calendarId=" . $calendarId . " AND month=" . $month . " AND year=" . $year;
    
    if ($stmt = $mysqli->prepare($queryString)) {
      //$stmt->bind_param("s", $email);     // Bind variables in order
      $stmt->execute();                               // Execute query    
      $results = $stmt->get_result();
    }
    $count=0;
    $myArray = array();
    while ($row = $results->fetch_array()) {  
        $myArray[]=$row;
        $count++;
    }
    if ($count>0)
    {
      return array("id" =>1, "item"=> $myArray);
     
    } 
    $error = array("id" => -1, "message" => "No hay turnos con ese calendario. Err: " . $mysqli->error);
    return $error;
}
function getCalendarsByUser($userId)
{  
  global $mysqli;
  
 
    $queryString= "SELECT calendars.*, calendarUsers.linkType
       FROM calendars INNER JOIN calendarUsers ON calendars.id=calendarUsers.calendarId WHERE calendarUsers.userId=" . $userId;
   $queryString2= "SELECT * FROM calendars WHERE ownerId=" . $userId;

   
    if ($stmt = $mysqli->prepare($queryString)) {
    // $stmt->bind_param("ii", $start,$limit );     // Bind variables in order
      $stmt->execute();                               // Execute query
      $results = $stmt->get_result();
    }
    $count=0;
    $myArray = array();
    while ($row = $results->fetch_array()) {
      $myArray[]=$row;
      $count++;
    }


    if ($stmt = $mysqli->prepare($queryString2)) {
      // $stmt->bind_param("ii", $start,$limit );     // Bind variables in order
        $stmt->execute();                               // Execute query
        $results2 = $stmt->get_result();
      }
      $myArray2 = array();
      while ($row = $results2->fetch_array()) {
        $myArray2[]=$row;
        $count++;
      }
  //echo "LLEGA 3";
  if ($count>0)
  {        
   return array("id"=> 1, "count" => $count , "items"=> $myArray2 , "items2"=>$myArray);
  } 
  $error = array("count"=>0 , "id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> []);
  return $error;
}
function  getEventsAdmin($limit,$start,$filter)
{  
  global $mysqli;
  
  if ($filter!="")
  {
    $queryString= "SELECT events.*, CONCAT(users.name, ' ', users.surnames) As user,
    CONCAT(profesionals.name, ' ', profesionals.surnames) As profesional
       FROM events LEFT JOIN users ON events.userId=users.id 
       LEFT JOIN profesionals ON events.profesionalId=profesionals.id  WHERE " . $filter;
    $queryString2= "SELECT COUNT(events.id) FROM events  LEFT JOIN users ON events.userId=users.id 
    LEFT JOIN profesionals ON events.profesionalId=profesionals.id   WHERE " . $filter;
  }else
  {
    $queryString= "SELECT events.*, CONCAT(users.name, ' ', users.surnames) As user,
    CONCAT(profesionals.name, ' ', profesionals.surnames) As profesional
       FROM events LEFT JOIN users ON events.userId=users.id 
       LEFT JOIN profesionals ON events.profesionalId=profesionals.id ";
    $queryString2= "SELECT COUNT(id) FROM events";
  }
  $queryString= $queryString . " ORDER BY id LIMIT ?,?";
//echo $queryString;
//echo "<br/>" .$queryString2;
if ($stmt = $mysqli->prepare($queryString2)) { 
  $stmt->execute();      // Execute query   
  $resultsCount = $stmt->get_result();
}  
//echo "LLEGA";
$countRow = $resultsCount->fetch_row(); 
//echo $countRow;
if ($stmt = $mysqli->prepare($queryString)) {
  $stmt->bind_param("ii", $start,$limit );     // Bind variables in order
  $stmt->execute();                               // Execute query
  $results = $stmt->get_result();
}
//echo "LLEGA2";
  $count=0;
 $myArray = array();
  while ($row = $results->fetch_array()) {
    $myArray[]=$row;
     $count++;
  }
  //echo "LLEGA 3";
  if ($countRow[0]>0)
  {        
   return array("count" => $countRow[0] , "items"=> $myArray);
  } 
  $error = array("count"=>0 , "id" => -1, "message" => "No hay elementos. Err: " . $mysqli->error, "items"=> []);
  return $error;
}
function  getEvents($limit,$start,$filter)
{  
  return getTableData("events",$filter,$limit,$start);
}
function getEventsByUser($limit,$start,$userId)
{
  $filter= "userId= " . $userId;  
  return getTableData("events",$filter,$limit,$start);
}
function getEventsByProfesional($limit,$start,$profesionalId)
{
  $filter= "profesionalId= " . $profesionalId;  
  return getTableData("events",$filter,$limit,$start);
}


function deleteCalendarUser($calendarId,$userId)
{
    global $mysqli;
    $queryString= "DELETE FROM calendarUsers WHERE calendarId=" . $calendarId . " AND userId=" . $userId; 
    $mysqli->query($queryString);
    //echo $queryString;
    $affectedRows=$mysqli->affected_rows;
    if ($affectedRows>0)
    {
        $myArray = array("id" => 1, "message" => "Se ha eliminado correctamente.");
        return $myArray;
    }else
    {
        $myArray = array("id" => -1, "message" => "Error al eliminar el usuario en la base de datos. Err: " . $mysqli->error);
        return $myArray;
    }
}


function assingUserByEmail($email,$profesionalId,$businessId)
{
  $userResult=getByEmail($email,"users");
  $user=(object)$userResult["item"];
  if ($user->businessId==$businessId)
  {
    return assignUser($user->id,$profesionalId);
  }else
  {
    $myArray = array("id" => -1, "message" => "Error al asignar el usuario al profesional.");
    return $myArray;
  }
  //echo $user->id;
  
}
function assignUser($userId,$profesionalId)
{
      global $mysqli;
      
        $queryString= "INSERT INTO usersProfesionals(userId,profesionalId) VALUES (" . $userId . "," . $profesionalId . ")";
        $mysqli->query($queryString);
        $id=$mysqli->affected_rows;
        if ($id>0)
        {
          $myArray = array("id" => $id, "message" => "Se ha asignado el usuario correctamente.");
          return $myArray;
        }else
        {
          $myArray = array("id" => -1, "message" => "Error al asignar el usuario al profesional.");
          return $myArray;
        }  
}
function removeUserFromProfesional($userId,$profesionalId)
{
  global $mysqli;
    $queryString= "DELETE FROM usersProfesionals WHERE userId=" . $userId . " AND profesionalId=" . $profesionalId; 
    $mysqli->query($queryString);
    //echo $queryString;
    $affectedRows=$mysqli->affected_rows;
    if ($affectedRows>0)
    {
        $myArray = array("id" => $affectedRows, "message" => "Se ha eliminado correctamente.");
        return $myArray;
    }else
    {
        $myArray = array("id" => -1, "message" => "Error al eliminar en la base de datos. Err: " . $mysqli->error);
        return $myArray;
    }
}
 


function getByEmail($email, $table)
{
    global $mysqli;
    $queryString= "SELECT * FROM " . $table . "  WHERE  email=?";  
    
    if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->bind_param("s", $email);     // Bind variables in order
      $stmt->execute();                               // Execute query    
      $results = $stmt->get_result();
    }
    $count=0;
    $myArray = array();
    while ($row = $results->fetch_array()) {  
        $myArray[]=$row;
        $count++;
    }
    if ($count>0)
    {
      return array("email" =>$email, "item"=> $myArray[0]);
     
    } 
    $error = array("id" => -1, "message" => "No hay datos con ese email. Err: " . $mysqli->error);
    return $error;
 
}
function getByIdBusiness($id, $businessId, $table)
{
    global $mysqli;
    $queryString= "SELECT * FROM " . $table . "  WHERE  id=? and businessId=?";  
    
    if ($stmt = $mysqli->prepare($queryString)) {
      $stmt->bind_param("ii", $id, $businessId);     // Bind variables in order
      $stmt->execute();                               // Execute query    
      $results = $stmt->get_result();
    }
$count=0;
$myArray = array();
    while ($row = $results->fetch_array()) {  
      $myArray[]=$row;
      $count++;
    }
    if ($count>0)
    {
      return array("id" =>$id, "item"=> $myArray[0]);
     
    } 
    $error = array("id" => -1, "message" => "No hay datos con ese id. Err: " . $mysqli->error);
    return $error;
 
}

function getSMSs($userId,$userId2,$limit,$start)
{
  $filter= "userId=" . $userId . " AND userId2=" . $userId2;  
  return getTableData("messages",$filter,$limit,$start);
  
}

function getNotReadedSmss($profesionalId)
{
  global $mysqli;
  
  $queryString= "SELECT DISTINCT userId FROM messages WHERE state=0 AND sender=1 AND profesionalId=?";

  
if ($stmt = $mysqli->prepare($queryString)) {
  $stmt->bind_param("i", $profesionalId);     // Bind variables in order
  $stmt->execute();                               // Execute query
  $results = $stmt->get_result();
}

  $count=0;
 $myArray = array();
  while ($row = $results->fetch_array()) {
    $myArray[]=$row;
     $count++;
  }
  if ($count>0)
  {        
    
   return array("count" => $count , "items"=> $myArray);
  } 
  
  $error = array("id" => -1, "message" => "No hay mensajes nuevos. Err: " . $mysqli->error, "items"=> []);
  return $error;
}


function insertSMS($userId,$profesionalId,$sender,$sms)
{
  global $mysqli;    
  $queryString= "INSERT INTO messages(id, userId,profesionalId,sender, message) VALUES (NULL,?,?,?,?)";
 
  if ($stmt = $mysqli->prepare($queryString)) {
    $stmt->bind_param("iiis", $userId,$profesionalId,$sender, $sms);     // Bind variables in order
    $stmt->execute();                               // Execute query
    $results = $stmt->get_result();
  }     
  
    $id=$mysqli->insert_id;
    if ($id>0)
    {  
      $target="";
      $senderId=-1;
      if ($sender==1)
      {
        $senderId=$userId;
        $profesionalTarget= getById($profesionalId,"profesionals");
        if ($profesionalTarget["id"]>0)
        {
          $profesional=$profesionalTarget["item"];
          $target= $profesional["pushkey"];
        }
      }
      if ($sender==2)
      {
        $senderId=$profesionalId;
        $userTarget= getById($userId,"users");
        if ($userTarget["id"]>0)
        {
          $user=$userTarget["item"];
          $target= $user["pushkey"];
        }
      }
      sendPush($id,$sms,$senderId,$target);
      $myArray = array("id" => $id, "message" => "Se ha insertado un nuevo mensaje correctamente.");
      return $myArray;
    }else
    {
      $myArray = array("id" => -1, "message" => "Error al insertar el mensaje en la base de datos.");
      return $myArray;
    }  
}


function  sendPushClient($id, $sms,$title, $appId, $tokenUserId,$img,$clientId)
{global $mysqli;
 
    $queryString= "SELECT token from clientTokens WHERE clientId=" . $tokenUserId . " AND appId=" . $appId;
  // echo $queryString;
    $queryString= "SELECT token from clientTokens WHERE clientId=? AND appId=? ";
    //echo $queryString;
         if ($stmt = $mysqli->prepare($queryString)) {
            $stmt->bind_param("ii", $tokenUserId, $appId );     // Bind variables in order
            $stmt->execute();                               // Execute query
                $tokenResult = $stmt->get_result();
            }
            
            $row = $tokenResult->fetch_array();
      //    echo $row;
       //     echo " A VER SI VA";
         //   $token = $tokenResult->fetch_row();
      
   //   echo  "EL TOKEN ES " . $row[0];
     //return sendPush($id,$sms,$senderId,$row[0]);
            $target=$row[0];
           
           // echo $img;
      return sendFCMMessage($sms,$title,$img, $target,$clientId);
}
    
function sendPush($id,$sms,$senderId,$target)
{
    
     $gcm = new GCM();
     
     $push = new Push();
     $data = array();
     $data['id'] =$id;
     $data['senderId'] =$senderId;
     $data['message'] = $sms;
     $data['notificationId'] ="1";
     $data['op'] = "sms";
   
        
        $push->setTitle("Health Sensor");
        $push->setIsBackground(TRUE);
        $push->setFlag(2);
        $push->setData($data);
        
        $pushMessage=$push->getPush();
        
      //  echo $gcm->sendTEST2();
        // sending push message to single user
    return  $gcm->send($target, $pushMessage);
}

/* Example Parameter $data = array('from'=>'Lhe.io','title'=>'FCM Push Notifications');
	$target = 'single token id or topic name';
	or
	$target = array('token1','token2','...'); // up to 1000 in one request for group sending
*/

function sendFCMMessage($sms,$title,$img,$target,$senderId){

    //API URL of FCM
    $url = 'https://fcm.googleapis.com/fcm/send';

    /*api_key available in:
    Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/ 
    $api_key = 'AAAA5VUvCr4:APA91bG4claQSrqY7T7PlgwUNr_J7lWnKLDGZc9iiUAs4zA0C6iccZXMsOQIJJ03MnKq-LO8xvVugSyxQ-IaCoUqVdNbWzPAGIjWGZ5L0VhHuIrjIXt4vvBatHeSXcJoIr0ubEL0yMT8';
     //    {"to":$target,"notification":{"title":"Working Good","body":"[add your message]"},"priority":"high"}       
    
      $msg = array
(
	'message' 	=> $sms,
	'title'		=> $title,
	'vibrate'	=> 1,
	'sound'		=> 1,
        "icon"=> $img, //"/img/clients/24.jpg"
         "senderId"=>$senderId
);
   
      
    $fields = array (
        'to' => $target
        ,
        'notification' => array (
                "title" => $title,
                "body"=>$sms,
              "icon"=> $img,
            'subtitle'	=> 'This is a subtitle. subtitle'
        ),
        'priority' => "high",
        'data' => $msg     
        
    );

  
    //header includes Content type and api key
    $headers = array(
        'Content-Type:application/json',
        'Authorization:key='.$api_key
    );
                
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
  //  echo "<br/><br/><br/>EL RESULTADO A SIDO " .$result . " Y NADA MAS";
   
    if ($result === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}
function sendFCMMessage2($data,$target){
   //FCM API end-point
   $url = 'https://fcm.googleapis.com/fcm/send';
   //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
   $server_key = 'AAAA5VUvCr4:APA91bG4claQSrqY7T7PlgwUNr_J7lWnKLDGZc9iiUAs4zA0C6iccZXMsOQIJJ03MnKq-LO8xvVugSyxQ-IaCoUqVdNbWzPAGIjWGZ5L0VhHuIrjIXt4vvBatHeSXcJoIr0ubEL0yMT8';
	
   
   $msg = array
(
	'message' 	=> $data,
	'title'		=> 'This is a title. title',
	'subtitle'	=> 'This is a subtitle. subtitle',
	'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
	'vibrate'	=> 1,
	'sound'		=> 1
);
   
   $fields = array();
   $fields['data'] = $msg;
   if(is_array($target)){
	$fields['registration_ids'] = $target;
   }else{
	$fields['to'] = $target;
   }
   //header with content_type api key
   $headers = array(
	'Content-Type:application/json',
        'Authorization:key='.$server_key
   );
   //CURL request to route notification to FCM connection server (provided by Google)			
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
   $result = curl_exec($ch);
   if ($result === FALSE) {
	die('Oops! FCM Send Error: ' . curl_error($ch));
   }
   curl_close($ch);
   return $result;
}
function resetPass($email,$table)
{
   global $mysqli;      
  $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
  
  $pass=substr(str_shuffle($str_result), 0, 8);
  $queryString= "UPDATE " . $table . " SET password=? WHERE email=?";
    
  

  if ($stmt = $mysqli->prepare($queryString)) 
  {
    $stmt->bind_param("ss", $pass,$email);     // Bind variables in order
    $stmt->execute();                               // Execute query    
  }

  $affectedRows=$mysqli->affected_rows;
  if ($affectedRows>0)
  {
    $msg = "Reseteo de password\nTu nuevo password es: " . $pass;
    $msg = wordwrap($msg,70);
    mail($email,"Health Sensor",$msg);
    $myArray = array("id" => 1, "message" => "Se ha actualizado el password correctamente.");
    return $myArray;
  }else
  {
    $myArray = array("id" => -1, "message" => "No se ha actualizado el password");
    return $myArray;
  }
}
function checkMySql()
{
    global $mysqli;
    if ($mysqli->ping()) {
     $json = array("status" => 0, "msg" => "Conexion exitosa");
} else {
      $json = array("status" => 1, "msg" => "Conexion erronea");
}
return $json;
}


function encodeArray($myArray)
{
//    foreach ($myArray as $?)
//    {
//        if (is_array($?))
//        {
//            foreach ($? as $?2)
//            {
//                utf8_encode($?2);
//            }
//        } else {
//               utf8_encode($?);
//        }
//    }
 //   $encodedArray= array_map(utf8_encode, $myArray);
    array_walk_recursive($myArray,'encodeItem');
   // var_dump($myArray);
   return json_encode($myArray);
}
function encodeItem(&$item,$key)
{
    $item=utf8_encode($item);
}



function  ToCanonical($text)
{
    $text = strtolower($text);
    $text= str_replace('a','a',$text);
   $text = str_replace('á', 'a',$text);
   $text = str_replace('é', 'e',$text);
   $text = str_replace('í', 'i',$text);
   $text = str_replace('ó', 'o',$text);
   $text = str_replace('ú', 'u',$text);
   $text = str_replace('ü', 'u',$text);
   $text = str_replace('ä', 'a',$text);
   $text = str_replace('ë', 'e',$text);
   $text = str_replace('ï', 'i',$text);
   $text = str_replace('ț', 't',$text);
   $text = str_replace('ș', 's',$text);

   $text = str_replace('ö', 'o',$text);
   $text = str_replace('ñ', 'n',$text);
   $text = str_replace('"', '-',$text);
   $text = str_replace(",", "",$text);
   $text = str_replace(";", "",$text);
   $text = str_replace(":", "",$text);
   $text = str_replace(".", "",$text);
   $text = str_replace("'", "-",$text);
   $text = str_replace(" ", "-",$text);
   $text = str_replace("&amp;", "",$text);
   $text = str_replace("/", "",$text);
   $text = str_replace("\\", "",$text);
   $text = str_replace("’", "",$text);
   $text = str_replace("‘", "",$text);

   $text = str_replace("(", "",$text);
   $text = str_replace(")", "",$text);
   $text = str_replace("$", "",$text);
   $text = str_replace("+", "",$text);
   $text = str_replace("—", "",$text);
   $text = str_replace("!", "",$text);
   $text = str_replace("¡", "",$text);
   $text = str_replace("?", "",$text);
   $text = str_replace("¿", "",$text);
   $text = str_replace("%", "",$text);
   $text = str_replace("&", "",$text);
   $text = str_replace("--------", "-",$text);
   $text = str_replace("-------", "-",$text);
   $text = str_replace("-----", "-",$text);
   $text = str_replace("----", "-",$text);
   $text = str_replace("---", "-",$text);
   $text = str_replace("--", "-",$text);
   $text = str_replace("▷-", "",$text);
   $text = str_replace("▷", "",$text);

  // $text = RemoveDiacritics($text);            
  $text = str_replace("\n", " ",$text);
  $text= trim($text);
  $text = str_replace(" ", "-",$text);
  $text = str_replace("--------", "-",$text);
  $text = str_replace("-------", "-",$text);
  $text = str_replace("------", "-",$text);
  $text = str_replace("-----", "-",$text);
  $text = str_replace("----", "-",$text);
  $text = str_replace("---", "-",$text);
  $text = str_replace("--", "-",$text);
  $text = str_replace("=", "",$text);
  $text = str_replace("--------", "-",$text);
  $text = str_replace("-------", "-",$text);
  $text = str_replace("------", "-",$text);
  $text = str_replace("-----", "-",$text);
  $text = str_replace("----", "-",$text);
  $text = str_replace("---", "-",$text);
  $text = str_replace("--", "-",$text);

    return remove_accents($text);
}
function remove_accents($string) {
  if ( !preg_match('/[\x80-\xff]/', $string) )
      return $string;

  if (seems_utf8($string)) {
      $chars = array(
      // Decompositions for Latin-1 Supplement
      chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
      chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
      chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
      chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
      chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
      chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
      chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
      chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
      chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
      chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
      chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
      chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
      chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
      chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
      chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
      chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
      chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
      chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
      chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
      chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
      chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
      chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
      chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
      chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
      chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
      chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
      chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
      chr(195).chr(191) => 'y',
      // Decompositions for Latin Extended-A
      chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
      chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
      chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
      chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
      chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
      chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
      chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
      chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
      chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
      chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
      chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
      chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
      chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
      chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
      chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
      chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
      chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
      chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
      chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
      chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
      chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
      chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
      chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
      chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
      chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
      chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
      chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
      chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
      chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
      chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
      chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
      chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
      chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
      chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
      chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
      chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
      chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
      chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
      chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
      chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
      chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
      chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
      chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
      chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
      chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
      chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
      chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
      chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
      chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
      chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
      chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
      chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
      chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
      chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
      chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
      chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
      chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
      chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
      chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
      chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
      chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
      chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
      chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
      chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
      // Euro Sign
      chr(226).chr(130).chr(172) => 'E',
      // GBP (Pound) Sign
      chr(194).chr(163) => '');

      $string = strtr($string, $chars);
  } else {
      // Assume ISO-8859-1 if not UTF-8
      $chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
          .chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
          .chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
          .chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
          .chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
          .chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
          .chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
          .chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
          .chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
          .chr(252).chr(253).chr(255);

      $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

      $string = strtr($string, $chars['in'], $chars['out']);
      $double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
      $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
      $string = str_replace($double_chars['in'], $double_chars['out'], $string);
  }

  return $string;
}
function getNameFromResult($users,$userId)
{
    foreach($users as $user)
    {
      $user=(object) $user;
      if ($user->id==$userId)
      {
        return $user->nickname;
      }
    }
    return "";
}
function getEmailFromResult($users,$userId)
{
    foreach($users as $user)
    {
      $user=(object) $user;
      if ($user->id==$userId)
      {
        return $user->email;
      }
    }
    return "";
}
function sendEmail($recipientEmail, $subject, $sms)
{
  $to = $recipientEmail;
  $subject = $subject;
  
  $message = "
  <html>
  <head>
  <title>BankNotesCollection email</title>
  </head>
  <body>
  " . $sms . "
  </body>
  </html>
  ";
  
  // Always set content-type when sending HTML email
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  
  // More headers
  $headers .= 'From: <info@banknotescollection.com>' . "\r\n";
  
  $resultSend=mail($to,$subject,$message,$headers);

  $myArray = array("result" => $resultSend, "message" => "Se ha intentado enviar el email.");
}


