<?php date_default_timezone_set('UTC');
$rupee = "$";
//error_reporting(0);

if($status == 5) {
    $vehicle_status = 'New';
    $new ="active";
    echo '<style> .searchbtn{float: left;  margin-right: 63px;}.dltbtn{float: right;}</style>';
}
else if($status == 2) {
    $vehicle_status = 'Accepted';
    $accept ="active";
   }
else if($status == 4) {
    $vehicle_status = 'Rejected';
      $reject = 'active';
 }
else if($status == 2) {
    $vehicle_status = 'Free';
  $free = 'active';
  }
else if($status == 1) {
    $active = 'active';
}
?>
<script>
    $(document).ready(function(){
        $('#searchData').click(function(){


            var dateObject = $("#start").datepicker("getDate"); // get the date object
            var st = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format
            var dateObject = $("#end").datepicker("getDate"); // get the date object
            var end = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format

            $('#createcontrollerurl').attr('href','<?php  echo base_url()?>index.php?/superadmin/Get_dataformdate/'+st+'/'+end);

        });

        $('#search_by_select').change(function(){


            $('#atag').attr('href','<?php echo base_url()?>index.php?/superadmin/search_by_select/'+$('#search_by_select').val());

            $("#callone").trigger("click");
        });


        $("#chekdel").click(function() {
            var val = [];
            $('.checkbox:checked').each(function(i){
                val[i] = $(this).val();
            });

            if(val.length > 0){
                if(confirm("Are you sure to Delete " +val.length + " Vehicle")){
                    $.ajax({
                        url:"<?php echo base_url('index.php?/superadmin')?>/deleteVehicles",
                        type:"POST",
                        data: {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',val:val},
                        dataType:'json',
                        success:function(result){
                            alert(result.affectedRows)

                            $('.checkbox:checked').each(function(i){
                                $(this).closest('tr').remove();
                            });
                        }
                    });
                }

            }else{
                alert("Please mark any one of options");
            }

        });


    });

</script>

<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper">
<!-- START PAGE CONTENT -->
<div class="content">
    <!-- START JUMBOTRON -->
    <div class="jumbotron" data-pages="parallax">
        <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
<!--            <div class="inner">-->
<!--                <!-- START BREADCRUMB -->
<!--                <ul class="breadcrumb">-->
<!--                    <li>-->
<!--                        <p>Company</p>-->
<!--                    </li>-->
<!--                    <li><a>Vehicles</a>-->
<!--                    </li>-->
<!--                    <li><a href="#" class="active">--><?php //echo $vehicle_status;?><!--</a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--                <!-- END BREADCRUMB -->
<!--            </div>-->






            <div class="panel panel-transparent ">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-fillup  bg-white">
                    <li class="<?php echo $new?>">
                        <a  href="<?php echo base_url(); ?>index.php?/superadmin/cities/1"><span>MANAGE</span></a>
                    </li>
                    <li class="<?php echo $accept?>">
                        <a  href="<?php echo base_url(); ?>index.php?/superadmin/cities/2"><span>LIST OF CITIES</span></a>
                    </li>
                   
                    <div class="pull-right m-t-10"><a href="<?php echo base_url()?>index.php?/superadmin/addnewvehicle"> <button class="btn btn-primary btn-cons">ADD</button></a></div>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="container-fluid container-fixed-lg bg-white">
                        <!-- START PANEL -->
                        <div class="panel panel-transparent">
                            <div class="panel-heading">
<!--                                --><?php //if($status == '5') {?>
<!--                                    <div class="pull-left"><a href="--><?php //echo base_url()?><!--index.php?/superadmin/addnewvehicle"> <button class="btn btn-primary btn-cons">ADD</button></a></div>-->
<!--                                --><?php //}?>

                                
                                <div>
                                    <div style="margin: 5%;">
                                        <div style="float: left;width: 45%;">
                                            <h2>Add a country</h2>
                                            <form action="" id="country_form">
                                              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                Country Name : <input type="text" id="country_name" name="country_name" style="width: 180px;" mandatory=""><br><br><br><br>
                                                <input type="button" id="add_country" value="Add Country" style="width: 180px;"><br><br><br>
                                            </form>
                                            <span style="color: red;" id="country_span"></span>
                                        </div>
                                        <div style="float: left;width: 45%;"><br><br>
                                            <h2>Add a City</h2>
                                            <br><br>
                                            <form action="" id="city_form">
                                               <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                Country: 
                                                <select id="country_list" name="country_id" style="width: 180px;">
                                                    <option value="">SELECT A COUNTRY</option>
                                                    <option value="1">US</option><option value="2">DE - Germany</option><option value="3">IQ</option><option value="4">GE</option><option value="5">BH</option>
                                                    <option value="6">KW</option><option value="7">QA</option><option value="8">AF</option><option value="9">OM</option>
                                                    <option value="10">TM</option><option value="11">XK</option><option value="12">IL</option><option value="13">KG</option>
                                                    <option value="14">SC</option><option value="15">CU</option><option value="16">DJ</option><option value="17">GB</option>
                                                    <option value="18">IT</option><option value="19">ES</option><option value="20">BE</option><option value="21">NL</option>
                                                    <option value="22">GL</option><option value="23">NO</option><option value="24">DK</option><option value="25">MA</option>
                                                    <option value="26">PT</option><option value="27">RU</option><option value="28">PL</option><option value="29">FI</option>
                                                    <option value="30">CA</option><option value="31">FR</option><option value="32">GI</option><option value="33">RO</option>
                                                    <option value="34">BG</option><option value="35">BA</option><option value="36">AE</option><option value="37">SA</option>
                                                    <option value="38">TR</option><option value="39">CY</option><option value="40">EG</option><option value="41">GR</option>
                                                    <option value="42">NI</option><option value="43">PA</option><option value="44">SV</option><option value="45">GY</option>
                                                    <option value="46">HN</option><option value="47">BS</option><option value="48">PY</option><option value="49">EC</option>
                                                    <option value="50">KR</option><option value="51">JP</option><option value="52">TH</option><option value="53">PH</option>
                                                    <option value="54">ID</option><option value="55">CN</option><option value="56">NZ</option><option value="57">SG</option>
                                                    <option value="58">AU</option><option value="59">MH</option><option value="60">IO</option><option value="61">AQ</option>
                                                    <option value="62">IN</option><option value="63">SI</option><option value="64">UK</option><option value="65">Lebanon</option>
                                                     <option value="66">Luxembourg</option><option value="67">AU - Australia</option><option value="68">Sri lanka</option>
                                                     <option value="69">Pakistan</option><option value="70">FR</option><option value="71">ae</option>
                                                     <option value="72">Western Asia</option><option value="73">Isreal</option><option value="74">Moroco</option>
                                                     <option value="75">Sri Lanka</option><option value="76">Egypt</option><option value="77">Spain</option>
                                                     <option value="78">Brazil</option><option value="79">Turkey</option><option value="80">India</option>
                                                     <option value="81">India</option><option value="82">Mozambique</option><option value="83">pakistan</option>
                                                     <option value="84">INDIA</option><option value="85">Deutschland</option><option value="86">BO</option>
                                                     <option value="87">USA</option><option value="88">Jamaica</option><option value="89">Australia</option>
                                                     <option value="90">British Columbia</option><option value="91">South Africa</option>
                                                     <option value="92">Kenya</option><option value="93">Tanzania</option><option value="94">Slovenia</option>
                                                     <option value="95">Zimbabwe</option><option value="96">india</option><option value="97">indiA</option>
                                                     <option value="98">123</option><option value="99">Latvia</option><option value="100">Kuwait</option>
                                                     <option value="101">Tunisia</option><option value="102">Canada</option><option value="103">VENEZUELA</option>
                                                     <option value="104">Puerto Rico</option><option value="105">JAPAN</option><option value="106">Scotland</option>
                                                     <option value="107">Costa Rica</option><option value="108">Cameroon</option><option value="109">Campania</option>
                                                     <option value="110">Italy</option><option value="111">El Salvador</option><option value="112">Mexico</option>
                                                     <option value="113">us</option><option value="114">Ireland</option><option value="115">Guatemala</option>
                                                     <option value="116">Colombia</option><option value="117">Europe</option><option value="118">United States</option>
                                                     <option value="119">Indonesia</option><option value="120">Bahrain</option><option value="121">UAE</option>
                                                     <option value="122">Bangladesh</option><option value="123">pak</option><option value="124">Belarus</option> </select><br><br><br><br>
                                                     City Name : <input type="text" id="city_name" name="city_name" style="width: 180px;" mandatory=""><br><br><br>
                                                     Currency : <input type="text" id="currency" name="currency" style="width: 180px;" mandatory=""><br><br><br>
                                                <input type="button" id="add_city" value="Add City" style="width: 180px;"><br>
                                            </form>
                                            <span style="color: red;" id="city_span"></span>
                                        </div>
                                        <div style="float: none;"></div>
                                    </div>

                                </div>


                                   
                                            <!--                                    <div class="pull-right"> <a href="--><?php //echo base_url()?><!--index.php?/superadmin/callExel/--><?php //echo $stdate;?><!--/--><?php //echo $enddate?><!--"> <button class="btn btn-primary" type="submit">Export</button></a></div>-->
                                            <?php if($status == '5') {?>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success" id="chekdel"><i class="fa fa-trash-o"></i>
                                                    </button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>




                            </div>
                           
                        </div>
                        <!-- END PANEL -->
                    </div>
                </div>
            </div>









        </div>


    </div>
    <!-- END JUMBOTRON -->

    <!-- START CONTAINER FLUID -->
    <div class="container-fluid container-fixed-lg">
        <!-- BEGIN PlACE PAGE CONTENT HERE -->

        <!-- END PLACE PAGE CONTENT HERE -->
    </div>
    <!-- END CONTAINER FLUID -->

</div>
<!-- END PAGE CONTENT -->