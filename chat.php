
<div class='bloc-chat'>
    <div id='titre'> Chat</div>
    <div id='chat-bas'>
        <div id='chat'></div>
        <div id='input'>
            <form id="form-message" method="post" autocomplete="off"> 
                <input id='message' type="text" name="message" placeholder='votre message'> 
                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                <button id="envoyer" type="submit">Envoyer</button>
            </form>
            <div id="err"> </div>
        </div>
    </div>
</div>