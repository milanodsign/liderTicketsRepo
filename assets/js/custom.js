$(document).ready(function() {
  $("#departamento").load('../assets/api/ajaxSearch/selectDep.php');
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

$("#departamento").change(function () {
  let dep = $("#departamento").val();
  $("#municipio").load('../assets/api/ajaxSearch/selectMun.php?dep=' + dep);
});

const saveTickets = (idEvent, ticketType, cant, referencia) => {
  let idEvent = idEvent;
  let ticketType = ticketType;
  let cant = cant;
  let name = $("#name").val();
  let email = $("#email").val();
  let docType = $("#phone").val();
  let numDoc = $("#type").val();
  let phone = $("#numDoc").val();
  let referencia = referencia
  console.log(idEvent,
      ticketType,
      name,
      email,
      docType,
      numDoc,
      phone)
  // let referencia = <?php echo $referencia ?>;
  $.ajax({
      url: "../assets/api/php/tickets/saveTicketsSale.php?idEvent=" + idEvent + "&ticketType=" + ticketType + "&cant=" + cant + "&name=" + name + "&email=" + email + "&docType=" + docType + "&numDoc=" + numDoc + "&phone=" + phone + "&referencia=" + referencia,
      type: "get",
      dataType: "json",
      success: function(response) {
          // data && $('.waybox-button').submit()
          response ? alert('guardo') : alert('no guardo')
      },
  });
}
