const saveTickets = () => {
    let idEvent = <?php echo $idEvent ?>;
    let ticketType = <?php echo $ticketsType ?>;
    let cant = <?php echo $cantidad ?>;
    let name = $("#name").val();
    let email = $("#email").val();
    let docType = $("#phone").val();
    let numDoc = $("#type").val();
    let phone = $("#numDoc").val();
    let referencia = <?php echo json_encode($referencia) ?>

    $.ajax({
        url: "../assets/api/php/tickets/saveTicketsSale.php?idEvent=" + idEvent + "&ticketType=" + ticketType + "&cant=" + cant + "&name=" + name + "&email=" + email + "&docType=" + docType + "&numDoc=" + numDoc + "&phone=" + phone + "&referencia=" + referencia,
        type: "get",
        dataType: "json",
        success: function(response) {
            console.log(response)
            if (response === 1) {
                $('.waybox-button').click()
            }
        },
    })
}
var win = navigator.platform.indexOf('Win') > -1;
                if (win && document.querySelector('#sidenav-scrollbar')) {
                    var options = {
                        damping: '0.5'
                    }
                    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
                }
                const eventGo = (id, nomEvent) => {
                    window.location.href = 'event.php?id=' + id + '&nomEvent=' + nomEvent;
                }