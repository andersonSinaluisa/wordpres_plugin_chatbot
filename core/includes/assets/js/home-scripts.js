(function($) {
    $(document).ready(function() {
            
        var botonFlotante = $('<div id="chatbot" class="chatbot-ventana"></div><div class="boton-flotante"><a href="#" class="boton" id="btn-chat-wp-istg"><img src="'+chatbotwp.icon_url+'" alt="" srcset=""></a></div>');
        //mandar al inicio
        $('.wp-site-blocks').append(botonFlotante);
        let htmlchat = '<section class="msger"> <header class="msger-header"> <div class="msger-header-title"> <img src="./img/robot.png" alt="" srcset=""> <p>ChatBot</p></div></header> <main class="msger-chat"> <div class="msg left-msg"> <div class="msg-img" style="background-image: url(./img/bot.png)" ></div><div class="msg-bubble"> <div class="msg-info"> <div class="msg-info-name"> BOT </div><div class="msg-info-time">12:45</div></div><div class="msg-text"> Buenas tardes, gracias por escribir al Instituto Superior Tecnológico Guayaquil. </div></div></div><div class="msg left-msg"> <div class="msg-img" style="background-image: url(./img/bot.png)" ></div><div class="msg-bubble"> <div class="msg-info"> <div class="msg-info-name"> BOT </div><div class="msg-info-time">12:45</div></div><div class="msg-text"> ¿Cómo podemos ayudarle? </div></div></div></main> <form class="msger-inputarea"> <input type="text" class="msger-input" placeholder="Escribe una mensaje..."> <button type="submit" class="msger-send-btn"> <span></span></button> </form> </section>';

        $('#chatbot').append(htmlchat);

        $('#btn-chat-wp-istg').on( "click", function() {
            $('#chatbot').toggleClass('visible');

        });
            // Lógica para mostrar y ocultar la ventana emergente
        
            // Ejemplo de código para mostrar/ocultar la ventana con un botón
            
        
        
        
    });
})(jQuery);
