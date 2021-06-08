<?PHP error_reporting(false); ?>
<script type="text/javascript">
    function PrintDiv() {
        var divToPrint = document.getElementById('divToPrint');
        var popupWin = window.open('', '_blank', 'width=300,height=300');
        popupWin.document.open();
        popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
        popupWin.document.close();
    }

</script>
<style>
    .padding-50 {
        padding: 10px !important;
      }
      .col-bottom {
        vertical-align: top;
      }
      .b-a {
        border-width: 1px 0px 1px 0px;
      }
</style>
<div class="page-content-wrapper" style="
     margin-top: 46px;
     ">
    <div class="inner">
        <!-- START BREADCRUMB -->
        <ul class="breadcrumb" style="margin-left: 20px;">
            
            <li>
                <a href="<?php echo base_url() ?>index.php/Admin/OrderHistory">ORDERS</a>
            </li>
            <li><a href="#" class="active">Order Details</a>
            </li>
        </ul>
        <!-- END BREADCRUMB -->
    </div>
    <!-- START PAGE CONTENT -->
    <div class="content" style="
         margin-top: -50px;">

        <div class="container-fluid container-fixed-lg" id="divToPrint">
            <nav class="navbar navbar-default bg-master-lighter sm-padding-10" role="navigation">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sub-nav">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="sub-nav">
                        <div class="row">

                            <div class="col-sm-4">
                                <ul class="nav navbar-nav navbar-center">
                                    <!--                                    <li><a href="#">Open</a>
                                                                        </li>-->
                                    <li><a data-toggle="tooltip" data-placement="bottom" title="Print" onclick="PrintDiv();"><i class="fa fa-print"></i></a>
                                    </li>

                                    <li>
                                        <a id="cmd" data-toggle="tooltip" data-placement="bottom" title="Download"><i class="fa fa-download"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-4">
                                &nbsp;
                            </div>
                            <div class="col-sm-4">
                                <ul class="nav navbar-nav navbar-right">
                                    <!--                                    <li>
                                                                            <a href="#" class="p-r-10"><img width="25" height="25" alt="" class="icon-pdf" data-src-retina="assets/img/invoice/pdf2x.png" data-src="assets/img/invoice/pdf.png" src="assets/img/invoice/pdf2x.png">
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#" class="p-r-10"><img width="25" height="25" alt="" class="icon-image" data-src-retina="assets/img/invoice/image2x.png" data-src="assets/img/invoice/image.png" src="assets/img/invoice/image2x.png">
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#" class="p-r-10"><img width="25" height="25" alt="" class="icon-doc" data-src-retina="assets/img/invoice/doc2x.png" data-src="assets/img/invoice/doc.png" src="assets/img/invoice/doc2x.png">
                                                                            </a>
                                                                        </li>-->
<!--                                    <li>
                                        <a href="#" class="p-r-10" onclick="$.Pages.setFullScreen(document.querySelector('html'));"><i class="fa fa-expand"></i></a>
                                    </li>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container-fluid -->
            </nav>
            <!-- START PANEL -->
            <div class="panel panel-default">
                <div class="panel-body" style="height: auto;">
                    <div class="invoice padding-50 sm-padding-10">
                        <div>
                            <div class="pull-left">
                                <!--                                <div class="pull-left">
                                                                   <img width="235" height="47" alt="" class="invoice-logo" data-src-retina="assets/img/invoice/squarespace2x.png" data-src="http://postmenu.cloudapp.net/PostMates/Logo.png" src="http://postmenu.cloudapp.net/PostMates/Logo.png">
                                                                    <img width="50" height="50"  class="invoice-logo"  src="http://postmenu.cloudapp.net/PostMates/Logo.png">
                                                                    <address class="m-t-10">
                                                                        iDeliver
                                                                        <br>(877) 412-7753.
                                                                        <br>
                                                                    </address>
                                                                </div>-->
                            </div>
                            <div class="pull-right sm-m-t-20">
                                <h2 class="font-montserrat all-caps hint-text">Invoice</h2>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <br>
                        <!--<br>-->
                        <div class="container-sm-height">
                            <div class="row-sm-height">
                                <div class="col-xs-10 col-sm-height sm-no-padding">
                                    
                                    <div>
                                        <div class="pull-left font-montserrat bold all-caps">Invoice No :</div>
                                        <div class=""> &nbsp;  <?PHP echo $OrderDetails['InvoiceNo']; ?> </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div>
                                        <div class="pull-left font-montserrat bold all-caps">Invoice date :</div>
                                        <div class=""> &nbsp;  <?PHP echo $OrderDetails['InvoiceDate']; ?> </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <br>
                                    <div>
                                    <address>
                                        <div class="pull-left font-montserrat bold all-caps" >Delivery Address : </div>
                                        <br>
                                        <div class=""><?PHP echo implode($ProfileData['Address'],','); ?></div>
