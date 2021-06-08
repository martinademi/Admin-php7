<?php  error_reporting(0)?>
<script>
    $(document).ready(function(){


//        $('#edit').click(function(){
//            alert('clked');
////            var firsttd = $(this).parent().siblings(":first").text()
////            alert(firsttd)
//        });


        $('#edit').click(function(){
            $('#modalSlideUp').modal('show');

        });

$('#callm').click(function(){
    $('#modalSlideUp').modal('show');

});

});
function edit(thisval){

    $('#modalEdit').modal('show');
        $('#sname').val($(thisval).closest("tr").find("#name").text());
       $('#sprice').val($(thisval).closest("tr").find("#price").text());
       $('#sdesc').val($(thisval).closest("tr").find("#desc").text());
    $('#id').val(thisval.id);
    }
function Delservice(thisval){
    $('#modaldelete').modal('show');
    $('#did').val(thisval.id);
}
</script>

<div class="page-content-wrapper">
<!-- START PAGE CONTENT -->
<div class="content">
<!-- START JUMBOTRON -->
<div class="jumbotron bg-white" data-pages="parallax">
    <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
        <div class="inner">
            <!-- START BREADCRUMB -->
            <ul class="breadcrumb">
                <li>
                    <p>Services</p>
                </li>
                <li><a href="#" class="active"> </a>
                </li>
            </ul>
            <!-- END BREADCRUMB -->
        </div>


        <div class="panel panel-transparent">

            <div class="panel-body">
                <!-- Nav tabs -->
                <ul id="tabs-rickshaw" class="nav nav-tabs nav-tabs-linetriangle">
                    <li class="active">
                        <a data-toggle="tab" href="#tab-rickshaw-realtime">
                            <span>Active</span>
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#tab-rickshaw-bars">
                            <span>Deactive</span>
                        </a>
                    </li>

                </ul>
                <!-- Tab panes -->
                <div class="tab-content no-padding bg-transparent">
                    <div class="tab-pane relative active" id="tab-rickshaw-realtime">


                        <div class="panel panel-transparent">
                            <div class="panel-heading">
                                <div class="panel-title pull-right">

        <button class="btn btn-primary btn-cons" id="callm">Add</button>
<!---->
<!--                                    <button class="btn btn-green btn-lg pull-right" data-target="#modalFillIn" data-toggle="modal" id="btnFillSizeToggler2">Generate</button>-->
                                </div>

                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <div id="detailedTable_wrapper" class="dataTables_wrapper form-inline no-footer"><table class="table table-hover table-condensed table-detailed dataTable no-footer" id="detailedTable" role="grid">
                                            <thead>
                                            <tr role="row">
                                                <th style="width: 192px;" class="sorting_disabled" rowspan="1" colspan="1">SLNO</th>
                                                <th style="width: 190px;" class="sorting_disabled" rowspan="1" colspan="1">SERVICE</th>
                                                <th style="width: 189px;" class="sorting_disabled" rowspan="1" colspan="1">PRICE</th>
                                                <th style="width: 189px;" class="sorting_disabled" rowspan="1" colspan="1">DESCRIPTION</th>
                                                <th style="width: 189px;" class="sorting_disabled" rowspan="1" colspan="1">STATUS</th>
                                                <th style="width: 189px;" class="sorting_disabled" rowspan="1" colspan="1">option</th>
                                            </tr>
                                            </thead>
                                            <tbody>

    <?php
  $Slno=1;
    foreach($service as $result){
    ?>
                                      <tr role="row" class="odd">
                                                <td class="v-align-middle semi-bold"><?php echo $Slno ?></td>
                                                <td class="v-align-middle" id="name"><?php echo $result->name ?></td>
                                                <td class="v-align-middle semi-bold"  id="price"><?php echo $result->price ?></td>
                                                <td class="v-align-middle"  id="desc"><?php echo $result->description ?></td>

                                                <td class="v-align-middle semi-bold"><?php echo $result->status ?></td>
                                                <td class="v-align-middle">

                                                    <div class="btn-group" >
                                                        <button  onclick="edit(this)" id="<?php echo $result->service_id;?>" type="button" style="color: #ffffff !important;background-color: #10cfbd;"  class="btn btn-success" ><i class="fa fa-pencil"></i>
                                                        </button>
                                                        <button type="button" onclick="Delservice(this)" id="<?php echo $result->service_id;?>" class="btn btn-success" style="color: #ffffff !important;background-color: #10cfbd;"><i class="fa fa-trash-o"></i>
                                                        </button>
                                                    </div>

                                                </td>
                                            </tr>
    <?php $Slno++; } ?>

                                            </tbody>
                                        </table></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="tab-rickshaw-bars">
                        <div class="panel panel-transparent">
                            <div class="panel-heading">
                                <div class="panel-title">Pages detailed view table
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <div id="detailedTable_wrapper" class="dataTables_wrapper form-inline no-footer"><table class="table table-hover table-condensed table-detailed dataTable no-footer" id="detailedTable" role="grid">
                                            <thead>
                                            <tr role="row"><th style="width: 192px;" class="sorting_disabled" rowspan="1" colspan="1">Title</th><th style="width: 190px;" class="sorting_disabled" rowspan="1" colspan="1">Status</th><th style="width: 189px;" class="sorting_disabled" rowspan="1" colspan="1">Price</th><th style="width: 189px;" class="sorting_disabled" rowspan="1" colspan="1">Last Update</th></tr>
                                            </thead>
                                            <tbody>




                                            <tr role="row" class="odd">
                                                <td class="v-align-middle semi-bold">Revolution Begins</td>
                                                <td class="v-align-middle">Active</td>
                                                <td class="v-align-middle semi-bold">40,000 USD</td>
                                                <td class="v-align-middle">April 13, 2014</td>
                                            </tr><tr role="row" class="even">
                                                <td class="v-align-middle semi-bold">Revolution Begins</td>
                                                <td class="v-align-middle">Active</td>
                                                <td class="v-align-middle semi-bold">70,000 USD</td>
                                                <td class="v-align-middle">April 13, 2014</td>
                                            </tr><tr role="row" class="odd">
                                                <td class="v-align-middle semi-bold">Revolution Begins</td>
                                                <td class="v-align-middle">Active</td>
                                                <td class="v-align-middle semi-bold">20,000 USD</td>
                                                <td class="v-align-middle">April 13, 2014</td>
                                            </tr><tr role="row" class="even">
                                                <td class="v-align-middle semi-bold">Revolution Begins</td>
                                                <td class="v-align-middle">Active</td>
                                                <td class="v-align-middle semi-bold">90,000 USD</td>
                                                <td class="v-align-middle">April 13, 2014</td>
                                            </tr></tbody>
                                        </table></div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>




    </div>


