$(document).ready(function () {
  $(".responsive").slick({
    arrows: true,
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
          slidesToScroll: 3,
          infinite: true,
          dots: true,
        },
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
  });
  $("#bannerPrincipal").slick({
    infinite: true,
    speed: 2000,
    fade: true,
    cssEase: "linear",
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 5000,
  });
  $("#department").load("./assets/api/ajaxSearch/selectDep.php");
});

$("#department").change(function () {
  let dep = $("#department").val();
  $("#municipality").load("../assets/api/ajaxSearch/selectMun.php?dep=" + dep);
});

const eventGo = (id, nomEvent, idUser) => {
  window.location.href = "./event.php?nomEvent="+nomEvent+"&id="+id+"&idUser="+idUser;
};
