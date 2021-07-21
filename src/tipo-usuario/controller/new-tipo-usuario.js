$(document).ready(function() {
    $('.btn-new').click(function(e) {
        e.preventDefault()
        

        $('.modal-title').empty()
        $('.modal-body').empty()

        $('.modal-title').append('adicionar novo eixo tecnológico')
        $('.modal-body').load('src/tipo-usuario/view/form-tipo-usuario.html')
        $('.btn-save').show()
        $('.btn-save').attr('data-operation','insert')
        $('#modal-tipo').modal('show')
    })
})