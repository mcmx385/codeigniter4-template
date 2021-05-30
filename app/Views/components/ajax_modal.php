<div id="uni_modal" class="modal fade">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" id="uni_modal_content">
        </div>
    </div>
</div>
<script type="text/javascript">
    var isloading = false;
    // Do not document ready this, it will try do ajax
    function ajaxModal(dataid) {
        if (!isloading) {
            isloading = true;
            $.ajax({
                url: '/ajax/modal',
                type: "ajax",
                method: "post",
                data: {
                    action: dataid,
                },
                success: function(data) {
                    $('#uni_modal_content').html(data);
                    isloading = false;
                }
            });
        }
    }
    $(document).ready(function() {
        $('.uni_modal').click(function() {
            var dataid = $(this).attr("data-id");
            ajaxModal(dataid);
            $('#uni_modal').modal("show");
        });
    });
</script>