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
  if (valPass !== pass){
    $('.valPass').addClass('active')
    $('#button2').prop('disabled', true)
  }
  else{
    $('.valPass').removeClass('active')
    $('#button2').prop('disabled', false)
  }
};
