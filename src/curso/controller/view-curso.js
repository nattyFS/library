$(document).ready(function() {

    $('#table-curso').on('click', 'button.btn-view', function(e) {

        e.preventDefault()

        // Alterar as informações do modal 

        $('.modal-title').empty()
        $('.modal-body').empty()

        $('.modal-title').append('Visualização de curso tecnológico')

        let idcurso = `idcurso=${$(this).attr('id')}`

        $.ajax({
            type: 'POST',
            dataType: 'json',
            assync: true,
            data: idcurso,
            url: 'src/curso/model/view-curso.php',
            success: function(dado) {
                if (dado.tipo == "success") {
                    $('.modal-body').load('src/curso/view/form-curso.html', function() {
                        $('#nome').val(dado.dados.nome)
                        $('#nome').attr('readonly', 'true')

                        var eixo = dado.dados.eixo_ideixo
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: 'src/eixo/model/all-eixo.php',
                            success: function(dados) {
                                for (const dado of dados) {
                                    if (dado.ideixo == eixo) {
                                        $('#eixo_ideixo').append(`<option value="${dado.ideixo}">${dado.nome}</option>`)
                                    }
                                }
                            }
                        })
                    })
                    $('.btn-save').hide()
                    $('#modal-curso').modal('show')
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