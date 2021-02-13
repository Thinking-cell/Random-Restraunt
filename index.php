<!doctype html>
<html>

    <!--

    ****************************************************************************
    * I, Ranvir Singh, 000819787 certify that this material is my original work. 
    * No other person's work has been used without due acknowledgement
    ***************************************************************************


    Asynchronous calls gave me headaches!!
    -->
    <head>
        <title>Lab 2 – CSS Frameworks</title>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script>


            let dataString="";
            let fieldnames = [
                "employee_name",
                "employee_id" ,
                "department",
                "bonus"
            ];
            

            let fields = {
                        "employee_name": "",
                        "employee_id" :"",
                        "department":"",
                        "bonus":"",
            };
            
            
            
            function changed(fieldName) {
                var fieldValue = $(`#${fieldName}`).val();
                var data = {
                    field: fieldName,
                    value: fieldValue
                };
  
                $.post('validate.php', data)
                    .then(function(res) {
                        if(res.error === false) {
                            $(`#${res.field}`).removeClass('is-invalid');
                            $(`#${res.field}`).addClass('is-valid');
                            $(`#${res.field}`).parent().find('.invalid-feedback').text('');

                            
                            fields[fieldName]=fieldValue;
                                    
                        } else {
                            $(`#${res.field}`).addClass('is-invalid');
                            $(`#${res.field}`).removeClass('is-valid');
                            switch(res.error) {
                                case "ERROR_NON_ALPHA":
                                    $(`#${res.field}`).parent().find('.invalid-feedback').text(`must not have the numbers`);
                                    fields[fieldName]="";
                                    break;
                                case "ERROR_LENGTH":
                                    $(`#${res.field}`).parent().find('.invalid-feedback').text(`must be a certain length`);
                                    fields[fieldName]="";
                                    break;
                                case "ERROR_NON_INT":
                                    $(`#${res.field}`).parent().find('.invalid-feedback').text(`must be Integer only`);
                                    fields[fieldName]="";
                                    break;
                                case "ERROR_ELEMENT_NOTEXIST":
                                    $(`#${res.field}`).parent().find('.invalid-feedback').text(` entry doesn't exists`);
                                    fields[fieldName]="";
                                    break;

                                case "ERROR_NULL_VALUE":
                                    $(`#${res.field}`).parent().find('.invalid-feedback').text(` Please enter a numeric value`);
                                    fields[fieldName]="";
                                    break;

                                // non error responses
                                case "BONUS_ENABLED":
                                    $("#bonus").prop('disabled',false);
                                    $(`#${res.field}`).removeClass('is-invalid');
                                    $(`#${res.field}`).addClass('is-valid');
                                    $(`#${res.field}`).parent().find('.invalid-feedback').text('');
                                    fields[fieldName]=fieldValue;
                                    fields['bonus']="";
                                
                                    
                                    break;
                                case "BONUS_DISABLED":
                                    $("#bonus").prop('disabled',true);
                                    $(`#${res.field}`).removeClass('is-invalid');
                                    $(`#${res.field}`).addClass('is-valid');
                                    $(`#${res.field}`).parent().find('.invalid-feedback').text('');


                                    $(`#bonus`).removeClass('is-invalid');
                                    $(`#bonus`).removeClass('is-valid');
                                    
                                    $(`#bonus`).parent().find('.invalid-feedback').text('');
                                    fields[fieldName]=fieldValue;
                                    fields['bonus']="N/A";
                                    
                                
                                    
                                    break;

                                default:
                                    $(`#${res.field}`).parent().find('.invalid-feedback').text(`some other error.`);
                                    console.log("Some other error");
                                    break;
                            }
                        }
                        // preventing input if data is invalid

                        if((fields["employee_name"]===""||fields["employee_id"]===""||fields["department"]===""||fields["bonus"]===""))
                        {
                            $("#sB").prop('disabled',true);
                        }else
                        {
                            $("#sB").prop('disabled',false);
                        }
                    });
            }



            // submit code 

            $(document).ready(function(){

                $("#sB").on("click",function()
                {

                    
                    //let $rowTemplate = $('.row-template');
                    //let $dataContainer = $('.container-data');
                    

                    console.log("clicked");
                    

                    /*
                    
                        let hasBonus=false;
                    
                        fieldnames.forEach((fieldName)=>
                        {
                           
                            // for each fieldname and its value
                            var fieldValue=$(`#${fieldName}`).val();
                            
                            var data = {
                                field: fieldName,
                                value: fieldValue
                            };
                            

                            $.post('validate.php', data)
                            .then(function(res) {
                                //debug
                                console.log(res.error);
                                console.log(data);
                                
                                if((res.error==="BONUS_ENABLED"))
                                    hasBonus=true;

                                if(res.error === false||res.error==="BONUS_DISABLED"||res.error==="BONUS_ENABLED"||(res.error==="ERROR_NULL_VALUE"&&!hasBonus))
                                {
                                    // if any of the field is disabled

                                    
                                    if(!$(`#${fieldName}`).prop('disabled'))
                                        fields[fieldName]=fieldValue;
                                    else
                                        fields[fieldName]="N/A";

                                }
                            


                            });
                            
                                



                        });
                        */


                    console.log(fields);
                    console.log("The add row"+(fields["employee_name"]===""&&fields["employee_id"]===""&&fields["department"]===""&&fields["bonus"]===""));

                    // if all fields are correct
                    if(!(fields["employee_name"]===""&&fields["employee_id"]===""&&fields["department"]===""&&fields["bonus"]===""))
                    {

                        dataString=dataString+"<tr>";
                        dataString=dataString+"<td>"+fields['employee_name']+"</td>";
                        dataString=dataString+"<td>"+fields['employee_id']+"</td>";
                        dataString=dataString+"<td>"+fields['department']+"</td>";
                        dataString=dataString+"<td>"+fields['bonus']+"</td>";
                        dataString=dataString+"</tr>";
                        $('#dataTarget').html(dataString);


                        /*

                        console.log("add row code");
                        $rowClone = $rowTemplate.clone();
                        $rowClone.removeClass('d-none row-template')
                        $rowClone.find('.employee_name').text(fields['employee_name']);
                        $rowClone.find('.employee_id').text(fields['employee_id']);
                        $rowClone.find('.department').text(fields['department']);
                        $rowClone.find('.bonus').text(fields['bonus']);
                        $rowClone.appendTo($dataContainer);
                        */



                    }

                
 




                });
            
            
            });

            



        </script>
        
    </head>
    <body>
        <h1 class="ml-5">Employee Registry</h1>
        <div class="container">
            <form>
                <div >
                    <div class="row py-3">
                        <div class="col">
                            <label for="employee_name">Name</label>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" onkeyup="changed('employee_name')" id="employee_name" name="employee_name" value="" placeholder="e.g. John Smith">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col">
                            <label for="employee_id">Employee ID</label>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" onkeyup="changed('employee_id')" id="employee_id" name="employee_id" value="" placeholder="e.g. 123456789">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col">
                            <label for="department">Department</label>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" onkeyup="changed('department')" id="department" name="department" value="" placeholder="Sales">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col">
                            <label for="bonus">Bonus</label>
                        </div>
                        <div class="col">
                            <input disabled  type="text" class="form-control" onkeyup="changed('bonus')" id="bonus" name="bonus" value="" placeholder="250000">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row py-3">
                        <input type="button" class="btn btn-primary mb-2" id="sB" value="Submit Form" >
                    </div>
                </div>
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Employement Name</th>
                        <th>Employee ID</th>
                        <th>Department</th>
                        <th>Bonus</th>
                        
                    </tr>
                </thead>
                <tbody id="dataTarget">
                    <!--
                    <div class="container-data "  style="overflow: hidden;">
                        
                        <tr class="dataRow d-none row-template">
                            <td >
                                <div class="employee_name"></div>
                            
                            </td>
                            <td >
                                <div class="employee_id"></div>
                            </td>
                            <td>
                                <div  class="department"></div>
                            </td>
                            <td >
                                <div class="bonus"></div>
                            </td>
                        </tr>
                        
                        

                    </div>
                    -->
                    
                </tbody>
            </table>




        </div>
    </body>
</html>