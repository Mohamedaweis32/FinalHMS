$(document).ready(function(){
    $('.delete-btn').click(function(e) {
        e.preventDefault();
        var itemId = $(this).data('item-id');
        deleteItem(itemId);
    });
   
    $("#error").css("display", "none");
    $("#success").css("display", "none");
   
                })
    $("#hall_form").submit(function(e){   
             e.preventDefault();
             $.ajax({
                url:"../apis/halls.php",
                 data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                 method: 'POST',
                type: 'POST',
                success: function(resp) {
                alert(resp)
                 var res = jQuery.parseJSON(resp);
                 if (res.status == 200) {
                    window.location.href = '../application/view/admin/hall.php';
                //    $("#success").css("display", "block");
                //     $("#success").text(res.message);
              }     else if (res.status == 404) {
                //   $("#success").css("display", "none");
                //    $("#error").css("display", "block");
                //    $("#error").text(res.message);
              }
            
                 }
             });


         });
           
   
     $(document).ready(function() {
    // When a file is selected, display the image
    $('#hphoto').change(function(e) {
        var file = e.target.files[0];
        var reader = new FileReader();
        
        reader.onload = function(e) {
            $('#selected-image').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(file);
    });
});

$(document).ready(function() {
    $('.edit-btn').click(function() {
        var hallid = parseInt($(this).data('id'), 10);
        $.ajax({
            url: '../../../apis/halls.php',
            type: 'POST',
            data: { hallid: hallid },
            success: function(response) {
                alert(response)
                var hallData = JSON.parse(response);
                
                console.log(hallData.hall_photo);
                $('#htype').val(hallData.htype);
                $('#hall_id').val(hallData.hid);
                $('#hlocation').val(hallData.hlocation);
                $('#hdesc').val(hallData.hdesc);
                $('#hcapacity').val(hallData.hcapacity);
                $('#selected-image').attr('src', '../../../images/' + hallData.hall_photo);
            }
        });
    });
});


function deleteItem(itemId) {
    $.ajax({
        url: '../../../apis/halls.php',
        method: 'POST',
        data: { itemId: itemId },
        success: function(response) {
            window.location.href = 'hall.php';
            console.log(response);
            // Reload the page or update the UI as needed
        },
        error: function(xhr, status, error) {
            // Handle errors
            console.error(error);
        }
    });
}

