function loadData(){
    $.ajax({
        url:"{{ path('getOneSettlement') }}",
        method: "POST",
        data:{
            "postalCode": document.getElementById("postalCode").value
        },
        success: function(eredmeny){
            $("#settlement").val(eredmeny.settlementName);
            $("#region_name").val(eredmeny.region_ID.region_Name);
            console.log(eredmeny);
        }
    });

}
$(document).ready(function (){
    $.ajax({
        url: "{{ path('getAllCountry') }}",
        success:function (eredmeny){
            var select = document.getElementById("country");
            console.log(eredmeny);
            $.each(eredmeny, function (key,value){
                var opt = document.createElement('option');
                opt.value = value.id;
                opt.innerHTML = value.country_name;
                select.appendChild(opt);
            });
        }
    });

});