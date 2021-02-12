<!doctype html>
<html>
    <head>
        <title>Lab 2 – CSS Frameworks</title>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script>
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
                        } else {
                            $(`#${res.field}`).addClass('is-invalid');
                            $(`#${res.field}`).removeClass('is-valid');
                            switch(res.error) {
                                case "ERROR_NON_ALPHA":
                                    $(`#${res.field}`).parent().find('.invalid-feedback').text(`must not have the numbers`);
                                    break;
                                case "ERROR_LENGTH":
                                    $(`#${res.field}`).parent().find('.invalid-feedback').text(`must be a certain length`);
                                    break;
                                default:
                                    $(`#${res.field}`).parent().find('.invalid-feedback').text(`some other error.`);
                                    console.log("Some other error");
                                    break;
                            }
                        }
                    });
            }
        </script>
    </head>
    <body>
        <form>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="employee_name">Name</label>
                    <input type="text" class="form-control" onkeyup="changed('employee_name')" id="employee_name" name="employee_name" value="" placeholder="e.g. John Smith">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
        </form>
    </body>
</html>