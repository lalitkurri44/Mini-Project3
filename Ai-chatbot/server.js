// backend/server.js
import express from "express";
import fetch from "node-fetch";
import cors from "cors";
import dotenv from "dotenv";
import rateLimit from "express-rate-limit";

dotenv.config();
const app = express();
app.use(express.json());
app.use(cors({ origin: true })); // in production replace with your domain

const PORT = process.env.PORT || 4000;
const OPENROUTER_KEY = process.env.OPENROUTER_API_KEY;

// Rate limiting to avoid abuse
app.use("/api/chat", rateLimit({ windowMs: 60_000, max: 30 }));

app.post("/api/chat", async (req, res) => {
  try {
    const { question, history } = req.body;
    if (!question) return res.status(400).json({ error: "Missing 'question' in body" });

    // Build messages array: include optional history if provided (keep small)
    const messages = [
      { role: "system", content: "You are a helpful stock assistant. Be concise and truthful." }
    ];
    if (Array.isArray(history)) {
      // include last few messages only
      history.slice(-8).forEach(m => messages.push(m));
    }
    messages.push({ role: "user", content: question });

    // Call OpenRouter (DeepSeek)
    const response = await fetch("https://openrouter.ai/api/v1/chat/completions", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${OPENROUTER_KEY}`,
        // optional headers
        "HTTP-Referer": "http://localhost:4000",
        "X-Title": "Stock Chatbot AI"
      },
      body: JSON.stringify({
        model: "deepseek/deepseek-chat",
        messages,
        // tuning params:
        max_tokens: 600,
        temperature: 0.2
      })
    });

    const data = await response.json();

    // OpenRouter/adapter responses may vary; handle common shapes
    // Try common OpenAI-like structure first:
    let replyText = null;
    try {
      if (data?.choices && data.choices[0]?.message?.content) {
        replyText = data.choices[0].message.content;
      } else if (data?.output) {
        // some adapters return output
        replyText = Array.isArray(data.output) ? data.output.join("\n") : data.output;
      } else if (data?.choices && data.choices[0]?.text) {
        replyText = data.choices[0].text;
      }
    } catch (e) {
      // ignore parsing error
    }

    if (!replyText) {
      // fallback: stringify response for debugging
      replyText = JSON.stringify(data);
    }

    return res.json({ reply: replyText, raw: data });
  } catch (err) {
    console.error("Backend error:", err);
    return res.status(500).json({ error: "Server error" });
  }
});

app.listen(PORT, () => console.log(`✅ Backend running on http://localhost:${PORT}`));