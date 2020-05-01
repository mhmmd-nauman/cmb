    <div class="row">
        <div class="col-md-7 col-md-offset-2">
            <h3>Welcome {<?php echo $this->session->userdata['name']?>}</h3>
        </div>
         <div class="col-md-1"><a href="<?= site_url('users/changepassword')?>" class="btn btn-primary btn-sm">Change Password</a></div>
    </div>
<br><hr>
<?php if(in_array('admin-admin', $this->auth->userPermissions())){?>
      <div class="row">
         <div class="col-md-2 col-md-offset-1">
             <b> Departments</b>: <button class="btn btn-info btn-block"><?php echo $departments;?></button> 
         </div>
         <div class="col-md-2">
             <b> Bundles</b>: <button class="btn btn-info btn-block"><?php echo $number_of_bandels;?></button> 
         </div>
         <div class="col-md-2">
             <b> Courses</b>: <button class="btn btn-info btn-block"><?php echo count($courses);?></button> 
         </div>
      
         <div class="col-md-2 ">
             <b> Downloads</b>: <button class="btn btn-info btn-block"><?php echo $downloaded;?></button> 
         </div>
         <div class="col-md-2">
             <b> User visits</b>: <button class="btn btn-info btn-block"><?php echo $visits;?></button>  
         </div>
          
         
    </div>

<div class="row">
    <div class="col-md-10 col-md-offset-1" >
        <style type="text/css">
            .highcharts-figure, .highcharts-data-table table {
                min-width: 310px; 
                max-width: 800px;
                margin: 1em auto;
            }

            #container {
                height: 1300px;
            }

            .highcharts-data-table table {
                    font-family: Verdana, sans-serif;
                    border-collapse: collapse;
                    border: 1px solid #EBEBEB;
                    margin: 10px auto;
                    text-align: center;
                    width: 100%;
                    max-width: 500px;
            }
            .highcharts-data-table caption {
                padding: 1em 0;
                font-size: 1.2em;
                color: #555;
            }
            .highcharts-data-table th {
                    font-weight: 600;
                padding: 0.5em;
            }
            .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
                padding: 0.5em;
            }
            .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
                background: #f8f8f8;
            }
            .highcharts-data-table tr:hover {
                background: #f1f7ff;
            }

        </style>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                Highcharts.chart('container', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Course Material Bundle Repository Report'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: [<?php foreach ($users as $dpt){ ?>'<?php print( str_replace("Department of", "", $dpt->name));?>',<?php } ?>''],
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Count ',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },
                tooltip: {
                    valueSuffix: ' '
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -40,
                    y: 80,
                    floating: true,
                    borderWidth: 1,
                    backgroundColor:
                        Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                    shadow: true
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Courses Included',
                    data: [<?php foreach ($users as $dpt){ ?><?php if(key_exists($dpt->id, $courses_data)){echo count( $courses_data[$dpt->id]);}else{echo"0";}?>,<?php } ?>0]
                }, {
                    name: 'CMB Uploaded',
                    data: [<?php foreach ($users as $dpt){ ?><?php if(key_exists($dpt->id, $cmb_data)){echo count( $cmb_data[$dpt->id]);}else{echo"0";}?>,<?php } ?>0]
                }, {
                    name: 'CMB Downloaded By Students(1=15)',
                    data: [<?php foreach ($users as $dpt){ ?><?php if(key_exists($dpt->id, $cmb_downloaded)){echo  $cmb_downloaded[$dpt->id];}else{echo"0";}?>,<?php } ?>0]
                },
                {
                    name: 'CMB Revisions',
                    data: [<?php foreach ($users as $dpt){ ?><?php if(key_exists($dpt->id, $cmb_version)){echo  $cmb_version[$dpt->id];}else{echo"0";}?>,<?php } ?>0]
                }
                ] 
            });
        });
        </script>
        <figure class="highcharts-figure">
          <div id="container"></div>
          
        </figure>
    </div>
</div>
<?php } else if(in_array("4", $this->session->userdata['roles'])){ ?>
<div class="row">
        <div class="col-md-2 col-md-offset-3">
            <a href="<?= site_url('cmb')?>" class=" btn btn-success btn-small">View CMBs</a>    
         
        </div>
        
</div>
<?php }else {?>
<div class="row">
        <div class="col-md-2 col-md-offset-3">
            <a href="<?= site_url('cmb')?>" class=" btn btn-success btn-small">Manage CMBs</a>    
         
        </div>
        <div class="col-md-2 col-md-offset-1">
            <a href="<?= site_url('course')?>" class=" btn btn-success btn-small">Manage Courses</a>    
         
        </div>
        </div>
<?php } ?>
    </div>
</body>
</html>

