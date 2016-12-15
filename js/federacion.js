$(function() {
    $('#sltCaracteristicasFederacionInactivo option:not(:selected)').attr('disabled',true);
    $('#sltEstado option:not(:selected)').attr('disabled',true);        
    $('#sltCodDepartamento').attr('disabled', 'disabled');
    $('#sltCodMunicipio').attr('disabled', 'disabled');   
    $('#sltTipoFederacion').attr('disabled', 'disabled');       
    $('#sltPeriodoVigJuntaDirectiva').attr('disabled', 'disabled');       
    $('#sltEstado').attr('disabled', 'disabled');   
    $('#sltCaracteristicasFederacionInactivo').attr('disabled', 'disabled');   
    $('#sltBienesInmueblesProp').attr('disabled', 'disabled');   
    $('#sltAfiliacionInt').attr('disabled', 'disabled');   
    $('.check').attr('disabled', 'disabled');       
});