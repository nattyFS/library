$(document).ready(function() {

    $('#eixo').on('click', 'button.btn-view', function(e) {

        e.preventDefault()

        // Alterar as informações do modal 

        $('.modal-title').empty()
        $('.modal-body').empty()

        $('.modal-title').append('Visualização de eixo tecnológico')

        let ideixo = `ideixo=${$(this).attr('id')}`

        $.ajax({
            type: 'POST',
            dataType: 'json',
            assync: true,
            data: ideixo,
            url: 'src/eixo/model/view-eixo.php',
            success: function(dado) {
                if (dado.tipo == "success") {
                    $('.modal-body').load('src/eixo/view/form-eixo.html', function() {
                        $('#nome').val(dado.dados.nome)
                        $('#nome').attr('readonly', 'true')
                    })
                    $('.btn-save').hide()
                    $('#modal-eixo').modal('show')
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