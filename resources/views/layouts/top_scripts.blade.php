<script src="{{asset('js/bootstrap.bundle.min.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script>
var baseUrl = "{{ config('app.url') }}";

function showToast(message) {
    const $toast = $("#alert_toast");
    const $closeBtn = $("#close");
    $(".toast-text").html(message);

    $toast.removeClass('inactive').addClass("activee");
    setTimeout(function() {
        $toast.removeClass("activee").addClass('inactive');
    }, 1000);

    $closeBtn.on("click", function() {
        $toast.removeClass("activee").addClass('inactive');
    });
}
</script>