</div>
<!-- END JUMBOTRON -->

    <form id="form-work" class="form-horizontal" method="post" role="form" autocomplete="off" novalidate="novalidate"   action="addservices">
    <div class="modal fade slide-up disable-scroll in" id="modalSlideUp" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                        <h5>Add <span class="semi-bold">Service</span></h5>
                        <p class="p-b-10"></p>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="form-group-attached">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group form-group-default">
                                            <label>Service Name</label>
                                            <input type="text" class="form-control" name="servicedata[name]">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-group-default">
                                            <label>Price</label>
                                            <input type="text" class="form-control" name="servicedata[price]">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-group-default">
                                            <label>Description</label>
                                            <input type="text" class="form-control" name="servicedata[description]">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="form-control"  name="servicedata[mas_id]" value="<?php echo $this->session->userdata("LoginId")?>">
                                 <input type="hidden" value="active" name="servicedata[status]">
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-sm-8">

                            </div>
                            <div class="col-sm-4 m-t-10 sm-m-t-10">
                                <button type="submit" class="btn btn-primary btn-block m-t-5">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
        </form>





    <form id="form-work" class="form-horizontal" method="post" role="form" autocomplete="off" novalidate="novalidate"   action="updateservices/services">
        <div class="modal fade slide-up disable-scroll in" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content-wrapper">
                    <div class="modal-content">
                        <div class="modal-header clearfix text-left">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                            </button>
                            <h5>Edit <span class="semi-bold">Service</span></h5>
                            <p class="p-b-10"></p>
                        </div>
                        <div class="modal-body">
                            <form role="form">
                                <div class="form-group-attached">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group form-group-default">
                                                <label>Service Name</label>
                                                <input type="text" class="form-control" name="editservicedata[name]" id="sname">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group form-group-default">
                                                <label>Price</label>
                                                <input type="text" class="form-control" name="editservicedata[price]" id="sprice">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label>Description</label>
                                                <input type="text" class="form-control" name="editservicedata[description]" id="sdesc">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="id" id="id" >

                                </div>
                            </form>
                            <div class="row">
                                <div class="col-sm-8">

                                </div>
                                <div class="col-sm-4 m-t-10 sm-m-t-10">
                                    <button type="submit" class="btn btn-primary btn-block m-t-5">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </div>
    </form>


    <form id="form-work" class="form-horizontal" method="post" role="form" autocomplete="off" novalidate="novalidate"   action="deleteservices/services">
    <div class="modal fade stick-up in" id="modaldelete" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                        <h5>Are you sure ?</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="did" name="id">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-cons  pull-left inline" data-dismiss="modal">Continue</button>
                        <button type="submit" class="btn btn-default btn-cons no-margin pull-left inline" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    </form>

<!-- START CONTAINER FLUID -->
<div class="container-fluid container-fixed-lg">
    <!-- BEGIN PlACE PAGE CONTENT HERE -->

    <!-- END PLACE PAGE CONTENT HERE -->
</div>
<!-- END CONTAINER FLUID -->

</div>
<!-- END PAGE CONTENT -->
<!-- START FOOTER -->
<div class="container-fluid container-fixed-lg footer">
    <div class="copyright sm-text-center">
        <p class="small no-margin pull-left sm-pull-reset">
            <span class="hint-text">Copyright © 2014</span>
            <span class="font-montserrat">REVOX</span>.
            <span class="hint-text">All rights reserved.</span>
                <span class="sm-block"><a href="#" class="m-l-10 m-r-10">Terms of use</a> | <a href="#" class="m-l-10">Privacy Policy</a>
                </span>
        </p>
        <p class="small no-margin pull-right sm-pull-reset">
            <a href="#">Hand-crafted</a>
            <span class="hint-text">&amp; Made with Love ®</span>
        </p>
        <div class="clearfix"></div>
    </div>
</div>
<!-- END FOOTER -->
</div>