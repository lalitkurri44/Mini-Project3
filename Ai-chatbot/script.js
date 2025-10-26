// frontend/script.js
const inputEl = document.getElementById("user-input");
const chatBox = document.getElementById("chat-box");

// Optional: store history for context
let history = [{ role: "system", content: "You are a helpful stock assistant." }];

async function sendMessage() {
  const text = inputEl.value.trim();
  if (!text) return;

  // Show user message
  addMessage("user", text);
  inputEl.value = "";

  // Show typing indicator
  const typingEl = addMessage("bot", "Bot is typing...", true);

  // Push to history
  history.push({ role: "user", content: text });

  try {
    const resp = await fetch("http://localhost:4000/api/chat", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ question: text, history })
    });

    const json = await resp.json();

    // Remove typing indicator
    typingEl.remove();

    if (json.error) {
      addMessage("bot", `Error: ${json.error}`);
      return;
    }

    const reply = json.reply || "No reply from AI";
    addMessage("bot", reply);
    history.push({ role: "assistant", content: reply });

  } catch (err) {
    typingEl.remove();
    addMessage("bot", "⚠️ Network error");
    console.error(err);
  }

  // Scroll to bottom
  chatBox.scrollTop = chatBox.scrollHeight;
}

// Helper to add message to chatbox
function addMessage(sender, text, returnElement = false) {
  const msgDiv = document.createElement("div");
  msgDiv.classList.add("message", sender);
  msgDiv.innerHTML = `<b>${sender === "user" ? "You" : "Bot"}:</b> ${escapeHtml(text)}`;
  chatBox.appendChild(msgDiv);
  chatBox.scrollTop = chatBox.scrollHeight;
  if (returnElement) return msgDiv;
}

// Escape HTML to avoid injection
function escapeHtml(s) {
  return s
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;");
}
