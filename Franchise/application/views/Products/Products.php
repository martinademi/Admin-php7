
<style>
    #selectedcity,#companyid,#tableWithSearch_length,#tableWithSearch_filter{
        display: none;
    }
</style>
<script>
    $(document).ready(function () {


        $('#tableWithSearch').DataTable();
        $('#search-table').keyup(function ()
        {
            searchTable($(this).val());
        });

    });

    function searchTable(inputVal)
    {
        var table = $('#tableWithSearch');
        table.find('tr').each(function (index, row)
        {
            var allCells = $(row).find('td');
            if (allCells.length > 0)
            {
                var found = false;
                allCells.each(function (index, td)
                {
                    var regExp = new RegExp(inputVal, 'i');
                    if (regExp.test($(td).text()))
                    {
                        found = true;
                        return false;
                    }
                });
                if (found == true)
                    $(row).show();
                else
                    $(row).hide();
            }
        });

    }


</script>

<script>


    function selectall() {
        var checked = $("#selectbids:checked").length;
//            alert(checked);

        if (checked == 0) {
            $(".selectbids").attr('checked', false);
        } else {
            $(".selectbids").attr('checked', true);
            //        alert();
        }
    }

    $("#HeaderMenu").addClass("active");
    $("#HeaderMenu4").addClass("active");
    $(document).ready(function () {

        $('.HeaderMenu4').addClass('active');
//        $('.icon-thumbnail').attr('<?php echo base_url(); ?>assets/dash_board_on.png"');
        $('.menu3_thumb').attr('src', "<?php echo base_url(); ?>assets/products_on.png");


        $('#callM').click(function () {

            $('#NewCat').modal('show');
        });


        $(".moveUp").click(function (e) {
//            alert();
            var event = e || window.event;
            event.preventDefault();
            var row = $(this).closest('tr');
            console.log(row);
            console.log(row.attr('id'));
            console.log(row.prev().attr('id'));
            $.ajax({
                url: "<?php echo base_url() ?>index.php/superadmin/changeProductCatOrder",
                type: "POST",
                data: {kliye: 'interchange', curr_id: row.attr('id'), prev_id: row.prev().attr('id'), b_id: '<?php echo $BizId; ?>'},
                success: function (result) {

                }
            });
            row.prev().insertAfter(row);
            $('#saveOrder').trigger('click');
        });

        $(".moveDown").click(function (e) {
            var event = e || window.event;
            event.preventDefault();
            var row = $(this).closest('tr');
            console.log(row);
            console.log(row.attr('id'));
            console.log(row.next().attr('id'));
            $.ajax({
                url: "<?php echo base_url() ?>index.php/superadmin/changeProductCatOrder",
                type: "POST",
                data: {kliye: 'interchange', prev_id: row.attr('id'), curr_id: row.next().attr('id'), b_id: '<?php echo $BizId; ?>'},
                success: function (result) {

//                    alert("intercange done" + result);

                }
            });
            row.insertAfter(row.next());
            $('#saveOrder').trigger('click');
        });

        $("#Loadmore").click(function (e) {

//                alert();
            var table = $('#tableWithSearch');

            var settings = {
                "sDom": "<'table-responsive't><'row'<p i>>",
                "sPaginationType": "bootstrap",
                "destroy": true,
                "scrollCollapse": true,
                "oLanguage": {
                    "sLengthMenu": "_MENU_ ",
                    "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
                },
                "iDisplayLength": 200
            };

            table.DataTable(settings);
//                $('#search-table').keyup(function () {
//                        table.fnFilter($(this).val());
//                  });

        });

        $('#PDelete').click(function () {
//           alert();
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
//            alert(val);
            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DELETE_ONEBUSINESS_CAT); ?>);
            } else if (val.length == 1 || val.length > 1)
            {
                $("#errorboxdata").text(<?php echo json_encode(POPUP_DELETE_CUSTOMER); ?>);
                $("#display-data").text("");
//                var BusinessId = val;

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#deletemodal');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#deletemodal').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

                $("#deletelink").click(function () {

                    $.ajax({
                        url: "<?php echo base_url() ?>index.php/superadmin/DeleteProduct",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (response)
                        {
                            $(".close").trigger("click");
                            location.reload();
                        }
                    });
                });
            }
        });


    });

    function moveUpclk(id) {

//        alert();
//        var event = e || window.event;
//        event.preventDefault();
//        console.log(id);
        var row = $(id).closest('tr');
        var prev_id = row.prev('tr').find('.moveUp').attr('id')
        var curr_id = row.find('.moveUp').attr('id');
         console.log(prev_id);
         console.log(curr_id);

       $.ajax({
            url: "<?PHP echo AjaxUrl; ?>changeProductCatOrder",
            type: "POST",
            data: {kliye: 'interchange', curr_id: curr_id, prev_id: prev_id, b_id: '<?php echo $BizId; ?>'},
            success: function (result) {

            }
        });
        row.prev().insertAfter(row);
        $('#saveOrder').trigger('click');
    }
    function moveDownclk(id) {

         var row = $(id).closest('tr');
         var prev_id = row.find('.moveDown').attr('id');
         var curr_id = row.next('tr').find('.moveDown').attr('id');
      
        console.log(row);
        console.log(prev_id);
        console.log(curr_id);
        $.ajax({
            url: "<?PHP echo AjaxUrl; ?>changeProductCatOrder",
            type: "POST",
            data: {kliye: 'interchange', prev_id: row.attr('id'), curr_id: row.next().attr('id'), b_id: '<?php echo $BizId; ?>'},
            success: function (result) {

//                    alert("intercange done" + result);

            }
        });
        row.insertAfter(row.next());
        $('#saveOrder').trigger('click');

    }
    //here this function validates all the field of form while adding new sufadmin you can find all related functions in RylandInsurence.js file

