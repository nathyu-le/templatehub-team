import { $ } from "../helpers/dom.js";

export const initQtyControl = () => {
  document.addEventListener("click", (e) => {
    const minus = e.target.closest("[data-qty-minus]");
    const plus = e.target.closest("[data-qty-plus]");
    if (!minus && !plus) return;

    const wrap = e.target.closest("[data-qty]");
    if (!wrap) return;

    const input = $("input", wrap);
    if (!input) return;

    const cur = parseInt(input.value || "1", 10);
    input.value = plus ? cur + 1 : Math.max(1, cur - 1);
    input.dispatchEvent(new Event("change", { bubbles: true }));
  });
};