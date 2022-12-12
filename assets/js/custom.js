$(document).ready(function() {
  $("#region").load('../assets/api/ajaxSearch/selectDep.php');
});
// register
const register = () => {
  let name = $("nombre").val();
  let mail = $("email").val();
  let phone = $("telefono").val();
  let pass = $("clave").val();

  $.ajax({
    url:
      "../assets/api/php/regUser.php?name=" +
      name +
      "?mail=" +
      mail +
      "?phone=" +
      phone +
      "?pass=" +
      pass,
    type: "get",
    success: function (data) {
      if (data === 1) {
        alert("El Usuario ha sido Guardado Satisfactoriamente");
        window.location.href = "../index.php";
      }
    },
  });
};

const valPass = () => {
  let pass = $("#clave").val();
  let valPass = $("#repetir_clave").val();
  if (valPass !== pass) {
    $(".valPass").addClass("active");
    $("#button2").prop("disabled", true);
  } else {
    $(".valPass").removeClass("active");
    $("#button2").prop("disabled", false);
  }
};

$("#region").change(function () {
  let dep = $("#region").val();
  $("#comuna").load('../assets/api/ajaxSearch/selectMun.php?dep=' + dep);
});

const saveTickets = (idEvent, ticketType, cant, referencia) => {
  let idEvnt = idEvent;
  let tType = ticketType;
  let qty = cant;
  let name = $("#name").val();
  let email = $("#email").val();
  let docType = $("#phone").val();
  let numDoc = $("#type").val();
  let phone = $("#numDoc").val();
  let ref = referencia
  console.log(idEvnt,
      ticketType,
      name,
      email,
      docType,
      numDoc,
      phone)
  // let referencia = <?php echo $referencia ?>;
  $.ajax({
      url: "../assets/api/php/tickets/saveTicketsSale.php?idEvent=" + idEvnt + "&ticketType=" + tType + "&cant=" + qty + "&name=" + name + "&email=" + email + "&docType=" + docType + "&numDoc=" + numDoc + "&phone=" + phone + "&referencia=" + ref,
      type: "get",
      dataType: "json",
      success: function(response) {
          // data && $('.waybox-button').submit()
          response ? alert('guardo') : alert('no guardo')
      },
  });
}
