$(function() {    
    var id = $("#sltEmpresaFirmaConvenio").find(':selected').val();        
    $("#divInformacionEmpresaMod").load('/index.php/controladorConvenioColectivo/ConsultarEmpresaPorRut/' + id);
        
    $('#sltEmpresaFirmaConvenio').attr('disabled', 'disabled');       
    $('#sltConvenioAcuerdoLaboEstatal').attr('disabled', 'disabled');       
    $('#sltCodMunicipio').attr('disabled', 'disabled');   
    $('#sltCodDepartamento').attr('disabled', 'disabled');   
    $('#sltPeriodoFirmaConven').attr('disabled', 'disabled');   
    $('#sltDireccTerri').attr('disabled', 'disabled');   
    $('#sltEstaPagoAuxConv').attr('disabled', 'disabled');   
    $('#sltModaliIncremSalarial').attr('disabled', 'disabled');  
    $('#sltPorcAcuerLaboral').attr('disabled', 'disabled');
    $('.radio').attr('disabled', 'disabled'); 
});