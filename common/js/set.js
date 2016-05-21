
$(function(){
        $("#product_select").change(function(){
        var value = $("#product_select option:selected").val();
        console.log(value);
        if(value)
        {
            console.log("true");
            $.get("getData.php?id="+ value, function(data){
                console.log("ajax!");
                $("#character_select").html("");
                for(var i=0;i<data.length;i++){
                    $("#character_select").append("<option value="+data[i].id+">"+data[i].character_name+"</option>");
                }
            })
        }
        else
        {
            console.log("false");
                $("#character_select").html("");
                $("#character_select").append('<option value="">----</option>');

        }
    })
})
