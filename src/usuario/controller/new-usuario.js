$(document).ready(function() {
    $('.btn-new').click(function(e) {
        e.preventDefault()

        $('.modal-title').empty()
        $('.modal-body').empty()

        $('.modal-title').append('Adicionar novo usuário')

        $('.modal-body').load('src/usuario/view/form-usuario.html', function() {
            // CARREGAR TODOS OS TIPOS DE USUÁRIOS EXISTENTES NO BANCO DE DADOS
            $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    assync: true,
                    url: 'src/tipo-usuario/model/all-tipo.php',
                    success: function(dados) {
                        for (const dado of dados) {
                            $('#tipo_usuario_idtipo_usuario').append(`<option value="${dado.idtipo_usuario}">${dado.descricao}</option>`)
                        }
                    }
                })
                // CARREGAR TODOS OS CURSOS EXISTENTES NO BANCO DE DADOS
            $.ajax({
                type: 'POST',
                dataType: 'json',
                assync: true,
                url: 'src/curso/model/all-curso.php',
                success: function(dados) {
                    for (const dado of dados) {
                        $('#curso_idcurso').append(`<option value="${dado.idcurso}">${dado.nome}</option>`)
                    }
                }
            })
        })

        $('.btn-save').show()

        $('.btn-save').attr('data-operation', 'insert')

        $('#modal-usuario').modal('show')
    })
})