<!--                                        <br>
                                        <strong>Contact : </strong>
                                        <br>-->
                                        <?PHP // echo $ProfileData['Phone']; ?>
                                    </address>
                                    </div>
                                    <br>
                                    <!--<p class="small no-margin">Invoice to</p>-->
                                    <h5 class="semi-bold m-t-0"><?PHP echo $OrderDetails['CustomerName']; ?></h5>
                                    <address>
<!--                                        <strong>Delivery Address : </strong>
                                        <br>
                                        <?PHP echo $OrderDetails['DeleveredAt']; ?> 
                                        <br>-->
                                        <strong>Contact : </strong>
                                        <br>
                                        <?PHP echo $OrderDetails['CustomerNumber']; ?>
                                    </address>
                                </div>
<!--                                <div class="col-md-4 col-sm-height sm-no-padding">
                                    <p class="small no-margin">Invoice From</p>
                                    <h5 class="semi-bold m-t-0"><?PHP // echo $ProfileData['ProviderName']; ?></h5>
                                    <address>
                                        <strong>Address : </strong>
                                        <br>
                                        <?PHP // echo implode($ProfileData['Address'],','); ?>
                                        <br>
                                        <strong>Contact : </strong>
                                        <br>
                                        <?PHP // echo $ProfileData['Phone']; ?>
                                    </address>
                                </div>-->
                                <div class="col-xs-2 col-sm-height sm-no-padding sm-p-b-20 col-bottom" style="width: 12%;"> 
                                 
<!--                                <div class="pull-left font-montserrat bold all-caps" >Delivered By : </div>-->
                                    <!--<p class="small no-margin">Delivery Details</p>-->
                                    <br><br><br>
                                     <div>
                                        <div class="pull-left font-montserrat bold all-caps">Delivered By :</div>
                                        <div class="pull-right" style="margin-right: 0px;">  <?PHP echo $OrderDetails['DeleveredBy']; ?></div>
                                        <div class="clearfix"></div>
                                    </div>
                                  
<!--                                    <div>
                                        <div class="pull-left font-montserrat bold all-caps">Driver Id :</div>
                                        <div class="pull-right"><?PHP // echo $OrderDetails['DeleveredById']; ?></div>
                                        <div class="clearfix"></div>
                                    </div>-->
                                   
                                    <div>
                                        <div class="pull-left font-montserrat bold all-caps">Delivery Time:</div>
                                        <div class="pull-right" style="margin-right: 100px;"><?PHP echo $OrderDetails['complete_dt']; ?></div>
                                        <div class="clearfix"></div>
                                    </div>
<!--                                    <div>
                                        <div class="pull-left font-montserrat bold all-caps">Invoice No :</div>
                                        <div class="pull-right">   <?PHP // echo $OrderDetails['InvoiceNo']; ?> </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div>
                                        <div class="pull-left font-montserrat bold all-caps">Invoice date :</div>
                                        <div class="pull-right">   <?PHP // echo $OrderDetails['InvoiceDate']; ?> </div>
                                        <div class="clearfix"></div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                        <div class="table-responsive">
                            <table class="table m-t-50">
                                <thead>
                                    <tr>
                                        <!--<th class="text-center">Sr. No</th>-->
                                        <th class="text-center">quantity</th>
                                        <th class="">Item Name</th>
                                        <th class="text-center">Price</th>
                                        
                                        <th class="text-center">Total (<?PHP echo $this->session->userdata('badmin')['Currency']; ?>)</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?PHP
