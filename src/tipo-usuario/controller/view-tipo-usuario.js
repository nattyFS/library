$(document).ready(function() {

    $('#tipo_usuario').on('click', 'button.btn-view', function(e) {

        e.preventDefault()

        // Alterar as informações do modal 

        $('.modal-title').empty()
        $('.modal-body').empty()

        $('.modal-title').append('Visualização de eixo tecnológico')

        let idtipo_usuario = `idtipo_usuario=${$(this).attr('id')}`

        $.ajax({
            type: 'POST',
            dataType: 'json',
            assync: true,
            data: idtipo_usuario,
            url: 'src/tipo-usuario/model/view-tipo-usuario.php',
            success: function(dado) {
                if (dado.tipo == "success") {
                    $('.modal-body').load('src/tipo-usuario/view/form-tipo-usuario.html', function() {
                        $('#descricao').val(dado.dados.descricao)
                        $('#descricao').attr('readonly', 'true')
                    })
                    $('.btn-save').hide()
                    $('#modal-tipo').modal('show')
                } else {
                    Swal.fire({ // Inicialização do SweetAlert
                        title: 'Library', // Título da janela SweetAler
                        text: dado.mensagem, // Mensagem retornada do microserviço
                        type: dado.tipo, // Tipo de retorno [success, info ou error]
                        confirmButtonText: 'OK'
                    })
                }
            }
        })

    })
})