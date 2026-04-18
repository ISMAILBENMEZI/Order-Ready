const chatForm = document.getElementById('chat-form');
if (chatForm) {
    chatForm.onsubmit = function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch(window.chatConfig.storeUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': window.chatConfig.csrfToken
            }
        }).then(() => {
            document.getElementById('message-input').value = '';
            loadMessages();
        });
    };
}

function loadMessages() {
    fetch(window.chatConfig.fetchUrl)
        .then(res => {
            if (!res.ok) throw new Error('Not Found')
            return res.text();
        })
        .then(data => {
            const chatBox = document.getElementById('chat-box');
            if (chatBox) {
                chatBox.innerHTML = data;
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        })
        .catch(error => window.showAlert("Check your internet or server connection", "error"));
}

if (document.getElementById('chat-box')) {
    setInterval(loadMessages, 3000);
}