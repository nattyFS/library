$(document).ready(function() {

    $('#tipo_usuario').on('click', 'button.btn-delete', function(e) {

        e.preventDefault()

        let idtipo_usuario = `idtipo_usuario=${$(this).attr('id')}`

        Swal.fire({
            title: 'Library',
            text: 'Quer realmente excluir?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não'
        }).then((result => {
            if (result.value) {

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    assync: true,
                    data: idtipo_usuario,
                    url: 'src/tipo-usuario/model/delete-tipo.php',
                    success: function(dados) {
                        Swal.fire({
                            title: 'Library',
                            text: dados.mensagem,
                            icon: dados.tipo,
                            confirmButtonText: 'OK'
                        })

                        $('#tipo_usuario').DataTable().ajax.reload()
                    }
                })
            }
        }))

    })
})