//    function Delservice(thisval) {
//        $('#deletemodal').modal('show');
//        var entityidid = thisval.id;
//        $("#deletelink").attr('href', "<?php // echo base_url()  ?>index.php/superadmin/DeleteProduct/" + entityidid);
//    }

</script>
<script>

    $(document).ready(function () {
//           alert();

        $('#selectcat').change(function () {

            var catId = $("#selectcat option:selected").attr('value');
//                       alert(catId);
            $('#subcatid').load('<?PHP echo AjaxUrl; ?>GetSubCatfromCat', {catId: catId});
            refreshTableOnActualchagne(catId, 1);


        });

        $('#subcatid').change(function () {
//         alert($(this).val());
            refreshTableOnActualchagne($('#selectcat').val(), $(this).val());

        });

    });

    function refreshTableOnActualchagne(id, sid) {
           $("#selectbids").attr('checked', false);
        $.ajax({
            url: "<?php echo base_url('index.php/superadmin') ?>/filtercat",
            type: "POST",
            data: {cat: id, sid: sid},
            dataType: 'JSON',

            success: function (response)
            {
                var res = response.res;
                var table = $('#tableWithSearch').DataTable();
                table.clear();

                $.each(res, function (index, row)
                {
                    console.log(row.p_id);

                    table.row.add([
                        index + 1,
                        "<img style='width: 40px;' src='" + row.img + "' onerror=\"if (this.src != 'error.jpg') this.src = 'https://tebse.com/Tebse/appimages/default.jpeg'\">",
//                        row.img,
                        row.pname,
                        row.cat,
                        row.subcat,
                        row.price,

                        "<div class='btn-group'  style='width: 156px;'>\
                        <a class='moveDown btn-padding' id='" + row.p_id + "'>\
                                <button id='" + row.p_id + "' type='button' style='color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;' class='btn btn-success'>\
                                    <i class='fa fa-arrow-down'></i>\
                                 </button>\
                        </a>\
                        <a class='moveUp btn-padding' id='" + row.p_id + "'>\
                                <button id='" + row.p_id + "' type='button' style='color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;' class='btn btn-success'>\
                                    <i class='fa fa-arrow-up'></i>\
                                 </button>\
                        </a>\
                        <a class='btn-padding' href='<?php echo base_url() ?>index.php/superadmin/EditProduct/" + row.p_id + "'>\
                                <button onclick='edit(this)' id='" + row.p_id + "' type='button' style='color: #ffffff !important;background-color: #5bc0de;border: 1px solid #5bc0de;' class='btn btn-success'>\
                                    <i class='fa fa-pencil'></i>\
                                </button>\n\
                        </a>\
                        </div>",
                        "<input type='checkbox' class='checkbox selectbids' id='" + row.p_id + "' value='" + row.p_id + "'>"
//<a class='btn-padding'><button type='button' onclick='Delservice(this)' id='" + row.p_id + "' class='btn btn-success' style='color: #ffffff !important;background-color: #d9534f;border: 1px solid #d9534f;'>\
//                              <i class='fa fa-trash-o'></i>\
//                            </button>\
//                        </a>\
//                        row.p_id
                    ]).draw();

                });
            }
        });
//        https://tebse.com/Tebsenewtheme/Business/index.php/superadmin/EditProduct/58650c2c5b45403d564cea05

    }

</script>


