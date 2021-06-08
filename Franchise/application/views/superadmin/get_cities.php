<?php

include('ConDB.php');
$db1 = new ConDB();

$country = $_REQUEST['country'];
$CityId = $_REQUEST['CityId'];

//$enable = $Admin;

$getCitiesQry = "select City_Name,City_Id from city_available where Country_Id='" . $country . "' order by City_Name ASC";

$getCitiesRes = mysql_query($getCitiesQry, $db1->conn);

$cities_data = "<select class='form-control' name='FData[City]' id='cityLists'  " . $enable . ">"
        . "<option value='NULL'>Select City</option>";

while ($city = mysql_fetch_array($getCitiesRes)) {
    if ($CityId == $city['City_Id']) {
        $cities_data.="<option value='" . $city['City_Id'] . "' selected>" . $city['City_Name'] . "</option>";
    } else {
        $cities_data.="<option value='" . $city['City_Id'] . "'>" . $city['City_Name'] . "</option>";
    }
}
$cities_data.= '</select>';
echo $cities_data;
?>