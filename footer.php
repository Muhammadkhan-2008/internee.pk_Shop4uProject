<footer style="background:#111; color:#aaa; padding:40px 0; margin-top:50px; border-top: 3px solid #007cba;">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; margin-bottom: 30px;">
            <div>
                <h4 style="color: #fff; margin-bottom: 15px;">About Shop4U</h4>
                <p>Your one-stop shop for premium tech products at unbeatable prices.</p>
            </div>
            <div>
                <h4 style="color: #fff; margin-bottom: 15px;">Quick Links</h4>
                <ul style="list-style: none;">
                    <li><a href="<?php echo home_url(); ?>" style="color: #aaa; text-decoration: none;">Home</a></li>
                    <li><a href="<?php echo wc_get_page_id( 'shop' ); ?>" style="color: #aaa; text-decoration: none;">Shop</a></li>
                    <li><a href="<?php echo wc_get_page_id( 'cart' ); ?>" style="color: #aaa; text-decoration: none;">Cart</a></li>
                </ul>
            </div>
            <div>
                <h4 style="color: #fff; margin-bottom: 15px;">Contact Info</h4>
                <p>Email: <a href="mailto:info@shop4u.pk" style="color: #007cba;">info@shop4u.pk</a></p>
                <p>Phone: <a href="tel:+923000000000" style="color: #007cba;">+92 300 0000 000</a></p>
            </div>
        </div>
        <hr style="border: 1px solid #333; margin-bottom: 20px;">
        <p style="text-align: center;">&copy; <?php echo date('Y'); ?> Shop4U | Designed by Muhammad Khan | All Rights Reserved</p>
    </div>
</footer>

<!-- Live Chat Widget -->
<div id="chat-widget" style="position:fixed; bottom:20px; right:20px; z-index:9999; font-family: Arial, sans-serif;">
    <button id="chat-toggle" onclick="toggleChat()" style="background: linear-gradient(135deg, #25d366 0%, #128c7e 100%); color:#fff; border:none; padding:15px 20px; border-radius:50px; cursor:pointer; font-size:14px; font-weight:bold; box-shadow: 0 4px 12px rgba(0,0,0,0.3); transition: transform 0.3s;">
        💬 Chat Support
    </button>
    
    <div id="chat-box" style="display:none; position:absolute; bottom:70px; right:0; width:350px; height:400px; background:#fff; border-radius:10px; box-shadow: 0 5px 30px rgba(0,0,0,0.3); flex-direction:column; z-index:10000;">
        <div style="background: linear-gradient(135deg, #25d366 0%, #128c7e 100%); color:#fff; padding:15px; border-radius:10px 10px 0 0; display:flex; justify-content:space-between; align-items:center;">
            <h4 style="margin:0;">Shop4U Support</h4>
            <button onclick="toggleChat()" style="background:none; border:none; color:#fff; font-size:18px; cursor:pointer;">✕</button>
        </div>
        
        <div id="chat-messages" style="flex:1; padding:15px; overflow-y:auto; border-bottom:1px solid #ddd;">
            <div style="background:#f0f0f0; padding:10px; border-radius:5px; margin-bottom:10px;">
                <p style="margin:0; color:#333; font-size:13px;">👋 Hi! Welcome to Shop4U. How can we help you today?</p>
            </div>
        </div>
        
        <div style="padding:10px; display:flex; gap:10px;">
            <input type="text" id="chat-input" placeholder="Type message..." style="flex:1; padding:8px; border:1px solid #ddd; border-radius:5px; font-size:13px;">
            <button onclick="sendChatMessage()" style="background:#25d366; color:#fff; border:none; padding:8px 15px; border-radius:5px; cursor:pointer; font-weight:bold;">Send</button>
        </div>
        
        <div style="padding:10px; text-align:center; border-top:1px solid #ddd; font-size:12px; color:#666;">
            <p style="margin:0; margin-bottom:8px;">💬 WhatsApp Support</p>
            <a href="https://wa.me/923000000000?text=Hi%20Shop4U" target="_blank" style="background:#25d366; color:#fff; padding:8px 15px; border-radius:5px; text-decoration:none; display:inline-block; font-weight:bold;">Chat on WhatsApp</a>
        </div>
    </div>
</div>

<script>
function toggleChat() {
    const chatBox = document.getElementById('chat-box');
    chatBox.style.display = chatBox.style.display === 'none' ? 'flex' : 'none';
}

function sendChatMessage() {
    const input = document.getElementById('chat-input');
    const message = input.value.trim();
    
    if (message === '') return;
    
    const messagesDiv = document.getElementById('chat-messages');
    
    // User message
    const userMsg = document.createElement('div');
    userMsg.style.cssText = 'background:#007cba; color:#fff; padding:10px; border-radius:5px; margin-bottom:10px; margin-left:30px; text-align:right;';
    userMsg.textContent = message;
    messagesDiv.appendChild(userMsg);
    
    // Auto-reply
    setTimeout(() => {
        const botMsg = document.createElement('div');
        botMsg.style.cssText = 'background:#f0f0f0; color:#333; padding:10px; border-radius:5px; margin-bottom:10px; margin-right:30px;';
        botMsg.innerHTML = '<p style="margin:0; font-size:13px;">Thanks for your message! Our team will respond shortly. For urgent queries, please use WhatsApp.</p>';
        messagesDiv.appendChild(botMsg);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }, 500);
    
    input.value = '';
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

// Send message on Enter key
document.addEventListener('DOMContentLoaded', function() {
    const chatInput = document.getElementById('chat-input');
    if (chatInput) {
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') sendChatMessage();
        });
    }
});
</script>

<?php wp_footer(); ?>
</body>
</html>