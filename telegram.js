export default async function handler(req, res) {
  if (req.method !== "POST") {
    return res.status(405).json({ error: "Faqat POST so‘rovi ruxsat etiladi" });
  }

  const { name, phone, pixel } = req.body;

  const token = "7522239457:AAHTSgzT2n48lnDU4RhwYTsLysoLIelkbSI";
  const chat_id = "-1002180572908";

  const message = `Имя: ${name}\nТелефон: ${phone}`;

  const url = `https://api.telegram.org/bot${token}/sendMessage`;

  try {
    const telegramRes = await fetch(url, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        chat_id,
        text: message,
      }),
    });

    const data = await telegramRes.json();

    if (data.ok) {
      // Agar kerak bo‘lsa — frontend thankyou sahifaga yo‘naltirsin
      res.status(200).json({
        success: true,
        redirect: `/thankyou.html?name=${name}&phone=${phone}&pixel=${pixel}`,
      });
    } else {
      res
        .status(500)
        .json({ success: false, error: "Telegramga yuborib bo‘lmadi" });
    }
  } catch (error) {
    res.status(500).json({ success: false, error: "Server xatosi" });
  }
}