<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax">
            <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb" style="">
                    <li>
                        <a href="#" class="active">MENU</a>
                    </li>
                    <li><a href="#" class="active">PRODUCTS</a>
                    </li>
                </ul>
                <!-- END BREADCRUMB -->
            </div>
            <div class="add_new">
                <a href="<?php echo base_url(); ?>index.php/Products/NewProduct"><button type="button" class="btn btn-primary" style="margin:0px;">Add</button></a>
                <button type="button" class="btn btn-primary" id="PDelete" style="margin:0px;">Delete</button>

            </div>

            <div class="container-fluid container-fixed-lg bg-white">
                <!-- START PANEL -->
                <div class="panel panel-transparent">
                    <div class="panel-heading">                        

                        <div class="brand inline " style="width:auto">
                            <div class="form-group " >
                                <div class="col-sm-8" style="width: 200px;padding: 0px 10px 0px 0px;margin-bottom: 10px;" >
                                    <!--<span style="">select category</span>-->
                                    <select id="selectcat" name="cat_select" class="form-control"  >
                                        <!--<option value="0">Select city</option>-->

                                        <option value="0">All</option>
                                        <?php
                                        foreach ($productlist as $result) {
//                                   print_r($result];
//                                   print_r($result["Category"]);
//                                    print_r($result["CatName"]) ;
                                            echo '<option value="' . $result['_id'] . '">' . implode($result['Category'], ',') . '</option>';
                                        }
//                              
                                        ?>  

                                    </select>

                                </div>


                            </div>
        <!--                   <strong>Roadyo Super superadmin Console</strong> id="define_page"-->
                        </div>

                        <div class="brand inline "  style="width:auto" >
        <!--                    <img src="--><?php //echo base_url();               ?><!--theme/assets/img/Rlogo.png" alt="logo" data-src="--><?php //echo base_url();               ?><!--theme/assets/img/Rlogo.png" data-src-retina="--><?php //echo base_url();               ?><!--theme/assets/img/logo_2x.png" width="93" height="25">-->
                            <div class="form-group" >
                                <!--<label for="fname" class="col-sm-6 control-label" style="margin-top: 10px;font-size: 13PX;padding:0px">SELECT COMPANY</label>-->
                                <div class="col-sm-8" style="width: auto;
                                     padding: 0px;
                                     margin-bottom: 10px;" >

                                    <select id="subcatid" name="company_select" class="form-control"  >
                                        <option value="0">Select Subcategory</option>
                                        <!--<option value="0">All</option>-->
                                    </select>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 pull-right" style="width: auto;
                                     padding: 0px;
                                     margin-bottom: 10px;" >                             
                                    <input type="text" id="search-table" class="form-control pull-right" placeholder="Search">                                
                                </div>
                            </div>
        <!--                   <strong>Roadyo Super superadmin Console</strong> id="define_page"-->
                        </div>

                        <div class="panel-body" style='height: auto;'>
                            <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover demo-table-search dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info">
                                        <thead>

                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 57px;">
                                                    Slno</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 108px;">
                                                    Image</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 400px;">
                                                    Product Name</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 400px;">
                                                    Category</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 400px;">
                                                    Sub-Category</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 85px;">
                                                    Price(<?PHP echo $this->session->userdata('fadmin')['Currency']; ?>)</th>

