$(document).ready(function() {
    $('.btn-new').click(function(e) {
        e.preventDefault()

        $('.nodal-tittle').empty()
        $('.modal-body').empty()

        $('.modal-tittle').append('adcioar novo eixo tecnológico')
        $('.modal-body').load('scr/eixo/view/form-eixo.html')
        $('.btn-save').show();
        $('.btn-save').attr('data-operation','insert')
        $('#modal-eixo').modal('show')
    })
})