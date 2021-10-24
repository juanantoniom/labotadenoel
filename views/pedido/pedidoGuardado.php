<h6>Tu pedido ha sido recibido y guardado. Paga para poder enviarte el pedido</h6>
<div class="miClear"></div>


<!-- este boton nos llevaria a la pagina del banco para pagar
no lo ponemos porque esto es un ejemplo , lo redirigimos a la pagina de pedido enviado -->

<form  action="http://localhost/labotadenoel/?nombre_del_controlador=pedido&action=SendPedido" method="post">
    <button class="btn btn-primary buttonPay" type="submit" name="buttonPay">Pagar</button>
</form>


<!-- class="btn btn-primary buttonPay" -->