<!--                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 275px;">
    Description</th>-->
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 232px;">
                                                    Option</th>
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 232px;">
                                                    <!--Select-->
                                                    <?php
                                                    echo ' <input type="checkbox"  id="selectbids"  onclick="selectall();" >';
                                                    ?>
                                                </th>
                                            </tr>

                                        </thead>
                                        <tbody>

                                            <?php
                                            $count = 1;

                                            foreach ($entitylist as $result) {
                                                $Price = 0;
                                                $allprice = array();
                                                if ($result['Portion']) {
                                                    if (count($result['Portion']) == 1) {
                                                        foreach ($result['Portion'] as $Por) {
                                                            $Price = $Por['price'];
                                                        }
                                                    } else {
                                                        foreach ($result['Portion'] as $Por) {
                                                            if ($Por['Default'] == "true")
                                                                $Price = $Por['price'];
//                                                                 $allprice[] = $Por['price'];
                                                        }
//                                                        $Price = min($allprice);
                                                    }
                                                }
                                                ?>
                                                <tr role="row" class="odd" id='<?PHP echo (string) $result['_id'] ?>'>
                                                    <td class="sorting_1"> <?php echo $count ?></td>
                                                    <td class=""> <img style="width: 40px;" src="<?php if ($result["Masterimageurl"]['Url'] == '') {
                                                echo "https://tebse.com/Tebse/appimages/default.jpeg";
                                            } else {
                                                echo $result["Masterimageurl"]['Url'];
                                            } ?>" onerror="if (this.src != 'error.jpg') this.src = 'https://tebse.com/Tebse/appimages/default.jpeg';"></td>
                                                    <td class=""> <?php
                                                        if (is_array($result["ProductName"])) {
                                                            echo implode($result["ProductName"], ',');
                                                        } else {
                                                            echo $result["ProductName"];
                                                        }
                                                        ?></td>
                                                    <td class=""> <?php
                                                        if (is_array($result["CatName"])) {
                                                            echo implode($result["CatName"], ',');
                                                        } else {
                                                            echo $result["CatName"];
                                                        }
                                                        ?></td>
                                                    <td class=""> <?php
                                                    if (is_array($result["SubCatName"])) {
                                                        echo implode($result["SubCatName"], ',');
                                                    } else {
                                                        echo $result["SubCatName"];
                                                    }
                                                        ?></td>
                                                    <td class=""> <?php echo $Price; ?> </td>
                                                    <!--<td class=""><p> <?php // echo $result["ProductDescription"]            ?> </p></td>-->

                                                    <td  class="" style="width: 156px;">
                                                        <div class="btn-group">
                                                            <a class="moveDown btn-padding" onclick="moveDownclk(this)" id='<?php echo $result['_id'] ?>'><button id="<?php echo $result['_id'] ?>" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;" class="btn btn-success"><i class="fa fa-arrow-down"></i>
                                                                </button></a>
                                                            <a class="moveUp btn-padding" onclick="moveUpclk(this)" id='<?php echo $result['_id'] ?>'>
                                                                <button id="<?php echo $result['_id'] ?>" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;" class="btn btn-success"><i class="fa fa-arrow-up"></i>
                                                                </button>
                                                            </a>
                                                            <a class="btn-padding" href="<?php echo base_url() . 'index.php/superadmin/EditProduct/' . $result['_id']; ?>"><button onclick="edit(this)" id="<?php echo $result['_id'] ?>" type="button" style="color: #ffffff !important;background-color: #5bc0de;border: 1px solid #5bc0de;" class="btn btn-success"><i class="fa fa-pencil"></i>
                                                                </button></a>

    <!--                                                            <a class="btn-padding"><button type="button" onclick="Delservice(this)" id="<?php echo $result['_id'] ?>" class="btn btn-success" style="color: #ffffff !important;background-color: #d9534f;border: 1px solid #d9534f;"><i class="fa fa-trash-o"></i>
                                                                    </button></a>-->

                                                        </div>
                                                    </td>
                                                    <td class=""> <input type="checkbox" class="checkbox selectbids" value=<?php echo $result['_id'] ?>></td>


                                                </tr>
    <?php
    $count++;
}
?>
                                        </tbody>
                                    </table>
                                    <a>
                                        <button type="button" id="Loadmore" class="btn btn-success"  style="color: #ffffff !important; background-color: #10cfbd;     margin-left: 95%; margin-top: 0%;"><i class="fa fa-expand"></i>
                                        </button>
                                    </a>
                                </div></div></div>

                    </div>

                </div>

                <!-- END PANEL -->
            </div>
        </div>

        <!-- END JUMBOTRON -->
    </div>
</div>

<div class="modal fade stick-up in" id="deletemodal" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>
                <div class="modal-body">
                    <h5>Are you sure to delete selected product ? </h5>
                </div>

                <div class="modal-footer">



                    <button type="buttuon" id="deletelink" class="btn btn-primary btn-cons  pull-left inline">Continue</button>

                    <button type="button" class="btn btn-default btn-cons no-margin pull-left inline" data-dismiss="modal">Cancel</button>

                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade in" id="NewCat" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
    <div class="modal-dialog">

        <form action = "<?php echo base_url(); ?>index.php/superadmin/AddNewCategory" method= "post" onsubmit="return validateForm();">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add New Category</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" class="form-control" placeholder="Category" id="Category" name="FData[Category]">
                    </div>
                    <div class="form-group" >
                        <label>Description</label>
                        <input type="text" class="form-control" placeholder="Description" id="Description" name="FData[Description]">
                    </div>
                    <input type="hidden" id="BusinessId" name="FData[BusinessId]" value="<?PHP echo $BizId; ?>">


                    <label id = "errorbox" style="color: red; font-size: 15px;"></label>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="Submit" class="btn btn-primary" value="Add">

                </div>
            </div>
        </form>


    </div>

</div>