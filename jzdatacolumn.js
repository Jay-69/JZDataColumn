function jzDataColumnTextEdit(id,attribute,key,url,loaderPath){
    $('#jzdc_input_id_'+id).val($('#jzdc_title_id_'+id).text());
    $('#jzdc_input_id_'+id).unbind('keyup');
    $('#jzdc_input_id_'+id).keyup(function(event){
        var keyCode = event.which;             
	if(keyCode == undefined){keyCode = event.keyCode;}
	if(keyCode==13){jzDataColumnTextSave(id,attribute,key,url,loaderPath);}
	if(keyCode==27){jzDataColumnTextDeny(id,attribute,key);}
    });
    $('#jzdc_info_id_'+id).hide(); 
    $('#jzdc_empty_id_'+id).hide();
    $('#jzdc_title_id_'+id).hide();
    $('#jzdc_input_id_'+id).show();
    $('#jzdc_input_id_'+id).focus();
    $('#jzdc_input_id_'+id).select();
    $('#jzdc_save_id_'+id).show();
    $('#jzdc_deny_id_'+id).show();
    return false;//just in case
}
    
function jzDataColumnTextSave(id,attribute,key,url,loaderPath){ 
    var pjaxId=$('#jzdc_title_id_'+id).closest('.pjax').attr('id');
    var tmpTitle=$('#jzdc_input_id_'+id).val();
    $('#jzdc_input_id_'+id).hide();
    $('#jzdc_input_id_'+id).blur();
    $('#jzdc_save_id_'+id).hide();
    $('#jzdc_deny_id_'+id).hide();
    $('#jzdc_info_id_'+id).hide(); 
    $('#jzdc_info_id_'+id).html('<img src="'+loaderPath+'">');
    $('#jzdc_info_id_'+id).show();
    $.ajax({
        timeout: 29000, //29 sec
	url: url,
	data: {data:JSON.stringify({id:key,attribute:attribute,value:$('#jzdc_input_id_'+id).val()})},
        dataType: 'json',
     	success:function(data){
            if(data.msg==1){
                $.pjax.reload({container:'#'+pjaxId,timeout:10000});                        
            }
            if(data.msg==0){
                $('#jzdc_empty_id_'+id).show(); 
                $('#jzdc_title_id_'+id).show();
                $('#jzdc_info_id_'+id).html(data.val);
                $('#jzdc_info_id_'+id).fadeOut(6000);
            }
     	},
     	error:function(e,st,ss){
            alert('Error! '+ss);
            window.location.reload();
     	},
     	complete:function(data){
//            alert(data.responseText);
     	},
    });   
    return false;
}

function jzDataColumnTextDeny(id){
    $('#jzdc_info_id_'+id).hide(); 
    $('#jzdc_save_id_'+id).hide();
    $('#jzdc_deny_id_'+id).hide();
    $('#jzdc_input_id_'+id).hide();
    $('#jzdc_title_id_'+id).show(); 
    $('#jzdc_empty_id_'+id).show(); 
}
