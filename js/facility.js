$(document).ready(function(){
    displayData();
                })
    $("#facility_form").submit(function(e){   
             e.preventDefault();
             $.ajax({
                url:"../../../apis/facilities.php",
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
                console.log("success")
                   $("#success").css("display", "block");
                    $("#success").text(res.message);
              }     else if (res.status == 404) {
                    console.log("failure")
                  $("#success").css("display", "none");
                   $("#error").css("display", "block");
                   $("#error").text(res.message);
              }
            
                 }
             });


         });
           
        function displayData(){
            var displayData="true";
        $.ajax({
                url:"../../../apis/facilities.php",
                type:'post',
                data:{
                displaysend:displayData

            },
                success:function(data,status){
                $('#displayDataTable').html(data);
                }
            });
        }
         
             $("#openModal").click(function() {
                $("facilityModal").show()
              });