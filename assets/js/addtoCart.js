import { postForm } from "../helpers/request.js";
import { toast } from "../UI/toast.js";

export const initAddToCart = () => {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest("[data-add-cart]");
    if (!btn) return;

    e.preventDefault();

    const productId = btn.dataset.addCart;
    btn.disabled = true;

    const data = await postForm("/cart_add_ajax.php", {
      product_id: productId,
      qty: 1
    });

    btn.disabled = false;

    data.ok
      ? toast("Added to cart", "ok")
      : toast("Add failed", "err");
  });
};