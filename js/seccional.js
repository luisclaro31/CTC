$(function() {
    $('#sltCaracteristicasSeccionalInactivo option:not(:selected)').attr('disabled',true);
    $('#sltEstado option:not(:selected)').attr('disabled',true);        
    $('#sltCodDepartamento').attr('disabled', 'disabled');
    $('#sltCodMunicipio').attr('disabled', 'disabled');   
    $('#sltTipoSeccional').attr('disabled', 'disabled');   
    $('#sltPeriodoVigJuntaDirectiva').attr('disabled', 'disabled');       
    $('#sltEstado').attr('disabled', 'disabled');   
    $('#sltCaracteristicasSeccionalInactivo').attr('disabled', 'disabled');   
    $('#sltBienesInmueblesProp').attr('disabled', 'disabled');   
    $('#sltSeccionalAfiliacion').attr('disabled', 'disabled');   
    $('#sltAfiliacionInt').attr('disabled', 'disabled');       
    $('.radio').attr('disabled', 'disabled');   
    $('.check').attr('disabled', 'disabled');       
});