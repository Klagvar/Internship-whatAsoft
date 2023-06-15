document.addEventListener('DOMContentLoaded', () => {
	//Авторизация
    $('#auth').submit(function(){
        $.post(
            '../auth/auth_handler.php', // адрес обработчика
            $("#auth").serialize(), // отправляемые данные          
                        
            function(msg) { // получен ответ сервера  
                if (msg == "Вы успешно авторизировались!") 
                    window.location = '../index.php';
                $('#my_message').html(msg);
                $('#my_message').css('display', 'block');
                $('#my_message').css('height', 'auto');
            }
        );
        return false;
    });

    //Редактирование пользователя
    $('#edit_user').submit(function(){
        $.post(
            '../user/edit_user.php', // адрес обработчика
            $("#edit_user").serialize(), // отправляемые данные          
                        
            function(msg) { // получен ответ сервера  
                //$('#my_form').hide('slow');
                //location.reload();
                $('#my_message').html(msg);
                window.location = '../index.php';
            }
        );
        return false;
    });

    //Регистрация
    $('#reg').submit(function(){
        $.post(
            '../reg/reg_handler.php', // адрес обработчика
            $("#reg").serialize(), // отправляемые данные          
                        
            function(msg) { // получен ответ сервера  
                $('#my_message').html(msg);
                $('#my_message').css('display', 'block');
                $('#my_message').css('height', 'auto');
            }
        );
        return false;
    });

    //Редактирование строки в таблицу
    $('#edit_directory').submit(function(){
        $.post(
            '../directory/edit_directory.php', // адрес обработчика
            $("#edit_directory").serialize(), // отправляемые данные          
                        
            function(msg) { // получен ответ сервера  
                $('#my_message').html(msg);
                window.location = '../index.php';
            }
        );
        return false;
    });

    //ajax добавление
    $('#adding').submit(function(){
        $.post(
            '../directory/directory_handler.php', // адрес обработчика
            $("#adding").serialize(), // отправляемые данные          
                        
            function(msg) { // получен ответ сервера  
                //location.reload();
                $('#my_message').html(msg);
                $('#my_message').css('display', 'block');
                $('#my_message').css('height', 'auto');
                //$("#table").load("index.php #table");
            }
        );
        return false;
    });
});