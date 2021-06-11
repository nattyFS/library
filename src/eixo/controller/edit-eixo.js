$(document).ready(function() {

    $('#eixo').on('click', 'button.btn-edit', function(e) {

        e.preventDefault()

        

        $('.modal-title').empty()
        $('.modal-body').empty()

        $('.modal-title').append('Edição de eixo tecnológico')

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
                        $('#ideixo').val(dado.dados.ideixo)
                    })
                    $('.btn-save').show()
                    $('.btn-save').removeAttr('data-operation')
                    $('#modal-eixo').modal('show')
                } else {
                    Swal.fire({ 
                        title: 'Library', 
                        text: dado.mensagem, 
                        type: dado.tipo, // Tipo de retorno success, info ou error
                        confirmButtonText: 'OK'
                    })
                }
            }
        })

    })
})