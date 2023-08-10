(function ($) {
  $(document).ready(function () {

    console.log("hola");
    const msgerInput = get(".msger-input");
    const msgerChat = get(".msger-chat");
    const BOT_IMG = "bot.png";
    const PERSON_IMG = "user.png";
    const BOT_NAME = "BOT";
    const PERSON_NAME = "Tú";



    function saludo() {
      const date = new Date();
      const hour = date.getHours();
      if (hour < 12) {
        return 'Buenos días';
      } else if (hour < 18) {
        return 'Buenas tardes';
      } else {
        return 'Buenas noches';
      }
    }

    $(".msger-send-btn").on("click", function () {

      const msgText = $('#chatbot > section > form > input').val();
      if (!msgText) return;
      $('#chatbot > section > form > input').val('');
      addChat(PERSON_NAME, PERSON_IMG, "right", msgText);
      getResponseApi(msgText).then((data) => {
        //escoger una respuesta random
        
        if (data.answers.length == 0) {
          data.answers = [
            {
              text: "Lo siento, no te he entendido"
            }
          ]
        }

        const random = Math.floor(Math.random() * data.answers.length);
        let text = data.answers[random].text.replace('_SALUDO_', saludo());
        addChat(BOT_NAME, BOT_IMG, "left", text);
      });
    });



    function addChat(name, img, side, text) {
      const msgHTML = `
    <div class="msg ${side}-msg">
      <div class="msg-img" style="background-image: url(${img})"></div>
      <div class="msg-bubble">
        <div class="msg-info">
          <div class="msg-info-name">${name}</div>
          <div class="msg-info-time">${formatDate(new Date())}</div>
        </div>
        <div class="msg-text">${text}</div>
      </div>
    </div>
  `;
      msgerChat.insertAdjacentHTML("beforeend", msgHTML);
      msgerChat.scrollTop += 500;
    }
    function get(selector, root = document) {
      return root.querySelector(selector);
    }
    function formatDate(date) {
      const h = "0" + date.getHours();
      const m = "0" + date.getMinutes();
      return `${h.slice(-2)}:${m.slice(-2)}`;
    }



    async function getResponseApi(msg) {

      const data = await $.ajax({
        type: 'POST',
        url: myAjax.ajax_url,
        data: {
          action: 'chat_ajax',
          text: msg
        },
        success: function (response) {
          

          return response;

        },
        error: function (xhr, textStatus, errorThrown) {
          return {
            answers: [
              {
                text: "Lo siento, no te he entendido"
              }
            ]
          }
        }
      });
      return data;
    }
  });
})(jQuery);
