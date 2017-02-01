<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<h3 class="text-center">Hola {{$user['name']}}</h3>
<hr>
<div class="well">
    <h3 class="text-center text-success">Revision terminada</h3>
    <div class="row">
        <div class="col-xs-18 col-sm-12 col-md-12 col-lg-12">
            <h4 class="text-justify">Te queremos indicar que la revision que asignaste a <span class="text-info">
                    {{\App\User::where('id', $request['oficina']['idUsuarioAsignado'])->value('name')}}
                </span> , ya se encuentra
                completada y lista para revisar.</h4>
        </div>


        <br>
        <br>
        <a class="btn btn-block btn-default" href="http://dpp2017.fortunato.cl">IR A PAGINA</a>


    </div>


</div>
</body>
</html>