//                                    $count = 1;
                                    foreach ($OrderDetails['Items'] as $Item) {
                                        echo '<tr>
                                           <td class="text-center">' . $Item['Qty'] . '</td>                                 
                                      <td class="">
                                            <p class="text-black">' . $Item['ItemName'] . '(' . $Item['PortionTitle'] . ')' . '</p>';
                                        $portion = 0;
                                        foreach ($Item['AddOns'] as $Adon) {
                                            echo '<p class="small hint-text">
                                                ' . $Adon['Title'] . '(' . number_format($Adon['Price'], 2, '.', ',') . ' ' . $this->session->userdata('badmin')['Currency'] . ')' . '
                                            </p>
                                        ';
                                            $portion += $Adon['Price'];
                                        }
                                        echo'</td>
                                            <td class="text-center"> ' . number_format($Item['PortionPrice'], 2, '.', ',') . '</td>
                                            
                                            <td class="text-center">' . number_format($Item['Qty'] * ($Item['PortionPrice'] + $portion), 2, '.', ',') . '</td>
                                                                        </tr>';
//                                        $count++;
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                        <!--                    <br>
                                            <br>
                                            <br>
                                            <br>
                                            <br>-->
                        <!--                    <div>
                                                <img width="150" height="58" alt="" class="invoice-signature" data-src-retina="assets/img/invoice/signature2x.png" data-src="assets/img/invoice/signature.png" src="assets/img/invoice/signature.png">
                                                <p>Designer’s Identity</p>
                                            </div>-->
                        <br>
                        <br>
                        <div class="container-sm-height b-a b-grey">
                           <div class="col-xs-12 col-sm-height sm-no-padding sm-p-b-20 col-bottom" style=""> 
                            <div class="col-xs-1 pull-right"></div>
                               <div class="col-xs-4 row row-sm-height b-a b-grey pull-right" style="margin-right:3%">
<!--                                <div class="col-sm-2 text-center col-sm-height col-middle p-l-25 sm-p-t-15 sm-p-l-15 clearfix sm-p-b-15">
                                    <h5 class="font-montserrat all-caps small no-margin hint-text bold">Sub Total</h5>
                                    <h4 class="no-margin"><?PHP echo $this->session->userdata('badmin')['Currency']; ?>&nbsp;<?PHP echo number_format($OrderDetails['Amount'], 2, '.', ','); ?></h4>
                                </div>
                                <div class="col-sm-2 text-center col-sm-height col-middle clearfix sm-p-b-15">
                                    <h5 class="font-montserrat all-caps small no-margin hint-text bold">Tax</h5>
                                    <h4 class="no-margin"><?PHP echo $this->session->userdata('badmin')['Currency']; ?>&nbsp;<?PHP echo number_format($OrderDetails['Tax'], 2, '.', ','); ?></h4>
                                </div>
                                
                                <div class="col-sm-2 text-center col-sm-height col-middle p-l-25 sm-p-t-15 sm-p-l-15 clearfix sm-p-b-15">
                                    <h5 class="font-montserrat all-caps small no-margin hint-text bold">Discount</h5>
                                    <h4 class="no-margin"><?PHP echo $this->session->userdata('badmin')['Currency']; ?>&nbsp;<?PHP echo number_format($OrderDetails['discount'], 2, '.', ','); ?></h4>
                                </div>
                                
                                <div class="col-sm-2 text-center col-sm-height col-middle clearfix sm-p-b-15">
                                    <h5 class="font-montserrat all-caps small no-margin hint-text bold">Delivery Charges</h5>
                                    <h4 class="no-margin"><?PHP echo $this->session->userdata('badmin')['Currency']; ?>&nbsp;<?PHP echo number_format($OrderDetails['mas_fee'], 2, '.', ','); ?></h4>
                                                                        <h5 class="font-montserrat all-caps small no-margin hint-text bold">Delivery Time</h5>
                                                                        <h4 class="no-margin"><?PHP echo $this->session->userdata('Currency'); ?>&nbsp;<?PHP echo number_format(50.00, 2, '.', ',');  ?></h4>
                                </div>
                                <div class="col-sm-2 text-center col-sm-height col-middle p-l-25 sm-p-t-15 sm-p-l-15 clearfix sm-p-b-15">
                                    <h5 class="font-montserrat all-caps small no-margin hint-text bold">Tip</h5>
                                    <h4 class="no-margin"><?PHP echo $this->session->userdata('badmin')['Currency']; ?>&nbsp;<?PHP echo number_format($OrderDetails['tip_amount'], 2, '.', ','); ?></h4>
                                </div>-->
<!--                                <div>
                                        <div class="pull-left font-montserrat bold all-caps">Delivered By :</div>
                                        <div class="pull-right"> <?PHP echo $OrderDetails['DeleveredBy']; ?></div>
                                        <div class="clearfix"></div>
                                </div>-->
                                    <br>
                                 <div class="">
                                    <div class="pull-left font-montserrat all-caps">Sub Total :</div>
                                    <div class="no-margin pull-right"><?PHP echo $this->session->userdata('badmin')['Currency']; ?>&nbsp;<?PHP echo number_format($OrderDetails['Amount'], 2, '.', ','); ?></div>
                                    <div class="clearfix"></div>
                                 </div>
                                <div class="">
                                    <div class="pull-left font-montserrat all-caps">App Commission :</div>
                                    <div class="no-margin pull-right"><?PHP echo $this->session->userdata('badmin')['Currency']; ?>&nbsp;<?PHP echo number_format($OrderDetails['app_commission'], 2, '.', ','); ?></div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="">
                                    <div class="pull-left font-montserrat all-caps">Total</div>
                                    <div class="no-margin pull-right"><?PHP echo $this->session->userdata('badmin')['Currency']; ?>&nbsp;<?PHP echo number_format($OrderDetails['Total'], 2, '.', ','); ?></div>
                                    <div class="clearfix"></div>
                                </div>
                                    <br>
                            </div>
                               
                           </div>
                        </div>
                        <hr>

                    </div>
                </div>
            </div>
            <!-- END PANEL -->
        </div>
    </div>


</div>