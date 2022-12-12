$(document).ready(function () {
  $(".responsive").slick({
    arrows: false,
    infinite: true,
    speed: 300,
    slidesToShow: 9,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 2,
        },
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
        },
      },
      {
        breakpoint: 520,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        },
      },
    ],
  });
  $("#bannerPrincipal").slick({
    arrows: false,
    infinite: true,
    speed: 1000,
    fade: true,
    cssEase: "linear",
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2500,
  });
  $("#region").load("./assets/api/ajaxSearch/selectDep.php");
  $("#regionCreate, #regionProd").load(
    "../assets/api/ajaxSearch/selectDep.php"
  );
  $("#regionEdit").load(
    "../assets/api/ajaxSearch/selectDepEdit.php?id=" + $("#idEvent").val()
  );
  $("#eventSelect").load("../assets/api/ajaxSearch/selectEvent.php");
});

$("#region").change(function () {
  let dep = $("#region").val();
  $("#comuna").load(
    "../assets/api/ajaxSearch/selectMun.php?dep=" + encodeURIComponent(dep)
  );
});
$("#regionEdit, #regionCreate, #regionProd").change(function () {
  let dep = $("#regionEdit, #regionCreate, #regionProd").val();
  $("#comunaEdit, #comunaCreate, #comunaProd").load(
    "../assets/api/ajaxSearch/selectMun.php?dep=" + encodeURIComponent(dep)
  );
});

const eventGo = (id, nomEvent, idUser) => {
  window.location.href =
    "./event.php?nomEvent=" + nomEvent + "&id=" + id + "&idUser=" + idUser;
};
