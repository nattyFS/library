$(document).ready(function() {
    $('.btn-new').click(function(e) {
        e.preventDefault()
        

        $('.modal-title').empty()
        $('.modal-body').empty()

        $('.modal-title').append('adicionar novo curso tecnológico')
        $('.modal-body').load('src/curso/view/form-curso.html', function(){
            $.ajax({
                type: 'POST',
                dataType: 'json',
                assync: true,
                url: 'src/eixo/model/all-eixo.php',
                success: function(dados) {
                    for (const dado of dados) {
                        $('#eixo_ideixo').append(`<option value="${dado.ideixo}">${dado.nome}</option>`)
                    }
                }
            })
        })

        $('.btn-save').show()
        $('.btn-save').attr('data-operation','insert')
        $('#modal-curso').modal('show')
    })
})