
<script>
    $('#refresh_table .ChangeStatus').click(function () {
        $('#overlay_div').toggle();
        var status = '1';
//            alert(this.id);
//            alert(this.value);
        if (this.value == 'Reject') {
            status = '5';
        }
        $.ajax({
            type: "POST",
            url: "UpdateMAsterStatus.php",
            data: {BizId: this.id, status: status},
            dataType: "JSON",
            success: function (result) {
                //alert(result.message);
                if (result.flag == 0) {
                    $('#refresh_table').load('GetAllMasters.php', {test: 1}, function () {
                        $('#overlay_div').toggle();
                    });
                }
            }
        });


    });

    function ChangeStatus() {
        var values = '';
        $(':checkbox:checked.ChangeStatus').each(function (i) {
            values = $(this).val() + ',' + values;
        });
        $('#overlay_div').toggle();
        $.ajax({
            type: "POST",
            url: "UpdateMAsterStatus.php",
            data: {BizId: values, status: '5'},
            dataType: "JSON",
            success: function (result) {
                //alert(result.message);
                if (result.flag == 0) {
                    $('#refresh_table').load('GetAllMasters.php', {test: 1}, function () {
                        $('#overlay_div').toggle();
                    });
                }
            }
        });
    }
</script>
<?php
include('../Models/ConDB.php');
$db1 = new ConDB();
if (isset($_REQUEST['type'])) {
    $status = $_REQUEST['type'];
} else {
    $status = '5';
}
if (isset($_REQUEST['cityid'])) {
    $cityid = $_REQUEST['cityid'];
}
if (isset($_REQUEST['companyid'])) {
    $companyids = $_REQUEST['companyid'];
}
?>
<script type='text/javascript' src='js/settings.js'></script>
<!--<script type='text/javascript' src='js/plugins_13.js'></script>-->
<script type='text/javascript' src='js/actions.js'></script>
<script type="text/javascript">
    $(document).ready(function () {
        if ($("table.sortable").length > 0)
            $("table.sortable").dataTable({"iDisplayLength": 10, "aLengthMenu": [ 10, 20, 30,40,50], "aaSorting": [], "sPaginationType": "full_numbers", "aoColumns": [{"bSortable": true}, null, null, null, null]});
    });
</script>

<table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped sortable">
    <thead style="font-size: 12px;">
        <tr>
            <th width="8%">Sr. No</th>
            <th width="8%">Name</th>
            <th width="8%">Status</th>
            <th width="8%">Number of locations</th>   
            <th width="8%">SELECT </th>
        </tr>
    </thead>
    <tbody style="font-size: 12px;">
        <?php
//        if ($cityid == '' && $companyids == '') {
//            $accQry = "SELECT * FROM workplace where status IN ('" . $status . "')  order by workplace_id desc";
//        } else if ($cityid != '' && $companyids == '') {
//            $accQry = "SELECT * FROM workplace where status IN ('" . $status . "') and type_id in(select type_id from workplace_types where city_id = " . $cityid . ") order by workplace_id desc";
//        } else if ($cityid == '' && $companyids != '') {
//            $accQry = "SELECT * FROM workplace where status IN ('" . $status . "') and company IN(" . $companyids . ") order by workplace_id desc";
//        } else {
//            $accQry = "SELECT * FROM workplace where status IN ('" . $status . "') and company IN(SELECT company_id FROM company_info WHERE city = " . $cityid . " and company_id = " . $companyids . ") and type_id in(select type_id from workplace_types where city_id = " . $cityid . ") order by workplace_id desc";
//        }
        // echo $accQry;
//        $result1 = mysql_query($accQry, $db1->mongo);

        $chatTable = $db1->mongo->selectCollection('MasterData');
        $allMasters = $chatTable->find(array('Status' => '1'));
        $i = 1;
        foreach ($allMasters as $row) {
            if ($row['MasterName'] != '') {
                ?>

                <tr id="doc_rows<?php echo $i; ?>">
                    <td   id="<?Php echo "Master" . $i; ?>"><?php echo $i ?></td>
                    <td><a target="_blank" href="http://postmenu.cloudapp.net/iDeliver/Business/index.php/superadmin/FromAdmin/<?PHP echo (string) $row['_id']; ?>" data="<?php echo $i; ?>" data-toggle="modal"> 
                            <?php
                            echo $row['MasterName'];
                            ?>
                        </a>
                    </td>

                    <td  id="<?Php echo "Vehicle_Reg_No" . $i; ?>"><?Php
                        if ($row['Status'] == '1') {
                            echo 'Active';
                        } elseif ($row['Status'] == '3') {
                            echo 'New';
                        } elseif ($row['Status'] == '5') {
                            echo 'Rejected';
                        }
                        ?></td>
                    <td id="<?Php echo "License_Plate_No" . $i; ?>"><?Php
                        $CountSubBiz = $db1->mongo->selectCollection('ProviderData');
                        echo $CountSubBiz->count(array('Master' => (string) $row['_id']));
                        ?></td>

                    <td>
                        <?Php
                        echo '<input type="checkbox" class="ChangeStatus" id="ChangeStatus" value="' . (string) $row['_id'] . '">';
//                        if ($row['Status'] == '1') {
//                            echo '<input type="button" class="ChangeStatus" id="' . (string) $row['_id'] . '"  value="Reject">';
//                        } elseif ($row['Status'] == '3') {
//                            echo '<input type="button" class="ChangeStatus" id="' . (string) $row['_id'] . '" value="Accept">'
//                            . '<input type="button" class="ChangeStatus" id="' . (string) $row['_id'] . '"  value="Reject">';
//                        } elseif ($row['Status'] == '5') {
//                            echo '<input type="button" class="ChangeStatus" id="' . (string) $row['_id'] . '"  value="Accept">';
//                        }
//                        
                        ?></td>
                </tr>
                <?php
//                echo $i;
                $i++;
            }
        }
        ?> 

    </tbody>
</table> 

<!--hello boy-->