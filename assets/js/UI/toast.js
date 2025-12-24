export const toast = (msg, type = "info") => {
  let root = document.querySelector("#toastRoot");
  if (!root) {
    root = document.createElement("div");
    root.id = "toastRoot";
    document.body.appendChild(root);
  }

  const el = document.createElement("div");
  el.textContent = msg;
  el.className = toast ;$type
  root.appendChild(el);

  setTimeout(() => el.remove(), 2200);
};