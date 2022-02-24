function updateItem(rowId){
    $.ajax({
        url: "{{ path('allWarehouse') }}",
        success: function (result){
            $.each(result, function (key,value){
                var warehouseOption = $('<option>', {value:value.id, text:value.whName});
                $('#warehouse').append(warehouseOption);
                $('#updateWarehouse').append(warehouseOption);
            });
            document.getElementById("updateWarehouse").value = document.getElementById("whID"+rowId).innerHTML;
        }
    });
    $("#updateStatus").html("");
    $.ajax({
        url: "{{ path('allStatus') }}",
        success: function (result){
            $.each(result, function (key,value){
                var statusOption = $('<option>',{ value: value.id, text: value.status});
                $("#updateStatus").append(statusOption);
            });
            document.getElementById("updateStatus").value = document.getElementById("statusID"+rowId).innerHTML;
            console.log(document.getElementById("updateStatus").value);
        }
    });

    rowId = rowId.replace("btn","");
    id = document.getElementById("id"+rowId).innerHTML;
    capacity = document.getElementById("phoneCapacity"+rowId).innerHTML.replace("GB", "");
    document.getElementById("updateAmount").value = document.getElementById("amount"+rowId).innerHTML;
    document.getElementById("updatePrice").value = document.getElementById("purchasePrice"+rowId).innerHTML;
    document.getElementById("updateBrand").value = document.getElementById("brand"+rowId).innerHTML;
    document.getElementById("updateModel").value = document.getElementById("model"+rowId).innerHTML;
    document.getElementById("updateColor").value = document.getElementById("color"+rowId).innerHTML;
    document.getElementById("updateCapacity").value = parseInt(capacity);
    console.log(document.getElementById("updateStatus").value);
    console.log(document.getElementById("status"+rowId).innerHTML);
    console.log(parseInt(document.getElementById("statusID"+rowId).innerHTML));

    let url = document.getElementById("updateForm").action;
    var newUrl = url.replace("id", parseInt(id));
    document.getElementById("updateForm").action = newUrl;
    $("#updateOrder").show();
}

function addingStock(){
    $("#brandName").html("");
    $("#modelName").prop('disabled', 'disabled');
    $("#colorName").prop('disabled', 'disabled');
    $("#capacity").prop('disabled', 'disabled');
    $.ajax({
        url:"{{ path('allBrands') }}",
        method: "post",
        success: function (result){
            var defaultVal = $('<option>', {value:"", text:"Válassz modellt!"});
            $("#brandName").append(defaultVal);
            $.each(result, function (key,value){
                var brandOption = $('<option>', {value:value.id, text:value.brandName});
                $("#brandName").append(brandOption);
            });
        }
    });
}

function addBrandChange(){
    $.ajax({
        url:"{{ path('allModelByBrand') }}",
        method: "post",
        data:{
            "brandNameID": document.getElementById("brandName").value
        },
        success:function (result){
            $("#modelName").html("");
            $("#modelName").prop('disabled', false);
            $("#colorName").prop('disabled', 'disabled');
            $("#capacity").prop('disabled', 'disabled');
            var defaultVal = $('<option>', {value:"", text:"Válassz modellt!"});
            $("#modelName").append(defaultVal);
            $.each(result, function (key,value){
                var modelOption = $('<option>', {value:value.modelID.id, text:value.modelID.modelName});
                $("#modelName").append(modelOption);
            });


        }
    });
}

function addModellChange(){
    $.ajax({
        url:"{{ path('allColorByModel') }}",
        method: "post",
        data:{
            "modelNameID": document.getElementById("modelName").value
        },
        success:function (result){
            $("#colorName").html("");
            $("#colorName").prop('disabled', false);
            $("#capacity").prop('disabled', 'disabled');
            var defaultVal = $('<option>', {value:"", text:"Válassz színt!"});
            $("#colorName").append(defaultVal);
            $.each(result, function (key,value){
                var colorOption = $('<option>', {value:value.colorID.id, text:value.colorID.phoneColor});
                $("#colorName").append(colorOption);
            });

        }
    });
}

function addColorChange(){
    $.ajax({
        url:"{{ path('allCapacityByColor') }}",
        method: "post",
        data:{
            "colorNameID": document.getElementById("colorName").value
        },
        success:function (result){
            $("#capacity").html("");
            $("#capacity").prop('disabled', false);
            var defaultVal = $('<option>', {value:"", text:"Válassz kapacitást!"});
            $("#capacity").append(defaultVal);
            $.each(result, function (key,value){
                var capacityOption = $('<option>', {value:value.capacityID.id, text:value.capacityID.capacity});
                $("#capacity").append(capacityOption);
            });
        }
    });
}

function filterBrandChanged(){
    $("#models").show();
    $("#colors").hide();
    $("#capacities").hide();
    $("#szures").hide();
    $.ajax({
        url: "{{ path('allOrderedModel') }}",
        method: "post",
        data:{
            "brandID":document.getElementById("brands").value
        },
        success: function (result){
            $("#models").find("option").remove();
            var defaultVal = $('<option>', {value:"", text:"Válassz modelt"});
            $("#models").append(defaultVal);
            $.each(result, function (key,value){
                var modelOption = $('<option>', {value:value.phoneID.modelID.id, text:value.phoneID.modelID.modelName});
                $("#models").append(modelOption);
            });
        }

    });
}

function filterModellChanged(){
    $("#colors").show();
    $("#capacities").hide();
    $("#szures").hide();
    $.ajax({
        url: "{{ path('allOrderedColor') }}",
        method: "post",
        data:{
            "modelID":document.getElementById("models").value
        },
        success: function (result){
            console.log(result);
            $("#colors").find("option").remove();
            var defaultVal = $('<option>', {value:"", text:"Válassz színt"});
            $("#colors").append(defaultVal);
            $.each(result, function (key,value){
                var colorOption = $('<option>', {value:value.phoneID.colorID.id, text:value.phoneID.colorID.phoneColor});
                $("#colors").append(colorOption);
            });
        }

    });
}

function filterColorChanged(){
    $("#capacities").show();
    $("#szures").hide();
    $.ajax({
        url: "",
        method: "post",
        data:{
            "colorID":document.getElementById("colors").value
        },
        success: function (result){
            $("#capacities").find("option").remove();
            var defaultVal = $('<option>', {value:"", text:"Válassz méretet!"});
            $("#capacities").append(defaultVal);
            $.each(result, function (key,value){
                var capacityOption = $('<option>', {value:value.phoneID.capacityID.id, text:value.phoneID.capacityID.capacity});
                $("#capacities").append(capacityOption);
            });
        }

    });
}

function filterCapacityChanged(){
    $("#szures").show();
}