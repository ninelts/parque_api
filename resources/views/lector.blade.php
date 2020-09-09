<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript" src="{{URL::to('/')}}/js/html5-qrcode.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>


</head>

<body>
<h1 class="text-center">Code QR</h1>
<div class="mx-auto " style="width: 500px" id="reader"></div>

<div class="container p-5"  id='qr_qr'></div>
<script type="text/javascript">
function onScanSuccess(qrMessage) {
    document.getElementById('qr_qr').innerHTML = '';
    // handle the scanned code as you like
    console.log(`QR matched = ${qrMessage}`);

    axios({
    method:'get',
    url:`/api/lector/qr/token?token=${qrMessage}`,
    baseURL: 'http://localhost:8090',
   })
   .then(response => {
      console.log(response);
      if(response.data.estado == true){

      
      document.getElementById('qr_qr').innerHTML = `

      <div class="card">
  <h5 class="card-header">INFORMACION RESERVA</h5>
  <div class="card-body">
    <h5 class="card-title">Titular: ${response.data.datos.nombre}</h5>
    <h5 class="card-title">Estado Reserva : <button type="button" class="btn btn-success">Aprobado</button> </h5>
    <h5 class="card-title">Horario : ${response.data.datos.fecha_reserva}</h5>
    <h5 class="card-title">Precio : $${response.data.datos.precio}</h5>
  </div>
</div>
      `
    }else{
        document.getElementById('qr_qr').innerHTML= `
        <div class="card">
<h5 class="card-header">INFORMACION RESERVA</h5>
<div class="card-body">
<h5 class="card-title">Estado Reserva : <button type="button" class="btn btn-danger">Rechazada</button> </h5>
</div>
</div>
        `

    }
    //   document.getElementById('qr_respuesta').innerHTML = `${response.data.estado}`;
   })
   .catch(error => {
       console.log(error);
   });

 
    
}
 
function onScanFailure(error) {
    // handle scan failure, usually better to ignore and keep scanning
    console.warn(`QR error = ${error}`);
}
 
let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", { fps: 60, qrbox: 250 }, /* verbose= */ true);
html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
</body>

</html>