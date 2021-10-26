function SelectAuthor(){
    $('.alert').click(function(e) {
        e.preventDefault()
        let id = $(this).attr('id')
        let nome = $(this).attr('data-name')
        $('#resultado').append(`<div class="alert alert-warning">${nome}</div>
        <input type="hidden" name="usuario_idusuario" value="${id}"/>
        `)
        $('#' + id).hide()
    })
        
    }
    function BlockAuthor(){
        $('.alert').click('#resultado');{
           $('#resultado').block()
            // SelectAuthor('#resultado')
            // $('#resultado').append(`<div class="alert alert-warning">${nome}</div>
            // <input type="hidden" name="usuario_idusuario" value="${id}"/>
            // `)
            // if (id===$('#resultado')) {
            //     alert('este elemento já foi selecionado');
            // }
        }
            
        }

$(document).ready(function() {

    $('#autor').keyup(function(e) {
        e.preventDefault()

        let nome = `nome=${$(this).val()}`

       

        if ($(this).val().length >= 3) {

            $('#autores').empty()

            $.ajax({
                dataType: 'json',
                type: 'POST',
                assync: true,
                data: nome,
                url: 'src/usuario/model/find-usuario.php',
                success: function(dados) {
                    for (const dado of dados) {
                        $('#autores').append(`<div id="${dado.idusuario}" data-name="${dado.nome}" class="alert alert-secondary">${dado.nome}</div>`)
                    }
                    
                    SelectAuthor()
                    BlockAuthor()
                }
            })

        } else{
            $('#autores').empty()
        }


    })
})