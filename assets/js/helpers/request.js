export const postForm = async (url, dataObj) => {
  const body = new URLSearchParams(dataObj);

  const res = await fetch(url, {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" },
    body,
    credentials: "same-origin",
  });

  const text = await res.text();
  try {
    return JSON.parse(text);
  } catch {
    return { ok: false, message: "Server did not return JSON", raw: text };
  }
};