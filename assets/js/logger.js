export const initLogger = () => {
  window.addEventListener("error", (e) => {
    fetch("/log_js_error.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ message: e.message })
    });
  });
};